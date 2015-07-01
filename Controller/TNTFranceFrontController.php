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


namespace TNTFrance\Controller;

use Thelia\Controller\Front\BaseFrontController;
use Thelia\Model\Address;
use Thelia\Model\Customer;
use TNTFrance\TNTFrance;
use TNTFrance\WebService\CitiesGuide;
use TNTFrance\WebService\DropOffPoints;
use TNTFrance\WebService\Feasibility;
use TNTFrance\WebService\TntDepots;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TNTFranceFront
 * @package TNTFrance\Controller
 * @author Julien Chanséaume <julien@thelia.net>
 */
class TNTFranceFrontController extends BaseFrontController
{
    /** @var bool Fallback on default template when setting the templateDefinition */
    protected $useFallbackTemplate = true;

    public function configurationAction($service)
    {
        $this->checkAuth();

        $this->checkXmlHttpRequest();

        $address = TNTFrance::getCartDeliveryAddress($this->getRequest());

        $data = TNTFrance::getExtraOrderData($this->getSession()->getSessionCart()->getId());
        $this->initializeData($data, $address);

        $params = [
            'unavailable' => false,
            'feasibility' => false
        ];

        switch ($service) {
            case 'INDIVIDUAL':
                $this->checkIndividual($params, $address, $data);
                break;
            case 'ENTERPRISE':
                $this->checkEnterprise($params, $address, $data);
                break;
            case 'DEPOT':
                $this->checkDepot($params, $address, $data);
                break;
            case 'DROPOFFPOINT':
                $this->checkDropOffPoint($params, $address, $data);
                break;
            default:
        }

        $choices = [];

        /*
        if ($params['feasibility']) {
            /** @var Feasibility $ws *
            $ws = $this->getWebService('feasibility');
            $ws
                ->setZipCode($params['feasibility_zipcode'])
                ->setCity($params['feasibility_city'])
                ->setType($service);
            $choices = $ws->exec();

            if (!$params['unavailable']) {
                // todo getpostage ?
            }
        }
        */


        // render
        return $this->render(
            sprintf('ajax-delivery-%s', strtolower($service)),
            [
                'params' => $params,
                'data' => $data,
                'choices' => $choices,
            ]
        );
    }

    public function saveConfigurationAction()
    {
        $this->checkAuth();

        $this->checkXmlHttpRequest();


        $customer = $this->getSecurityContext()->getCustomerUser();
        $address = TNTFrance::getCartDeliveryAddress($this->getRequest());
        $order = $this->getSession()->getOrder();
        $data = TNTFrance::getExtraOrderData($this->getSession()->getSessionCart()->getId());

        if ($address->getCustomerId() !== $customer->getId()) {
            $this->accessDenied();
        }

        if (null !== $city = $this->getRequest()->request->get('tnt_city')) {
            $address
                ->setCity($city)
                ->save();
        }

        $fields = [
            'tnt_service',

            'tnt_instructions',
            'tnt_contactLastName',
            'tnt_contactFirstName',
            'tnt_emailAdress',
            'tnt_phoneNumber',
            'tnt_accessCode',
            'tnt_floorNumber',
            'tnt_buldingId',
            'tnt_sendNotification',

            'tnt_pexcode',
            'tnt_depot_zipcode',
            'tnt_depot_city',
            'tnt_depot_address',

            'tnt_xettcode',
            'tnt_dop_zipcode',
            'tnt_dop_city',
            'tnt_dop_address',
        ];

        foreach ($fields as $field) {
            $value = $this->getRequest()->request->get($field);
            if (null !== $value) {
                if (in_array($field, ['tnt_dop_address', 'tnt_depot_address'])) {
                    $data[$field] = json_decode($value, true);
                } else {
                    $data[$field] = $value;
                }
            }
        }

        TNTFrance::setExtraOrderData($this->getSession()->getSessionCart()->getId(), $data);

        // get feasibility

        $params = [
            'unavailable' => false,
            'feasibility' => false
        ];

        switch ($data['tnt_service']) {
            case 'INDIVIDUAL':
                $this->checkIndividual($params, $address, $data);
                break;
            case 'ENTERPRISE':
                $this->checkEnterprise($params, $address, $data);
                break;
            case 'DEPOT':
                $this->checkDepot($params, $address, $data);
                break;
            case 'DROPOFFPOINT':
                $this->checkDropOffPoint($params, $address, $data);
                break;
            default:
        }

        $out = [
            'status' => 0,
            'content' => ''
        ];

        $choices = [];
        if ($params['feasibility']) {
            /** @var Feasibility $ws */
            $ws = $this->getWebService('feasibility');
            $ws
                ->setZipCode($params['feasibility_zipcode'])
                ->setCity($params['feasibility_city'])
                ->setType($data['tnt_service'])
            ;

            $choices = $ws->exec();
        }

        $out["status"] = count($choices);
        $out["content"] = $this->renderRaw('ajax-feasibility', ['choices' => $choices]);

        return $this->jsonResponse(json_encode($out));
    }

