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
 * Class TNTExpedition
 * @package TNTFrance\WebService\Model
 * @author Julien Chanséaume <julien@thelia.net>
 *
 * @method getPdfLabels()
 * @method setPdfLabels($pdfLabels)
 * @method getPickUpNumber()
 * @method setPickUpNumber($pickUpNumber)
 * @method getParcelResponses()
 * @method setParcelResponses(array $parcelResponses)
 *
 */
class TNTExpedition extends BaseModel
{
    protected $pdfLabels;

    protected $pickUpNumber;

    protected $parcelResponses;

}
