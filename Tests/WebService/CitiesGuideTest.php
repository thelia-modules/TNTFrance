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

use TNTFrance\WebService\CitiesGuide;

/**
 * Class CitiesGuideTest
 * @package TNTFrance\Tests\WebService
 * @author Julien Chanséaume <julien@thelia.net>
 */
class CitiesGuideTest extends WebServiceTestCase
{

    public function testSuccess()
    {
        $ws = $this->getWebService();
        $ws->setZipCode('63000');

        $response = $ws->exec();

        $this->assertNotEmpty($response);
        $this->assertEquals($response[0], 'CLERMONT FERRAND');
    }

    /**
     * @expectedException \SoapFault
     */
    public function testEmptyZipCode()
    {
        $ws = $this->getWebService();
        $ws->setZipCode('');

        $response = $ws->exec();

        $this->assertNotEmpty($response);
    }

    /**
     * @expectedException \SoapFault
     */
    public function testBadZipCode()
    {
        $ws = $this->getWebService();
        $ws->setZipCode('?');

        $response = $ws->exec();

        $this->assertNotEmpty($response);
    }

    public function testUnknownZipCode()
    {
        $ws = $this->getWebService();
        $ws->setZipCode('99999');

        $response = $ws->exec();

        $this->assertEmpty($response);
    }

    /**
     * Return the web service name to use
     */
    protected function getWebServiceName()
    {
        return 'citiesGuide';
    }

    /**
     * @return CitiesGuide
     */
    protected function getWebService()
    {
        return $this->ws;
    }
}
