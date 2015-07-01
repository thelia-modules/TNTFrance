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
 * Class TNTDepot
 * @package TNTFrance\WebService\Model
 * @author Julien Chanséaume <julien@thelia.net>
 *
 * @method setPexCode($pexCode)
 * @method getPexCode()
 * @method setAddress2($address2)
 * @method getAddress2()
 * @method setMessage($message)
 * @method getMessage()
 */
class TNTDepot extends TNTPlace
{
    protected $pexCode;
    protected $address2;
    protected $message;
}
