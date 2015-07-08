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
use TNTFrance\Model\Config\Base\TNTFranceConfigValue as BaseTNTFranceConfigValue;
use TNTFrance\TNTFrance;

/**
 * Class TNTFranceConfigValue
 * @package TNTFrance\Model\Config
 */
class TNTFranceConfigValue extends BaseTNTFranceConfigValue
{
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
            'name' => $translator->trans('Home delivery', [], 'tntfrance'),
        ];
        $services[] = [
            'id' => 'ENTERPRISE',
            'enabled' => (bool) TNTFrance::getConfigValue(TNTFranceConfigValue::USE_ENTERPRISE),
            'name' => $translator->trans('Enterprise delivery', [], 'tntfrance'),
        ];
        $services[] = [
            'id' => 'DEPOT',
            'enabled' => (bool) TNTFrance::getConfigValue(TNTFranceConfigValue::USE_DEPOT),
            'name' => $translator->trans('TNT Depot', [], 'tntfrance'),
        ];
        $services[] = [
            'id' => 'DROPOFFPOINT',
            'enabled' => (bool) TNTFrance::getConfigValue(TNTFranceConfigValue::USE_DROPOFFPOINT),
            'name' => $translator->trans('Drop Off Point', [], 'tntfrance'),
        ];

        return $services;
    }
}
