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
 * Class TNTParcelRequest
 * @package TNTFrance\WebService\Model
 * @author Julien Chanséaume <julien@thelia.net>
 *
 * @method getSequenceNumber()
 * @method getCustomerReference()
 * @method getWeight()
 * @method getInsuranceAmount()
 * @method getPriorityGuarantee()
 * @method getComment()
 * @method setSequenceNumber($sequenceNumber)
 * @method setCustomerReference($customerReference)
 * @method setWeight($weight)
 * @method setInsuranceAmount($insuranceAmount)
 * @method setPriorityGuarantee($priorityGuarantee)
 * @method setComment($comment)
 */
class TNTParcelRequest extends BaseModel
{
    protected $sequenceNumber;
    protected $customerReference;
    protected $weight;
    protected $insuranceAmount;
    protected $priorityGuarantee;
    protected $comment;
}
