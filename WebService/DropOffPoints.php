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

use TNTFrance\WebService\Model\TNTDropOffPoint;

/**
 * Class DropOffPoints
 * @package TNTFrance\WebService
 * @author Julien Chanséaume <julien@thelia.net>
 */
class DropOffPoints extends BaseTNTFranceWebService
{

    protected $zipCode;

    protected $city;

    public function __construct($zipCode = null, $city = null)
    {
        parent::__construct('dropOffPoints');

        $this->zipCode = $zipCode;
        $this->city = $city;
    }

    public function getRequestArgs()
    {
        return [
            'zipCode' => $this->zipCode,
            'city' => $this->city,
        ];
    }

    public function getFormattedResponse(\stdClass $response)
    {
        $dropOffPoints = [];

        if (property_exists($response, 'DropOffPoint')) {
            $nb = count($response->DropOffPoint);
            if ($nb > 1) {
                foreach ($response->DropOffPoint as $dropOffPoint) {
                    $dropOffPoints[] = $this->getTNTDropOffPoint($dropOffPoint);
                }
            } elseif ($nb == 1) {
                $dropOffPoints[] = $this->getTNTDropOffPoint($response->DropOffPoint);
            }
        }

        return $dropOffPoints;
    }

    protected function getTNTDropOffPoint(\stdClass $dop)
    {
        $tntDropOffPoint = new TNTDropOffPoint();
        $tntDropOffPoint
            ->setXETTCode($dop->xETTCode)
            ->setName($dop->name)
            ->setAddress1($dop->address1)
            ->setCity($dop->city)
            ->setZipCode($dop->zipCode)
            ->setGeolocalisationUrl($dop->geolocalisationUrl)
            ->setLatitude($dop->latitude)
            ->setLongitude($dop->longitude);

        $openingHours = [
            0 => [$dop->openingHours->sunday->am, $dop->openingHours->sunday->pm],
            1 => [$dop->openingHours->monday->am, $dop->openingHours->monday->pm],
            2 => [$dop->openingHours->tuesday->am, $dop->openingHours->tuesday->pm],
            3 => [$dop->openingHours->wednesday->am, $dop->openingHours->wednesday->pm],
            4 => [$dop->openingHours->friday->am, $dop->openingHours->friday->pm],
            5 => [$dop->openingHours->thursday->am, $dop->openingHours->thursday->pm],
            6 => [$dop->openingHours->saturday->am, $dop->openingHours->saturday->pm]
        ];

        $tntDropOffPoint->setOpeningHours($openingHours);

        return $tntDropOffPoint;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }
}
