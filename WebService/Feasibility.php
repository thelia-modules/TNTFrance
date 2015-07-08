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


namespace TNTFrance\WebService;

use TNTFrance\WebService\Model\TNTService;

/**
 * Class Feasibility
 * @package TNTFrance\WebService
 * @author Julien Chanséaume <julien@thelia.net>
 */
class Feasibility extends BaseTNTFranceWebService
{


    /** @var string */
    protected $zipCode;

    /** @var string */
    protected $city;

    /** @var string */
    protected $type;

    public function __construct($zipCode = null, $city = null, $type = null)
    {
        parent::__construct('feasibility');

        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->type = $type;
    }

    public function getRequestArgs()
    {
        return [
            'parameters' => [
                'accountNumber' => $this->config->getAccountNumber(),
                'shippingDate' => $this->config->getShippingDate(),
                'sender' => $this->config->getSender()->toArray(['zipCode', 'city']),
                'receiver' => [
                    'zipCode' => $this->zipCode,
                    'city' => $this->city,
                    'type' => $this->type,
                ]
            ]
        ];
    }

    public function getFormattedResponse(\stdClass $response)
    {
        $services = [];

        if (property_exists($response, 'Service')) {
            $nb = count($response->Service);

            if ($nb > 1) {
                foreach ($response->Service as $service) {
                    $this->getTNTService($services, $service);
                }
            } elseif ($nb == 1) {
                $this->getTNTService($services, $response->Service);
            }
        }

        return $services;
    }

    protected function getTNTService(array &$services, \stdClass $service)
    {
        if ($this->isServiceEnabled($service->serviceCode)) {
            $tntService = new TNTService();
            $tntService
                ->setDueDate(new \DateTime($service->dueDate))
                ->setServiceLabel($service->serviceLabel)
                ->setServiceCode($service->serviceCode)
                ->setSaturdayDelivery($service->saturdayDelivery)
                ->setPriorityGuarantee($service->priorityGuarantee)
                ->setInsurance($service->insurance)
                ->setAfternoonDelivery($service->afternoonDelivery)
            ;

            $services[] = $tntService;
        }
    }

    /**
     * Test if a service can be used
     *
     * @param string $service the service code 1 or 2 char : 1 char for the product + 1 char for the option (optional)
     *
     * @return bool true if the service can be use
     */
    protected function isServiceEnabled($service)
    {
        $products = $this->config->getProductsEnabled();
        $options = $this->config->getOptionsEnabled();

        if (!in_array(substr($service, 0, 1), $products)) {
            return false;
        }

        if ((strlen($service) > 1) && !in_array(substr($service, 1, 1), $options)) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }
}
