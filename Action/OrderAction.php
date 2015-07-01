<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/


namespace TNTFrance\Action;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\Translation\Translator;
use Thelia\Model\Address;
use Thelia\Model\Order;
use TNTFrance\Model\Config\TNTFranceConfigValue;
use TNTFrance\TNTFrance;
use TNTFrance\Tools\DataValidator;
use TNTFrance\WebService\Feasibility;

/**
 * Class OrderAction
 * @package TNTFrance\Action
 * @author Julien Chanséaume <julien@thelia.net>
 */
class OrderAction implements EventSubscriberInterface
{
    /** @var Request */
    protected $request;

    /** @var TNTFrance */
    protected $module;

    /** @var Translator $translator */
    protected $translator;

    protected $domain;

    /** @var  ContainerInterface $container */
    protected $container;

    public function __construct(Request $request, TNTFrance $module, Translator $translator, ContainerInterface $container)
    {
        $this->request = $request;
        $this->module = $module;
        $this->translator = $translator;
        $this->domain = $module::MESSAGE_DOMAIN;
        $this->container = $container;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function saveExtraInformation(&$data, Order $order, Address $address)
    {
        $service = $this->getRequest()->request->get("tnt_service");

        //By default, if no service is selected, choose the INDIVIDUAL ONE
        if (!in_array($service, ['INDIVIDUAL', 'ENTERPRISE', 'DEPOT', 'DROPOFFPOINT'])) {

            $this->getRequest()->request->set('tnt_service', 'INDIVIDUAL');
            $data['tnt_service'] = 'INDIVIDUAL';

            TNTFrance::setExtraOrderData($this->getRequest()->getSession()->getSessionCart()->getId(), $data);

            /** @var \Thelia\Model\Customer $customer */
            if (null == $customer = $order->getCustomer()) {
                //Customer in front
                $customer = $this->getRequest()->getSession()->getCustomerUser();
            }

            //We must ask fasaibility to tnt
            /** @var Feasibility $ws */
            $ws = $this->container->get('tnt.ws.factory')->get('feasibility');
            $ws
                ->setZipCode($customer->getDefaultAddress()->getZipcode())
                ->setCity($customer->getDefaultAddress()->getCity())
                ->setType($data['tnt_service'])
            ;

            $choices = $ws->exec();

            if (count($choices) > 0) {
                /** @var \TNTFrance\WebService\Model\TNTService $tntService */
                $tntService = $choices[0];

                $this->getRequest()->request->set(
                    'tnt_serviceCode',
                    $tntService->getServiceCode().'-'.$tntService->getServiceLabel()
                );
            }



            if ($customer->getDefaultAddress()->getCellphone()) {
                $phoneNumber = $customer->getDefaultAddress()->getCellphone();
            } elseif ($customer->getDefaultAddress()->getPhone()) {
                $phoneNumber = $customer->getDefaultAddress()->getPhone();
            } else {
                throw new \Exception($this->trans('You must have a phone number to continue this order'));
            }
            $this->getRequest()->request->set('tnt_phoneNumber', str_replace(" ", "", $phoneNumber));
            $service = 'INDIVIDUAL';
            //throw new \Exception($this->trans('Invalid TNT service'));


        }

        switch ($service) {
            case 'INDIVIDUAL':
                if (null !== $city = $this->getRequest()->request->get('tnt_city')) {
                    $address
                        ->setCity($city)
                        ->save();
                }

                $fields = [
                    'tnt_phoneNumber',
                    'tnt_accessCode',
                    'tnt_floorNumber',
                    'tnt_buldingId',
                ];

                break;
            case 'ENTERPRISE':
                if (null !== $city = $this->getRequest()->request->get('tnt_city')) {
                    $address
                        ->setCity($city)
                        ->save();
                }

                $fields = [
                    'tnt_instructions',
                ];

                break;
            case 'DEPOT':
                $fields = [
                    'tnt_pexCode',
                    'tnt_city',
                    'tnt_instructions',
                    'tnt_depot_address'
                ];

                break;
            case 'DROPOFFPOINT':
                $fields = [
                    'tnt_xettCode',
                    'tnt_contactLastName',
                    'tnt_contactFirstName',
                    'tnt_dop_address'
                ];

                break;

            default:
                $fields = [];

                break;
        }

        foreach ($fields as $field) {
            $value = $this->getRequest()->request->get($field);

            if (in_array($field, ['tnt_dop_address', 'tnt_depot_address'])) {
                $data[$field] = json_decode($value);
            } else {
                $data[$field] = $value;
            }

        }

        // save the service code selected
        $serviceInfos = explode('-', $this->getRequest()->request->get("tnt_serviceCode"));
        $data["tnt_serviceCode"] = $serviceInfos[0];
        $data["tnt_serviceLabel"] = $serviceInfos[1];

        $errors = DataValidator::validateData($data, $service);

        if (count($errors)) {
            $message = '';
            foreach ($errors as $error) {
                $message .= $error->getMessage() . '<br>';
            }
            throw new \Exception($message);
        }
    }



    public function setModuleDelivery(OrderEvent $event)
    {
        if ($event->getDeliveryModule() == TNTFrance::getModuleId()) {

            $request = $this->getRequest();
            $id = $request->getSession()->getSessionCart()->getId();
            $address = TNTFrance::getCartDeliveryAddress($this->getRequest());

            $data = TNTFrance::getExtraOrderData($id);

            try {
                $this->saveExtraInformation($data, $event->getOrder(), $address);
            } catch (\Exception $ex) {
                throw $ex;
            }

            TNTFrance::setExtraOrderData($id, $data);
        }
    }

    public function setOrderDelivery(OrderEvent $event)
    {
        if ($event->getOrder()->getDeliveryModuleId() == TNTFrance::getModuleId()) {
            // we have the order id
            $data = TNTFrance::getExtraOrderData($event->getOrder()->getCartId());
            TNTFrance::setExtraOrderData($event->getOrder()->getId(), $data, false);
        }
    }

    protected function trans($id, $parameters = [])
    {
        if (null === $this->translator) {
            $this->translator = Translator::getInstance();
        }

        return $this->translator->trans($id, $parameters, $this->domain);
    }


    public static function getSubscribedEvents()
    {
        return array(
            TheliaEvents::ORDER_SET_DELIVERY_MODULE => array('setModuleDelivery', 64),
            TheliaEvents::ORDER_BEFORE_PAYMENT => array('setOrderDelivery', 256)
        );
    }

}
