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
 * Class TNTParcelResponse
 * @package TNTFrance\WebService\Model
 * @author Julien Chanséaume <julien@thelia.net>
 *
 * @method getSequenceNumber()
 * @method getParcelNumber()
 * @method getTrackingURL()
 * @method getStickerNumber()
 *
 * @method setSequenceNumber($sequenceNumber)
 * @method setParcelNumber($parcelNumber)
 * @method setTrackingURL($trackingURL)
 * @method setStickerNumber($stickerNumber)
 *
 */
class TNTParcelResponse extends BaseModel
{
    protected $sequenceNumber;
    protected $parcelNumber;
    protected $trackingURL;
    protected $stickerNumber;
}
