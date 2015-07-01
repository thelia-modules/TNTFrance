<?php
/**
 * Created by PhpStorm.
 * User: gbarral
 * Date: 08/06/15
 * Time: 10:31
 */

namespace TNTFrance\WebService\Model;

/**
 * Class TNTPickUpRequest
 * @package TNTFrance\WebService\Model
 *
 * @method TNTSender getMedia()
 * @method TNTSender getFaxNumber()
 * @method TNTSender getEmailAddress()
 * @method TNTSender getNotifySuccess()
 * @method TNTSender getService()
 * @method TNTSender getLastName()
 * @method TNTSender getFirstName()
 * @method TNTSender getPhoneNumber()
 * @method TNTSender getClosingTime()
 * @method TNTSender getInstructions()
 * @method TNTSender setMedia($media)
 * @method TNTSender setFaxNumber($faxNumber)
 * @method TNTSender setEmailAddress($emailAddress)
 * @method TNTSender setNotifySuccess($notifySuccess)
 * @method TNTSender setService($service)
 * @method TNTSender setLastName($lastName)
 * @method TNTSender setFirstName($firstName)
 * @method TNTSender setPhoneNumber($phoneNumber)
 * @method TNTSender setClosingTime($closingTime)
 * @method TNTSender setInstructions($instructions)
 */
class TNTPickUpRequest extends BaseModel
{
    protected $media = 'EMAIL';
    protected $faxNumber;
    protected $emailAddress;
    protected $notifySuccess = 0;
    protected $service;
    protected $lastName;
    protected $firstName;
    protected $phoneNumber;
    protected $closingTime;
    protected $instructions;
}
