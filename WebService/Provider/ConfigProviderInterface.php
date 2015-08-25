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

use TNTFrance\WebService\Model\TNTPickUpRequest;
use TNTFrance\WebService\Model\TNTSender;

/**
 * Class ConfigProviderInterface
 * @author Julien Chanséaume <julien@thelia.net>
 */
interface ConfigProviderInterface
{
    /**
     * Set the configured TNT account to get the configuration for.
     *
     * @param null|int $accountId Account id (defaults to the default account).
     */
    public function setAccountId($accountId = null);

    /**
     * URL of the Wsdl
     *
     * @return mixed
     */
    public function getWsdlUrl();

    /**
     * MyTNT account number
     *
     * @return string
     */
    public function getAccountNumber();


    /**
     * MyTNT account username
     *
     * @return string
     */
    public function getUsername();

    /**
     * MyTNT account password
     *
     * @return string
     */
    public function getPassword();

    /**
     * The product that are available
     *
     * @return array
     */
    public function getProductsEnabled();

    /**
     * The options that are available
     *
     * @return array
     */
    public function getOptionsEnabled();


    /**
     * @return TNTSender
     */
    public function getSender();

    public function getNotification();

    /**
     * Should return the day of the shipping date. not a sunday or jour férié
     *
     * @return string the date inf YYYY-MM-DD format
     */
    public function getShippingDate();

    /**
     * Return the Print format
     *
     * @return string
     */
    public function getLabelFormat();

    /**
     * Necessary if sender type is ENTERPRISE
     * Forbidden if sender type is DEPOT
     *
     * @return TNTPickUpRequest
     */
    public function getPickUpRequest();
}
