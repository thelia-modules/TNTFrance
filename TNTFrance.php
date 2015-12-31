<?php
/**
 * This class has been generated by TheliaStudio
 * For more information, see https://github.com/thelia-modules/TheliaStudio
 */

namespace TNTFrance;

use Propel\Runtime\Connection\ConnectionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Thelia\Core\Event\Cart\CartEvent;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Core\HttpFoundation\Session\Session;
use Thelia\Core\Translation\Translator;
use Thelia\Install\Database;
use Thelia\Model\AddressQuery;
use Thelia\Model\Cart;
use Thelia\Model\ConfigQuery;
use Thelia\Model\Country;
use Thelia\Model\Customer;
use Thelia\Model\LangQuery;
use Thelia\Model\Message;
use Thelia\Model\MessageQuery;
use Thelia\Model\MetaData;
use Thelia\Model\MetaDataQuery;
use Thelia\Model\OrderPostage;
use Thelia\Module\AbstractDeliveryModule;
use Thelia\Module\Exception\DeliveryException;
use TNTFrance\Action\OrderAction;
use TNTFrance\Model\Base\TntPriceWeightQuery;
use TNTFrance\Model\Config\TNTFranceConfigValue;
use TNTFrance\Model\TntPriceWeight;

/**
 * Class TNTFrance
 * @package TNTFrance
 */
class TNTFrance extends AbstractDeliveryModule
{

    const JSON_PRICE_RESOURCE = "/Config/prices.json";
    private static $prices = null;

    const MESSAGE_DOMAIN = "tntfrance";
    const ROUTER = "router.tntfrance";
    const METADATA_KEY_ORDER = 'tntfrance';
    const METADATA_CART_KEY = 'cart';

    const DEFAULT_PRODUCTS_ENABLED = 'N,A,T,M,J,P';
    const DEFAULT_OPTIONS_ENABLED = 'P,W,D,Z,E';

    /** @var Translator $translator */
    protected $translator;

    public function postActivation(ConnectionInterface $con = null)
    {
        $database = new Database($con);
        $database->insertSql(null, [__DIR__ . "/Config/create.sql"]);

        $this->initializeConfig();

        $this->initializeMessage();
    }

    protected function initializeMessage()
    {
        // create new message
        if (null === MessageQuery::create()->findOneByName('mail_tnt_france')) {
            $message = new Message();
            $message
                ->setName('mail_tnt_france')
                ->setHtmlTemplateFileName('mail-tnt-france.html')
                ->setHtmlLayoutFileName('')
                ->setTextTemplateFileName('mail-tnt-france.txt')
                ->setTextLayoutFileName('')
                ->setSecured(0);

            $languages = LangQuery::create()->find();

            foreach ($languages as $language) {
                $locale = $language->getLocale();

                $message->setLocale($locale);
                $message->setSubject(
                    $this->trans('Your order {$order_ref} has been shipped.', [], $locale)
                );
                $message->setTitle(
                    $this->trans('TNT France shipping message', [], $locale)
                );
            }

            $message->save();
        }
    }

