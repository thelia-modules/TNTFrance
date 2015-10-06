<?php
/*************************************************************************************/
/* This file is part of the Thelia package.                                          */
/*                                                                                   */
/* Copyright (c) OpenStudio                                                          */
/* email : dev@thelia.net                                                            */
/* web : http://www.thelia.net                                                       */
/*                                                                                   */
/* For the full copyright and license information, please view the LICENSE.txt       */
/* file that was distributed with this source code.                                  */
/*************************************************************************************/

namespace TNTFrance\Model\Config;

use Thelia\Core\Translation\Translator;
use TNTFrance\TNTFrance;

/**
 * Module configuration values keys.
 */
class TNTFranceConfigValue
{
    // account
    const ACCOUNT_LABEL = "account_label";
    const ACCOUNT_NUMBER = "account_number";
    const USERNAME = "username";
    const PASSWORD = "password";
    const SENDER_NAME = "sender_name";
    const SENDER_ADDRESS1 = "sender_address1";
    const SENDER_ADDRESS2 = "sender_address2";
    const SENDER_ZIP_CODE = "sender_zip_code";
    const SENDER_CITY = "sender_city";
    const CONTACT_LASTNAME = "contact_lastname";
    const CONTACT_FIRSTNAME = "contact_firstname";
    const CONTACT_EMAIL = "contact_email";
    const CONTACT_PHONE = "contact_phone";
    const NOTIFICATION_EMAILS = "notification_emails";
    const NOTIFICATION_SUCCESS = "notification_success";

    // general
    const ENABLED = "enabled";
    const MODE_PRODUCTION = "mode_production";
    const USE_INDIVIDUAL = "use_individual";
    const USE_ENTERPRISE = "use_enterprise";
    const USE_DEPOT = "use_depot";
    const USE_DROPOFFPOINT = "use_dropoffpoint";
    const PRODUCTS_ENABLED = "products_enabled";
    const OPTIONS_ENABLED = "options_enabled";
    const REGULAR_PICKUP = "regular_pickup";
    const LABEL_FORMAT = "label_format";
    const FREE_SHIPPING = "free_shipping";
    const MAX_WEIGHT_PACKAGE = "max_weight_package";
    const TRACKING_URL = "tracking_url";

    // prices & weights
    const SURCHARGE_FUEL = "surcharge_fuel";
    const SURCHARGE_SECURITY_FEE = "surcharge_security_fee";
    const SURCHARGE_MULTI_PACKAGE = "surcharge_multi_package";
    const SEPARATE_PRODUCT_IN_PACKAGE = "separate_product_in_package";

    const OPTION_P_PAYMENT_BACK = "option_payment_back";
    const OPTION_W_EXPEDITION_UNDER_PROTECTION = "option_expedition_under_protection";
    const OPTION_D_RELAY_PACKAGE = "option_relay_package";
    const OPTION_Z_HOME_DELIVERY = "option_home_delivery";
    const OPTION_E_WITHOUT_ANNOTATING = "option_without_annotating";

    const PRICE_ONE_KG = "price";
    const PRICE_KG_SUP = "price_kg_sup";

    public static function getServices()
    {
        $services = [];

        $translator = Translator::getInstance();

        $services[] = [
            'id' => 'INDIVIDUAL',
            'enabled' => (bool) TNTFrance::getConfigValue(TNTFranceConfigValue::USE_INDIVIDUAL),
            'name' => $translator->trans('Home delivery', [], TNTFrance::MESSAGE_DOMAIN),
        ];
        $services[] = [
            'id' => 'ENTERPRISE',
            'enabled' => (bool) TNTFrance::getConfigValue(TNTFranceConfigValue::USE_ENTERPRISE),
            'name' => $translator->trans('Enterprise delivery', [], TNTFrance::MESSAGE_DOMAIN),
        ];
        $services[] = [
            'id' => 'DEPOT',
            'enabled' => (bool) TNTFrance::getConfigValue(TNTFranceConfigValue::USE_DEPOT),
            'name' => $translator->trans('TNT Depot', [], TNTFrance::MESSAGE_DOMAIN),
        ];
        $services[] = [
            'id' => 'DROPOFFPOINT',
            'enabled' => (bool) TNTFrance::getConfigValue(TNTFranceConfigValue::USE_DROPOFFPOINT),
            'name' => $translator->trans('Drop Off Point', [], TNTFrance::MESSAGE_DOMAIN),
        ];

        return $services;
    }
}
