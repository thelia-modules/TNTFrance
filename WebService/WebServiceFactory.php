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

use Thelia\Exception\NotImplementedException;
use TNTFrance\WebService\Provider\ConfigProviderInterface;

/**
 * Class WebServiceFactory
 * @package TNTFrance\WebService
 * @author Julien Chanséaume <julien@thelia.net>
 */
class WebServiceFactory
{
    /** @var  ConfigProviderInterface */
    protected $configProvider;

    public function __construct(ConfigProviderInterface $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    /**
     * @param $webServiceName
     * @return BaseTNTFranceWebService
     */
    public function get($webServiceName)
    {
        /** @var BaseTNTFranceWebService $webService */
        $webService = null;

        switch ($webServiceName) {
            case 'feasibility':
                $webService = new Feasibility();
                break;
            case 'citiesGuide':
                $webService = new CitiesGuide();
                break;
            case 'dropOffPoints':
                $webService = new DropOffPoints();
                break;
            case 'tntDepots':
                $webService = new TntDepots();
                break;
            case 'createExpedition':
                $webService = new CreateExpedition();
                break;
            case 'trackingByConsignment':
            case 'trackingByReference':
            case 'pickUpRequestCreation':
            case 'pickUpRequestCancellation':
            default:
                throw new NotImplementedException();
        }

        $webService->setConfigProvider($this->configProvider);

        return $webService;
    }
}