    protected function initializeConfig()
    {
        $defaults = [
            TNTFranceConfigValue::ENABLED => 0,
            TNTFranceConfigValue::MODE_PRODUCTION => 0,
            TNTFranceConfigValue::ACCOUNT_NUMBER => '',
            TNTFranceConfigValue::USERNAME => '',
            TNTFranceConfigValue::PASSWORD => '',
            TNTFranceConfigValue::USE_INDIVIDUAL => 1,
            TNTFranceConfigValue::USE_ENTERPRISE => 1,
            TNTFranceConfigValue::USE_DEPOT => 1,
            TNTFranceConfigValue::USE_DROPOFFPOINT => 1,
            TNTFranceConfigValue::PRODUCTS_ENABLED => self::DEFAULT_PRODUCTS_ENABLED,
            TNTFranceConfigValue::OPTIONS_ENABLED => self::DEFAULT_OPTIONS_ENABLED,
            TNTFranceConfigValue::REGULAR_PICKUP => 0,
            TNTFranceConfigValue::SENDER_NAME => ConfigQuery::read('store_name', ''),
            TNTFranceConfigValue::SENDER_ADDRESS1 => ConfigQuery::read('store_address1', ''),
            TNTFranceConfigValue::SENDER_ADDRESS2 => ConfigQuery::read('store_address2', ''),
            TNTFranceConfigValue::SENDER_ZIP_CODE => ConfigQuery::read('store_zipcode', ''),
            TNTFranceConfigValue::SENDER_CITY => ConfigQuery::read('store_city', ''),
            TNTFranceConfigValue::CONTACT_LASTNAME => '',
            TNTFranceConfigValue::CONTACT_FIRSTNAME => '',
            TNTFranceConfigValue::CONTACT_EMAIL => ConfigQuery::read('store_email', ''),
            TNTFranceConfigValue::CONTACT_PHONE => ConfigQuery::read('store_phone', ''),
            TNTFranceConfigValue::NOTIFICATION_EMAILS => ConfigQuery::read('store_notification_emails', ''),
            TNTFranceConfigValue::NOTIFICATION_SUCCESS => 0,
            TNTFranceConfigValue::LABEL_FORMAT => "STDA4",
            TNTFranceConfigValue::FREE_SHIPPING => 0,
            TNTFranceConfigValue::TRACKING_URL => 'http://www.tnt.fr/public/suivi_colis/recherche/visubontransport.do?radiochoixrecherche=BT&bonTransport=%tracking-number%',
            TNTFranceConfigValue::SURCHARGE_FUEL => 0,
            TNTFranceConfigValue::SURCHARGE_SECURITY_FEE => 0.36,
            TNTFranceConfigValue::SURCHARGE_MULTI_PACKAGE => 0.5,
            TNTFranceConfigValue::SEPARATE_PRODUCT_IN_PACKAGE => 0,
            TNTFranceConfigValue::OPTION_P_PAYMENT_BACK=> 0,
            TNTFranceConfigValue::OPTION_W_EXPEDITION_UNDER_PROTECTION => 0,
            TNTFranceConfigValue::OPTION_D_RELAY_PACKAGE => 0,
            TNTFranceConfigValue::OPTION_Z_HOME_DELIVERY => 0,
            TNTFranceConfigValue::OPTION_E_WITHOUT_ANNOTATING => 0,
        ];

        foreach ($defaults as $configName => $configValue) {
            if (null === self::getConfigValue($configName)) {
                self::setConfigValue($configName, $configValue);
            }
        }

        //If no postage price exists, save the defaults one
        if (null == $tntPriceWeight = TntPriceWeightQuery::create()->findOne()) {
            foreach (self::getPrices() as $areaId => $tntProducts) {
                foreach ($tntProducts as $productCode => $tntProduct) {
                    $tntPriceWeight = new TntPriceWeight();
                    $tntPriceWeight
                        ->setAreaId($areaId)
                        ->setTntProductLabel($tntProduct['label'])
                        ->setTntProductCode($productCode)
                        ->setPrice($tntProduct['price'])
                        ->setWeight($tntProduct['weight'])
                        ->setPriceKgSup($tntProduct['price_kg_sup'])
                        ->save()
                    ;
                }

            }
        }
    }

    /**
     * This method is called by the Delivery  loop, to check if the current module has to be displayed to the customer.
     * Override it to implements your delivery rules/
     *
     * If you return true, the delivery method will de displayed to the customer
     * If you return false, the delivery method will not be displayed
     *
     * @param Country $country the country to deliver to.
     *
     * @return boolean
     */
    public function isValidDelivery(Country $country)
    {
        $isValid = true;

        // The module is only valid for France at the moment
        if ('FR' !== $country->getIsoalpha2()) {
            $isValid = false;
        }

        /** @var Customer $customer */
        if ($isValid && null != $customer = $this->getRequest()->getSession()->getCustomerUser()) {
            $customerCompany = $customer->getDefaultAddress()->getCompany();

            // If customer default delivery address is not a company, check that USE_INDIVIDUAL is allowed
            if (empty($customerCompany)) {
                if (0 == TNTFrance::getConfigValue(TNTFranceConfigValue::USE_INDIVIDUAL, 0)) {
                    $isValid = false;
                }
                // If customer default delivery address is a company, check that USE_ENTERPRISE is allowed
            } else {
                if (0 == TNTFrance::getConfigValue(TNTFranceConfigValue::USE_ENTERPRISE, 0)) {
                    $isValid = false;
                }
            }
        }

        return $isValid;
    }

