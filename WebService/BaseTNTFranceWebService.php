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

use SoapHeader;
use SoapVar;
use TNTFrance\WebService\Provider\ConfigProviderInterface;

/**
 * Class BaseTNTFranceWebService
 * @package TNTFrance\WebService
 * @author Julien Chanséaume <julien@thelia.net>
 */
abstract class BaseTNTFranceWebService extends BaseWebService
{
    /** @var  ConfigProviderInterface */
    protected $config;

    public function __construct($function)
    {
        parent::__construct($function);
    }

    public function getSoapUrl()
    {
        return $this->config->getWsdlUrl();
    }

    public function getSoapOptions()
    {
        return [
            'trace' => 1,
            'stream_context' => stream_context_create(
                [
                    'http' => [
                        'user_agent' => 'PHP/SOAP',
                        'accept' => 'application/xml'
                    ]
                ]
            )
        ];
    }

    public function getSoapHeaders()
    {
        $authHeader = sprintf(
            '<wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
              <wsse:UsernameToken>
                <wsse:Username>%s</wsse:Username>
                <wsse:Password>%s</wsse:Password>
             </wsse:UsernameToken>
            </wsse:Security>',
            htmlspecialchars($this->config->getUsername()),
            htmlspecialchars($this->config->getPassword())
        );

        $authVars = new SoapVar($authHeader, XSD_ANYXML);
        $header = new SoapHeader(
            "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd",
            "Security",
            $authVars
        );

        return [$header];
    }

    /**
     * @return ConfigProviderInterface
     */
    public function getConfigProvider()
    {
        return $this->config;
    }

    /**
     * @param ConfigProviderInterface $configProvider
     */
    public function setConfigProvider(ConfigProviderInterface $configProvider)
    {
        $this->config = $configProvider;
        return $this;
    }
}
