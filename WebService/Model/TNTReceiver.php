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
 * Class TNTReceiver
 * @package TNTFrance\WebService\Model
 * @author Julien Chanséaume <julien@thelia.net>
 *
 * @method getType()
 * @method setType($type)
 * @method getTypeId()
 * @method setTypeId($typeId)
 * @method getName()
 * @method setName($name)
 * @method getAddress1()
 * @method setAddress1($address1)
 * @method getAddress2()
 * @method setAddress2($address2)
 * @method getZipCode()
 * @method setZipCode($zipCode)
 * @method getCity()
 * @method setCity($city)
 * @method getInstructions()
 * @method setInstructions($instructions)
 * @method getContactLastName()
 * @method setContactLastName($contactLastName)
 * @method getContactFirstName()
 * @method setContactFirstName($contactFirstName)
 * @method getEmailAddress()
 * @method setEmailAddress($emailAddress)
 * @method getPhoneNumber()
 * @method setPhoneNumber($phoneNumber)
 * @method getAccessCode()
 * @method setAccessCode($accessCode)
 * @method getFloorNumber()
 * @method setFloorNumber($floorNumber)
 * @method getBuldingId()
 * @method setBuldingId($buldingId)
 * @method getSendNotification()
 * @method setSendNotification($sendNotification)
 */
class TNTReceiver extends BaseModel
{
    protected $type;
    protected $typeId;
    protected $name;
    protected $address1;
    protected $address2;
    protected $zipCode;
    protected $city;
    protected $instructions;
    protected $contactLastName;
    protected $contactFirstName;
    protected $emailAddress;
    protected $phoneNumber;
    protected $accessCode;
    protected $floorNumber;
    protected $buldingId;
    protected $sendNotification = 0;
}
