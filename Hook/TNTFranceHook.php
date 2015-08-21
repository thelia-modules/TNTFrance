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


namespace TNTFrance\Hook;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Model\OrderQuery;
use Thelia\Tools\URL;
use TNTFrance\TNTFrance;
use TNTFrance\WebService\Feasibility;
use TNTFrance\Model\Config\TNTFranceConfigValue;

/**
 * Class TNTFranceHook
 * @package TNTFrance\Hook
 * @author Julien Chanséaume <julien@thelia.net>
 */
class TNTFranceHook extends BaseHook
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onOrderDeliveryExtra(HookRenderEvent $event)
    {
        $address = TNTFrance::getCartDeliveryAddress($this->getRequest());
        if (null === $address) {
            return;
        }

        $cartWeight = $this->getCart()->getWeight();

        $isModuleSelected = false;
        if (null !== $order = $this->getOrder()) {
            $isModuleSelected = (TNTFrance::getModuleId() === $this->getOrder()->getDeliveryModuleId());
        }

        $data = TNTFrance::getExtraOrderData($this->getCart()->getId(), []);

        $company = $address->getCompany();
        $serviceSelected = null;

        if (array_key_exists('tnt_service',  $data)) {
            $serviceSelected = $data['tnt_service'];

            if (!in_array($serviceSelected, array('INDIVIDUAL','ENTERPRISE','DEPOT','DROPOFFPOINT'))) {
                $serviceSelected = 'INDIVIDUAL';
            }

            if ($serviceSelected == 'INDIVIDUAL' && !empty($company)) {
                $serviceSelected = 'ENTERPRISE';
            } elseif ($serviceSelected == 'ENTERPRISE' && empty($company)) {
                $serviceSelected = 'INDIVIDUAL';
            }
        }

        /** @var Feasibility $ws */
        /*
        $ws = $this->container->get('tnt.ws.factory')->get('feasibility');
        $choices = $ws->exec();
        */

        $event->add(
            $this->render(
                'order-delivery-extra.html',
                [
                    'postalCode' => $address->getZipcode(),
                    'city' => $address->getCity(),
                    'weight' => $cartWeight,
                    'is_module_selected' => $isModuleSelected,
                    'service_selected' => $serviceSelected,
                    'services' => TNTFranceConfigValue::getServices(),
                    'company' => $company,
                ]
            )
        );
    }

    public function onOrderDeliveryStyleSheet(HookRenderEvent $event)
    {
        $event->add($this->render('order-delivery-stylesheet.html'));
    }

    public function onOrderDeliveryAfterJavascriptInclude(HookRenderEvent $event)
    {
        //If cdn is ok
        $event->add($this->render('order-delivery-after-javascript-include.html'));
    }

    public function onOrderDeliveryJavascript(HookRenderEvent $event)
    {
        $event->add(
            $this->render(
                'order-delivery-javascript.html',
                [
                    'tnt_france_id' => TNTFrance::getModuleId()
                ]
            )
        );
    }

    public function onOrderDeliveryJavascriptInitialization(HookRenderEvent $event)
    {
        $event->add(
            $this->render(
                'order-delivery-javascript-initialization.html',
                [
                    'tnt_france_id' => TNTFrance::getModuleId()
                ]
            )
        );
    }

    public function onOrderInvoiceDeliveryAddress(HookRenderEvent $event)
    {
        $data = TNTFrance::getExtraOrderData($this->getCart()->getId());

        $event->add(
            $this->render('order-invoice-delivery-address.html', ['data' => $data])
        );
    }

    public function onPdfAddress(HookRenderEvent $event)
    {
        $data = TNTFrance::getExtraOrderData($event->getArgument('order'), false);
        $order = OrderQuery::create()->findPk($event->getArgument('order'));

        $event->add(
            $this->render(
                'delivery-address.html',
                [
                    'data' => $data,
                    'order_id' => $event->getArgument('order'),
                    'address_id' => $order->getDeliveryOrderAddressId()
                ]
            )
        );

    }

    public function onBackAddress(HookRenderEvent $event)
    {
        $data = TNTFrance::getExtraOrderData($event->getArgument('order_id'), false);
        $order = OrderQuery::create()->findPk($event->getArgument('order_id'));

        $event->add(
            $this->render(
                'delivery-address.html',
                [
                    'data' => $data,
                    'order_id' => $event->getArgument('order'),
                    'address_id' => $order->getDeliveryOrderAddressId()
                ]
            )
        );
    }

    public function onMainTopMenuTools(HookRenderBlockEvent $event)
    {
        foreach (TNTFrance::getAccounts() as $account) {
            $event->add([
                'id' => 'top-menu-tools-tntfrance-' . $account['id'],
                'url' => URL::getInstance()->absoluteUrl(
                    '/admin/module/TNTFrance/orders',
                    [
                        'account' => $account['id'],
                    ]
                ),
                'title' => $this->trans(
                    'TNT Orders - %account_label',
                    [
                        '%account_label' => $account['label'],
                    ],
                    TNTFrance::MESSAGE_DOMAIN
                ),
            ]);
        }
    }
}
