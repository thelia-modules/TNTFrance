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
 * Class TNTSender
 * @package TNTFrance\WebService\Model
 * @author Julien Chanséaume <julien@thelia.net>
 *
 * @method TNTSender getType()
 * @method TNTSender getTypeId()
 * @method TNTSender getName()
 * @method TNTSender getAddress1()
 * @method TNTSender getAddress2()
 * @method TNTSender getZipCode()
 * @method TNTSender getCity()
 * @method TNTSender getContactLastName()
 * @method TNTSender getContactFirstName()
 * @method TNTSender getEmailAddress()
 * @method TNTSender getPhoneNumber()
 * @method TNTSender getFaxNumber()
 * @method TNTSender setType($type)
 * @method TNTSender setTypeId($typeId)
 * @method TNTSender setName($name)
 * @method TNTSender setAddress1($address1)
 * @method TNTSender setAddress2($address2)
 * @method TNTSender setZipCode($zipCode)
 * @method TNTSender setCity($city)
 * @method TNTSender setContactLastName($contactLastName)
 * @method TNTSender setContactFirstName($contactFirstName)
 * @method TNTSender setEmailAddress($emailAddress)
 * @method TNTSender setPhoneNumber($phoneNumber)
 * @method TNTSender setFaxNumber($faxNumber)
 */
class TNTSender extends BaseModel
{
    protected $type;
    protected $typeId;
    protected $name;
    protected $address1;
    protected $address2;
    protected $zipCode;
    protected $city;
    protected $contactLastName;
    protected $contactFirstName;
    protected $emailAddress;
    protected $phoneNumber;
    protected $faxNumber;
}
