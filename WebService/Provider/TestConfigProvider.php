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


namespace TNTFrance\WebService\Provider;

/**
 * Class TestConfigProvider
 * @package TNTFrance\WebService\Provider
 * @author Julien Chanséaume <julien@thelia.net>
 */
class TestConfigProvider implements ConfigProviderInterface
{

    public function getWsdlUrl()
    {
        return 'http://www.tnt.fr/service/?wsdl';
    }

    public function getAccountNumber()
    {
        // TODO: Implement getAccountNumber() method.
    }

    public function getUsername()
    {
        return 'webservices@tnt.fr';
    }

    public function getPassword()
    {
        return 'test';
    }

    public function getSender()
    {
        // TODO: Implement getSender() method.
    }

    public function getNotification()
    {
        // TODO: Implement getNotification() method.
    }

    public function getShippingDate()
    {
        // TODO: Implement getShippingDate() method.
    }

    public function getLabelFormat()
    {
        return 'STDA4';
    }
}