    /**
     * Calculate and return delivery price in the shop's default currency
     *
     * @param Country $country the country to deliver to.
     *
     * @return OrderPostage|float             the delivery price
     * @throws DeliveryException if the postage price cannot be calculated.
     */
    public function getPostage(Country $country)
    {

        $postage = new OrderPostage();

        $freeShipping = intval(self::getConfigValue(TNTFranceConfigValue::FREE_SHIPPING));

        if (0 == $freeShipping) {
            /** @var Cart $sessionCart */
            $sessionCart = $this->getRequest()->getSession()->getSessionCart($this->getDispatcher());

            $data = TNTFrance::getExtraOrderData($sessionCart->getId(), true);

            if (array_key_exists('tnt_serviceCode', $data)) {
                $cartEvent = new CartEvent($sessionCart);
                $this->getDispatcher()->dispatch(OrderAction::TNT_CALCUL_CART_WEIGHT, $cartEvent);

                $postage->setAmount(
                    self::calculPriceForService(
                        $data['tnt_serviceCode'],
                        $cartEvent->getCart()->getVirtualColumn('total_package'),
                        $cartEvent->getCart()->getVirtualColumn('total_weight')
                    )
                );
            }
        }

        return $postage->getAmount();
    }

    /**
     *
     * This method return true if your delivery manages virtual product delivery.
     *
     * @return bool
     */
    public function handleVirtualProductDelivery()
    {
        return false;
    }

    public static function calculPriceForService($serviceCode, $numberOfPackages, $weight = 0)
    {
        $price = 0;

        $freeShipping = intval(self::getConfigValue(TNTFranceConfigValue::FREE_SHIPPING, 0));

        //A serviceCode is composed by a tnt_code_product AND a tnt_code_option
        if (strlen($serviceCode) == 2) {
            $productCode = substr($serviceCode, 0, 1);
            $optionCode = substr($serviceCode, 1, 1);
        } else {
            $productCode = $serviceCode;
            $optionCode = null;
        }

        if (0 == $freeShipping) {
            /** @var \TNTFrance\Model\TntPriceWeight $tntPriceWeight */
            if (null != $tntPriceWeight = TntPriceWeightQuery::create()
                    ->filterByTntProductCode($productCode)
                    ->findOne()) {
                $price = $tntPriceWeight->getPrice() + (floor($weight) - 1) * $tntPriceWeight->getPriceKgSup();

                //Package SURCHARGES
                //surcharge_security_fee
                $price += $numberOfPackages * (float)TNTFrance::getConfigValue(TNTFranceConfigValue::SURCHARGE_SECURITY_FEE, 0);

                //surcharge surcharge_multi_package
                if ($numberOfPackages > 1) {
                    $price += ($numberOfPackages - 1) * (float)TNTFrance::getConfigValue(TNTFranceConfigValue::SURCHARGE_MULTI_PACKAGE, 0);
                }

                //If there is an option_code and this option aply to each package
                if (null != $optionCode && in_array($optionCode, ['W', 'D', 'Z'])) {
                    switch ($optionCode) {
                        //option_expedition_under_protection
                        case 'W':
                            $price += $numberOfPackages * (float)TNTFrance::getConfigValue(TNTFranceConfigValue::OPTION_W_EXPEDITION_UNDER_PROTECTION, 0);
                            break;

                        //option_relay_package
                        case 'D':
                            $price += $numberOfPackages * (float)TNTFrance::getConfigValue(TNTFranceConfigValue::OPTION_D_RELAY_PACKAGE, 0);
                            break;

                        //option_home_delivery
                        case 'Z':
                            $price += $numberOfPackages * (float)TNTFrance::getConfigValue(TNTFranceConfigValue::OPTION_Z_HOME_DELIVERY, 0);
                            break;

                        default:
                            break;
                    }
                }

                //Expedition SURCHARGES
                //surcharge_fuel
                $price += (float)TNTFrance::getConfigValue(TNTFranceConfigValue::SURCHARGE_FUEL, 0);

                //If there is an option_code and this option aply to each expedition
                if (null != $optionCode && in_array($optionCode, ['P', 'E'])) {
                    switch ($optionCode) {
                        //option_payment_back
                        case 'P':
                            $price += (float)TNTFrance::getConfigValue(TNTFranceConfigValue::OPTION_P_PAYMENT_BACK, 0);
                            break;

                        //option_without_annotating
                        case 'E':
                            $price += (float)TNTFrance::getConfigValue(TNTFranceConfigValue::OPTION_E_WITHOUT_ANNOTATING, 0);
                            break;

                        default:
                            break;
                    }
                }
            }
        }

        return $price;
    }

