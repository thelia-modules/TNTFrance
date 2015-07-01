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

/**
 * Class CitiesGuide
 * @package TNTFrance\WebService
 * @author Julien Chanséaume <julien@thelia.net>
 *
 */
class CitiesGuide extends BaseTNTFranceWebService
{
    protected $zipCode;

    public function __construct($zipCode = null)
    {
        parent::__construct('citiesGuide');

        $this->zipCode = $zipCode;
    }

    public function getRequestArgs()
    {
        return [
            'zipCode' => $this->zipCode
        ];
    }

    public function getFormattedResponse(\stdClass $response)
    {
        $cities = [];

        if (property_exists($response, 'City')) {
            $nb = count($response->City);
            if ($nb > 1) {
                foreach ($response->City as $city) {
                    $cities[] = $city->name;
                }
            } else if ($nb == 1) {
                $city = $response->City;
                $cities[] = $city->name;
            }
        }

        return $cities;
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
