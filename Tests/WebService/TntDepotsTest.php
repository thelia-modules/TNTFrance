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

use TNTFrance\WebService\Model\TNTDepot;
use TNTFrance\WebService\TntDepots;

/**
 * Class TntDepotsTest
 * @package TNTFrance\Tests\WebService
 * @author Julien Chanséaume <julien@thelia.net>
 */
class TntDepotsTest extends WebServiceTestCase
{

    public function testSuccess()
    {
        $ws = $this->getWebService();
        $ws->setDepartment("63");

        $response = $ws->exec();

        $this->assertNotEmpty($response);
        $this->assertTrue($response[0] instanceof TNTDepot);
    }

    /**
     * @expectedException \SoapFault
     */
    public function testBadDepartment()
    {
        $ws = $this->getWebService();
        $ws->setDepartment("?");

        $response = $ws->exec();
    }

    /**
     * Return the web service instance
     *
     * @return TntDepots
     */
    protected function getWebService()
    {
        return $this->ws;
    }

    /**
     * Return the web service name to use
     *
     * @return string
     */
    protected function getWebServiceName()
    {
        return 'tntDepots';
    }
}