    /**
     * Retrieve delivery address associated to the order or the default address of the customer
     *
     * @param Request $request the request
     * @return null|\Thelia\Model\Address
     */
    public static function getCartDeliveryAddress(Request $request)
    {
        $address = null;

        /** @var Session $session */
        $session = $request->getSession();

        /** @var Customer $customer */
        if (null !== $customer = $session->getCustomerUser()) {
            if (null !== $session->getOrder()
                && null !== $session->getOrder()->getChoosenDeliveryAddress()
                && null !== $currentDeliveryAddress = AddressQuery::create()->findPk($session->getOrder()->getChoosenDeliveryAddress())
            ) {
                $address = $currentDeliveryAddress;
            } else {
                $address = $customer->getDefaultAddress();
            }
        }

        return $address;
    }

    public static function getExtraOrderData($id, $isCart = true)
    {
        if ($isCart) {
            $data = MetaDataQuery::getVal(self::METADATA_KEY_ORDER, self::METADATA_CART_KEY, $id, []);
        } else {
            $data = MetaDataQuery::getVal(self::METADATA_KEY_ORDER, MetaData::ORDER_KEY, $id, []);
        }

        return $data;
    }

    public static function setExtraOrderData($id, $data, $isCart = true)
    {
        if ($isCart) {
            MetaDataQuery::setVal(self::METADATA_KEY_ORDER, self::METADATA_CART_KEY, $id, $data);
        } else {
            MetaDataQuery::setVal(self::METADATA_KEY_ORDER, MetaData::ORDER_KEY, $id, $data);
        }
    }


    protected function trans($id, $parameters = [], $locale = null)
    {
        if (null === $this->translator) {
            $this->translator = Translator::getInstance();
        }

        return $this->translator->trans($id, $parameters, self::MESSAGE_DOMAIN, $locale);
    }

    /**
     * @return string
     */
    public static function getUploadDirectory()
    {
        $uploadPath = THELIA_LOCAL_DIR . 'media' . DIRECTORY_SEPARATOR . 'tntfrance' . DIRECTORY_SEPARATOR;
        $fs = new Filesystem();

        if (!$fs->exists($uploadPath)) {
            $fs->mkdir($uploadPath);
        }

        return $uploadPath;
    }

    public static function getDisablePickUpDate($days = 30)
    {
        $dayTime = 24 * 60 * 60;
        $date = time();
        $disabledDates = [];

        for ($i = 1; $i <= $days; $i++) {
            // if hour > 15h, next day
            if ($i == 1 && date("G") >= 15) {
                $disabledDates[] = date('Y-m-d', $date);
                $date += $dayTime;
                continue;
            }

            // sam, dim
            if (date('N', $date) <= 5) {
                if (self::isNotWorkable($date)) {
                    //Date is incorrect
                    $disabledDates[] = date('Y-m-d', $date);
                }
            } else {
                $disabledDates[] = date('Y-m-d', $date);
            }

            $date += $dayTime;
        }

        return $disabledDates;
    }

    public static function isNotWorkable($date)
    {
        if ($date === null) {
            $date = time();
        }

        $date = strtotime(date('m/d/Y', $date));

        $year = date('Y', $date);

        $easterDate = easter_date($year);
        $easterDay = date('j', $easterDate);
        $easterMonth = date('n', $easterDate);
        $easterYear = date('Y', $easterDate);

        $holidays = array(
            // Dates fixes
            mktime(0, 0, 0, 1, 1, $year),  // 1er janvier
            mktime(0, 0, 0, 5, 1, $year),  // Fête du travail
            mktime(0, 0, 0, 5, 8, $year),  // Victoire des alliés
            mktime(0, 0, 0, 7, 14, $year),  // Fête nationale
            mktime(0, 0, 0, 8, 15, $year),  // Assomption
            mktime(0, 0, 0, 11, 1, $year),  // Toussaint
            mktime(0, 0, 0, 11, 11, $year),  // Armistice
            mktime(0, 0, 0, 12, 25, $year),  // Noel

            // Dates variables
            mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear), // Pâques
            mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear), // Ascension
            mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear), // Pentecôte
        );

        return in_array($date, $holidays);
    }

    public static function getPrices()
    {
        if (null === self::$prices) {
            self::$prices = json_decode(file_get_contents(sprintf('%s%s', __DIR__, self::JSON_PRICE_RESOURCE)), true);
        }

        return self::$prices;
    }
}
