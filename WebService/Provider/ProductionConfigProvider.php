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

use TNTFrance\Model\Config\TNTFranceConfigValue;
use TNTFrance\TNTFrance;
use TNTFrance\WebService\Model\TNTPickUpRequest;
use TNTFrance\WebService\Model\TNTSender;

/**
 * Class ProductionConfigProvider
 * @package TNTFrance\WebService\Provider
 * @author Julien Chanséaume <julien@thelia.net>
 */
class ProductionConfigProvider implements ConfigProviderInterface
{

    public function getWsdlUrl()
    {
        // todo move to : return TNTFrance::getConfigValue('wsdl_url');
        return 'http://www.tnt.fr/service/?wsdl';
    }

    public function getAccountNumber()
    {
        return TNTFrance::getConfigValue(TNTFranceConfigValue::ACCOUNT_NUMBER);
    }

    public function getUsername()
    {
        return TNTFrance::getConfigValue(TNTFranceConfigValue::USERNAME);
    }

    public function getPassword()
    {
        return TNTFrance::getConfigValue(TNTFranceConfigValue::PASSWORD);
    }

    public function getSender()
    {
        $sender = new TNTSender();
        $sender
            ->setType('ENTERPRISE')
            ->setTypeId('')
            ->setName(TNTFrance::getConfigValue(TNTFranceConfigValue::SENDER_NAME))
            ->setAddress1(TNTFrance::getConfigValue(TNTFranceConfigValue::SENDER_ADDRESS1))
            ->setAddress2(TNTFrance::getConfigValue(TNTFranceConfigValue::SENDER_ADDRESS2))
            ->setZipCode(TNTFrance::getConfigValue(TNTFranceConfigValue::SENDER_ZIP_CODE))
            ->setCity(TNTFrance::getConfigValue(TNTFranceConfigValue::SENDER_CITY))
            ->setContactLastName(TNTFrance::getConfigValue(TNTFranceConfigValue::CONTACT_LASTNAME))
            ->setContactFirstName(TNTFrance::getConfigValue(TNTFranceConfigValue::CONTACT_FIRSTNAME))
            ->setEmailAddress(TNTFrance::getConfigValue(TNTFranceConfigValue::CONTACT_EMAIL))
            ->setPhoneNumber(
                str_replace(' ', '', TNTFrance::getConfigValue(TNTFranceConfigValue::CONTACT_PHONE))
            )
            ->setFaxNumber('');

        return $sender;
    }

    public function getNotification()
    {
        return TNTFrance::getConfigValue('notification_emails');
    }

    public function getShippingDate()
    {
        $day = 24 * 60 * 60;

        // if hour > 15h, next day
        if (date("G") >= 15) {
            $date = time() + $day;
        } else {
            $date = time();
        }

        $isNotValid = true;

        while ($isNotValid) {
            // sam, dim
            if (date('N', $date) <= 5) {
                if (!TNTFrance::isNotWorkable($date)) {
                    $isNotValid = false;
                }
            }

            if ($isNotValid) {
                $date += $day;
            }
        }

        return date('Y-m-d', $date);
    }




    public function getLabelFormat()
    {
        return TNTFrance::getConfigValue(TNTFranceConfigValue::LABEL_FORMAT, 'STDA4');
    }

    public function getPickUpRequest()
    {
        $pickUpRequest = new TNTPickUpRequest();

        $pickUpRequest
            ->setMedia('EMAIL')
            ->setPhoneNumber(
                str_replace(' ', '', TNTFrance::getConfigValue(TNTFranceConfigValue::CONTACT_PHONE))
            )
            ->setClosingTime('17:00')
            ->setEmailAddress(TNTFrance::getConfigValue(TNTFranceConfigValue::CONTACT_EMAIL))
        ;

        return $pickUpRequest;
    }

    /**
     * The products that are available
     *
     * @return array
     */
    public function getProductsEnabled()
    {
        return explode(
            ',',
            TNTFrance::getConfigValue(TNTFranceConfigValue::PRODUCTS_ENABLED, TNTFrance::DEFAULT_PRODUCTS_ENABLED)
        );
    }

    /**
     * The options that are available
     *
     * @return array
     */
    public function getOptionsEnabled()
    {
        return explode(
            ',',
            TNTFrance::getConfigValue(TNTFranceConfigValue::OPTIONS_ENABLED, TNTFrance::DEFAULT_OPTIONS_ENABLED)
        );
    }
}
