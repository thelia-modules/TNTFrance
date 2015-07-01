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


namespace TNTFrance\WebService;

use SoapFault;

/**
 * Class BaseWebService
 * @package TNTFrance\WebService
 * @author Julien Chanséaume <julien@thelia.net>
 */
abstract class BaseWebService
{
    protected $soap;
    protected $soapWsdl;
    protected $soapFunction;
    protected $ex;

    public function __construct($soapFunction)
    {
        $this->soapFunction = $soapFunction;
    }

    public function exec()
    {
        $this->soap = new \SoapClient($this->getSoapUrl(), $this->getSoapOptions());
        if (null !== $this->getSoapHeaders()) {
            $this->soap->__setSoapHeaders($this->getSoapHeaders());
        }

        $function = $this->soapFunction;
        $response = null;

        try {
            $response = $this->soap->$function($this->getRequestArgs());
        } catch(\SoapFault $e) {
            $this->ex = $e;

            throw $e;
        } catch(\Exception $e) {
            $this->ex = $e;

            throw $e;
        }

        return $this->getFormattedResponse($response);
    }

    abstract public function getSoapUrl();

    abstract public function getSoapOptions();

    abstract public function getSoapHeaders();

    abstract public function getRequestArgs();

    abstract public function getFormattedResponse(\stdClass $response);
}
