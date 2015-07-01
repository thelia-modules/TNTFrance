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

