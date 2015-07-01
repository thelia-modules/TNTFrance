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

use TNTFrance\WebService\Model\TNTDepot;

/**
 * Class TntDepots
 * @package TNTFrance\WebService
 * @author Julien Chanséaume <julien@thelia.net>
 */
class TntDepots extends BaseTNTFranceWebService
{
    protected $department;

    public function __construct($department = null)
    {
        parent::__construct('tntDepots');

        $this->department = $department;
    }

    public function getRequestArgs()
    {
        return [
            'department' => $this->getDepartment()
        ];
    }

    public function getFormattedResponse(\stdClass $response)
    {
        $depots = [];

        if (property_exists($response, 'DepotInfo')) {
            $nb = count($response->DepotInfo);

            if ($nb > 1) {
                foreach ($response->DepotInfo as $depot) {
                    $depots[] = $this->getTNTDepot($depot);
                }
            } elseif ($nb == 1) {
                $depots[] = $this->getTNTDepot($response->DepotInfo);
            }
        }

        return $depots;
    }

    protected function getTNTDepot(\stdClass $depot)
    {
        $tntDepot = new TNTDepot();
        $tntDepot
            ->setPexCode($depot->pexCode)
            ->setName($depot->name)
            ->setMessage($depot->message)
            ->setAddress1($depot->address1)
            ->setAddress2((isset($depot->address2))?$depot->address2:"")
            ->setCity($depot->city)
            ->setZipCode($depot->zipCode)
            ->setGeolocalisationUrl($depot->geolocalisationUrl)
            ->setLatitude($depot->latitude)
            ->setLongitude($depot->longitude);

        $openingHours = [
            0 => [$depot->openingHours->sunday->am, $depot->openingHours->sunday->pm],
            1 => [$depot->openingHours->monday->am, $depot->openingHours->monday->pm],
            2 => [$depot->openingHours->tuesday->am, $depot->openingHours->tuesday->pm],
            3 => [$depot->openingHours->wednesday->am, $depot->openingHours->wednesday->pm],
            4 => [$depot->openingHours->friday->am, $depot->openingHours->friday->pm],
            5 => [$depot->openingHours->thursday->am, $depot->openingHours->thursday->pm],
            6 => [$depot->openingHours->saturday->am, $depot->openingHours->saturday->pm]
        ];

        $tntDepot->setOpeningHours($openingHours);

        return $tntDepot;
    }

    /**
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param string $department
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }
}
