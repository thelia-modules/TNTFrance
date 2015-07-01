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

namespace TNTFrance\Tests\WebService;

use TNTFrance\WebService\BaseWebService;
use TNTFrance\WebService\Provider\TestConfigProvider;
use TNTFrance\WebService\WebServiceFactory;

/**
 * Class WebServiceTestCase
 * @author Julien Chanséaume <julien@thelia.net>
 */
abstract class WebServiceTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var WebServiceFactory */
    protected static $factory;

    protected $ws;

    public static function setUpBeforeClass()
    {
        $configProvider = new TestConfigProvider();
        self::$factory = new WebServiceFactory($configProvider);
    }

    public static function tearDownAfterClass()
    {
    }

    protected function setUp()
    {
        $this->ws = self::$factory->get($this->getWebServiceName());
    }

    protected function tearDown()
    {
        unset($this->ws);
    }


    /**
     * Return the web service instance
     */
    abstract protected function getWebService();

    /**
     * Return the web service name to use
     *
     * @return string
     */
    abstract protected function getWebServiceName();
}
