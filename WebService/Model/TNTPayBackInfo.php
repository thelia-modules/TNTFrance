<?php
/**
 * Created by PhpStorm.
 * User: gbarral
 * Date: 08/06/15
 * Time: 11:39
 */

namespace TNTFrance\WebService\Model;

/**
 * Class TNTPayBackInfo
 * @package TNTFrance\WebService\Model
 *
 * @method TNTSender getUseSenderAddress()
 * @method TNTSender getPaybackAmount()
 * @method TNTSender getName()
 * @method TNTSender getAddress1()
 * @method TNTSender getAddress2()
 * @method TNTSender getZipCode()
 * @method TNTSender getCity()
 * @method TNTSender setUseSenderAddress($useSenderAddress)
 * @method TNTSender setPaybackAmount($paybackAmount)
 * @method TNTSender setName($name)
 * @method TNTSender setAddress1($address1)
 * @method TNTSender setAddress2($address2)
 * @method TNTSender setZipCode($zipCode)
 * @method TNTSender setCity($city)
 */
class TNTPayBackInfo extends BaseModel
{
    protected $useSenderAddress = 0;
    protected $paybackAmount;
    protected $name;
    protected $address1;
    protected $address2;
    protected $zipCode;
    protected $city;
}