    public function searchCitiesAction($zipCode)
    {
        $this->checkAuth();

        $this->checkXmlHttpRequest();

        $cities = $this->getCities($zipCode);

        return $this->jsonResponse(json_encode($cities));
    }

    public function searchDepotAction($department)
    {
        $this->checkAuth();

        $this->checkXmlHttpRequest();

        $places = $this->getDepots($department);

        return $this->render('ajax-search-depot', ['places' => $places]);
    }

    public function searchDropOffPointAction($zipCode, $city)
    {
        $this->checkAuth();

        $this->checkXmlHttpRequest();

        $places = $this->getDropOffPoints($zipCode, $city);

        return $this->render('ajax-search-dropoffpoint', ['places' => $places]);
    }

    protected function checkIndividual(&$params, Address $address, $data)
    {
        if ($this->checkCity($params, $address)) {
            $params['feasibility'] = true;
            $params['feasibility_zipcode'] = $address->getZipcode();
            $params['feasibility_city'] = $address->getCity();
        }
    }

    protected function checkEnterprise(&$params, Address $address, $data)
    {
        if ($this->checkCity($params, $address)) {
            $params['feasibility'] = true;
            $params['feasibility_zipcode'] = $address->getZipcode();
            $params['feasibility_city'] = $address->getCity();
        }
    }

    protected function checkDepot(&$params, Address $address, $data)
    {
        if (!empty($data['tnt_pexcode'])) {
            $params['feasibility'] = true;
            $params['feasibility_zipcode'] = $data['tnt_depot_zipcode'];
            $params['feasibility_city'] = $data['tnt_depot_city'];
        }
    }

    protected function checkDropOffPoint(&$params, Address $address, $data)
    {
        if (!empty($data['tnt_xettcode'])) {
            $params['feasibility'] = true;
            $params['feasibility_zipcode'] = $data['tnt_dop_zipcode'];
            $params['feasibility_city'] = $data['tnt_dop_city'];
        }
    }

    protected function checkCity(&$params, Address $address)
    {
        $cities = $this->getCities($address->getZipcode());

        if (!in_array($address->getCity(), $cities)) {
            $params['cities'] = $cities;

            return false;
        }

        return true;
    }

    protected function getCities($zipCode)
    {
        /** @var CitiesGuide $ws */
        $ws = $this->getWebService('citiesGuide');
        $ws->setZipCode($zipCode);

        $cities = $ws->exec();

        return $cities;
    }

    protected function getDepots($department)
    {
        /** @var TntDepots $ws */
        $ws = $this->getWebService('tntDepots');

        $ws->setDepartment($department);
        $places = $ws->exec();

        return $places;
    }

    protected function getDropOffPoints($zipCode, $city)
    {
        /** @var DropOffPoints $ws */
        $ws = $this->getWebService('dropOffPoints');
        $ws->setZipCode($zipCode);
        $ws->setCity($city);

        $places = $ws->exec();

        return $places;
    }

    protected function initializeData(&$data, Address $address)
    {
        $defaults = [
            'tnt_service' => '',
            'tnt_contactLastName' => $address->getLastname(),
            'tnt_contactFirstName' => $address->getFirstname(),
            'tnt_emailAdress' => $address->getCustomer()->getEmail(),
            'tnt_phoneNumber' => $address->getPhone(),
            'tnt_zipCode' => $address->getZipcode(),
            'tnt_city' => $address->getCity(),
            'tnt_department' => $this->getDepartmentFromZipCode($address->getZipcode()),
        ];

        foreach ($defaults as $varKey => $varVal) {
            if (empty($data[$varKey])) {
                $data[$varKey] = $varVal;
            }
        }
    }

    protected function getWebService($name)
    {
        return $this->getContainer()->get('tnt.ws.factory')->get($name);
    }

    protected function getDepartmentFromZipCode($cp)
    {
        $cp = str_pad(str_replace(' ', '', $cp), 5, '0', STR_PAD_LEFT);

        $depCode = substr($cp, 0, 2);

        if ($depCode == '20') {
            if ((int)$cp < 20200 || in_array((int)$cp, array(20223, 20900))) {
                $depCode = '2A';
            } else {
                $depCode = '2B';
            }
        }

        if ((int)$depCode > 95) {
            $depCode = substr($cp, 0, 3);
        }

        return $depCode;
    }
    public function setDeliveryAddressAction()
    {
        $this->checkAuth();
        $this->checkXmlHttpRequest();

        $addressId = $this->getRequest()->query->get('address');
        $this->getSession()->getOrder()->setChoosenDeliveryAddress($addressId);
        //$this->getSession()->getSessionCart()->setAddressDeliveryId($addressId);

        return new Response('done');
    }

}
