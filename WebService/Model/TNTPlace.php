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


namespace TNTFrance\WebService\Model;

/**
 * Class TNTPlace
 * @package TNTFrance\WebService\Model
 * @author Julien Chanséaume <julien@thelia.net>
 *
 * @method getName()
 * @method setName($name)
 * @method getAddress1()
 * @method setAddress1($address1)
 * @method getCity()
 * @method setCity($city)
 * @method getZipCode()
 * @method setZipCode($zipCode)
 * @method getGeolocalisationUrl()
 * @method setGeolocalisationUrl($geolocalisationUrl)
 * @method getOpeningHours()
 * @method setOpeningHours($openingHours)
 * @method getLatitude()
 * @method setLatitude($latitude)
 * @method getLongitude()
 * @method setLongitude($longitude)
 */
class TNTPlace extends BaseModel
{
    protected $name;
    protected $address1;
    protected $city;
    protected $zipCode;
    protected $geolocalisationUrl;
    protected $openingHours;
    protected $latitude;
    protected $longitude;
}
