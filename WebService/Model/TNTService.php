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
 * Class TNTService
 * @package TNTFrance\WebService\Model
 * @author Julien Chanséaume <julien@thelia.net>
 *
 * @method getDueDate()
 * @method getServiceLabel()
 * @method getServiceCode()
 * @method getSaturdayDelivery()
 * @method getPriorityGuarantee()
 * @method getInsurance()
 * @method getAfternoonDelivery()
 * @method setDueDate(\DateTime $dueDate)
 * @method setServiceLabel($serviceLabel)
 * @method setServiceCode($serviceCode)
 * @method setSaturdayDelivery($saturdayDelivery)
 * @method setPriorityGuarantee($priorityGuarantee)
 * @method setInsurance($insurance)
 * @method setAfternoonDelivery($afternoonDelivery)
 */
class TNTService extends BaseModel
{
    /** @var \Datetime  */
    protected $dueDate;
    /** @var string */
    protected $serviceLabel;
    /** @var string */
    protected $serviceCode;
    /** @var boolean */
    protected $saturdayDelivery;
    /** @var boolean */
    protected $priorityGuarantee;
    /** @var boolean */
    protected $insurance;
    /** @var boolean */
    protected $afternoonDelivery;
}
