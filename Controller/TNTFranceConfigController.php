<?php

namespace TNTFrance\Controller;

use Symfony\Component\Form\Form;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Form\Exception\FormValidationException;
use TNTFrance\Form\TNTPriceWeightForm;
use TNTFrance\Model\Config\TNTFranceConfigValue;
use TNTFrance\Model\TntPriceWeightQuery;
use TNTFrance\TNTFrance;

/**
 * Module configuration controller.
 */
class TNTFranceConfigController extends BaseAdminController
{
    public function defaultAction()
    {
        if (null !==
            $response = $this->checkAuth(AdminResources::MODULE, TNTFrance::getModuleCode(), AccessManager::VIEW)
        ) {
            return $response;
        }

        return $this->render(
            "tntfrance-configuration",
            [
                'products_enabled' => TNTFrance::getConfigValue(TNTFranceConfigValue::PRODUCTS_ENABLED),
            ]
        );
    }

    public function saveAction()
    {
        if (null !==
            $response = $this->checkAuth(AdminResources::MODULE, TNTFrance::getModuleCode(), AccessManager::UPDATE)
        ) {
            return $response;
        }

        $errorMessage = null;

        $currentTab = $this->getRequest()->get('current_tab');

        switch ($currentTab) {
            case 'weight':
                $baseForm = $this->createForm("tntfrance.price.weight");
                break;
            default:
                $baseForm = $this->createForm("tntfrance.configuration");
                break;
        }

        try {

            $form = $this->validateForm($baseForm);

            switch ($currentTab) {
                case 'weight':
                    $this->processPriceWeigthForm($form);
                    break;
                default:
                    $this->processGeneralForm($form);
                    break;
            }

        } catch (FormValidationException $ex) {
            // Invalid data entered
            $errorMessage = $this->createStandardFormValidationErrorMessage($ex);
        } catch (\Exception $ex) {
            // Any other error
            $errorMessage = $this->getTranslator()->trans(
                'Sorry, an error occurred: %err',
                [
                    '%err' => $ex->getMessage()
                ],
                [],
                TNTFrance::MESSAGE_DOMAIN
            );
        }

        if (null !== $errorMessage) {
            // Mark the form as with error
            $baseForm->setErrorMessage($errorMessage);

            // Send the form and the error to the parser
            $this->getParserContext()
                ->addForm($baseForm)
                ->setGeneralError($errorMessage);
        } else {
            $this->getParserContext()
                ->set("success", true);
        }

        return $this->defaultAction();
    }

    protected function processGeneralForm(Form $form)
    {
        $fields = [
            TNTFranceConfigValue::ENABLED,
            TNTFranceConfigValue::MODE_PRODUCTION,
            TNTFranceConfigValue::ACCOUNT_NUMBER,
            TNTFranceConfigValue::USERNAME,
            TNTFranceConfigValue::PASSWORD,
            TNTFranceConfigValue::USE_INDIVIDUAL,
            TNTFranceConfigValue::USE_ENTERPRISE,
            TNTFranceConfigValue::USE_DEPOT,
            TNTFranceConfigValue::USE_DROPOFFPOINT,
            TNTFranceConfigValue::PRODUCTS_ENABLED,
            TNTFranceConfigValue::OPTIONS_ENABLED,
            TNTFranceConfigValue::REGULAR_PICKUP,
            TNTFranceConfigValue::SENDER_NAME,
            TNTFranceConfigValue::SENDER_ADDRESS1,
            TNTFranceConfigValue::SENDER_ADDRESS2,
            TNTFranceConfigValue::SENDER_ZIP_CODE,
            TNTFranceConfigValue::SENDER_CITY,
            TNTFranceConfigValue::CONTACT_LASTNAME,
            TNTFranceConfigValue::CONTACT_FIRSTNAME,
            TNTFranceConfigValue::CONTACT_EMAIL,
            TNTFranceConfigValue::CONTACT_PHONE,
            TNTFranceConfigValue::NOTIFICATION_EMAILS,
            TNTFranceConfigValue::NOTIFICATION_SUCCESS,
            TNTFranceConfigValue::LABEL_FORMAT,
            TNTFranceConfigValue::FREE_SHIPPING,
            TNTFranceConfigValue::MAX_WEIGHT_PACKAGE,
            TNTFranceConfigValue::TRACKING_URL,
        ];

        foreach ($fields as $field) {
            $data = $form->get($field)->getData();

            if (is_bool($data)) {
                $data = (int)$data;
            }

            TNTFrance::setConfigValue($field, $data);
        }
    }

    protected function processPriceWeigthForm(Form $form)
    {
        $fields = [
            TNTFranceConfigValue::FREE_SHIPPING,
            TNTFranceConfigValue::SURCHARGE_FUEL,
            TNTFranceConfigValue::SURCHARGE_SECURITY_FEE,
            TNTFranceConfigValue::SURCHARGE_MULTI_PACKAGE,
            TNTFranceConfigValue::SEPARATE_PRODUCT_IN_PACKAGE,
            TNTFranceConfigValue::OPTION_P_PAYMENT_BACK,
            TNTFranceConfigValue::OPTION_W_EXPEDITION_UNDER_PROTECTION,
            TNTFranceConfigValue::OPTION_D_RELAY_PACKAGE,
            TNTFranceConfigValue::OPTION_Z_HOME_DELIVERY,
            TNTFranceConfigValue::OPTION_E_WITHOUT_ANNOTATING,
        ];

        foreach ($fields as $field) {
            $data = $form->get($field)->getData();

            if (!$data) {
                $data = 0;
            }

            TNTFrance::setConfigValue($field, $data);
        }

        //Save the contracted rates
        $prices = $form->get(TNTFranceConfigValue::PRICE_ONE_KG)->getData();
        $priceKgSups = $form->get(TNTFranceConfigValue::PRICE_KG_SUP)->getData();

        foreach ($prices as $id => $price) {
            if (null === $tntPriceWeight = TntPriceWeightQuery::create()->findPk($id)) {
                continue;
            }

            $tntPriceWeight->setPrice($price);

            if (is_array($priceKgSups) && array_key_exists($id, $priceKgSups)) {
                $tntPriceWeight->setPriceKgSup($priceKgSups[$id]);
            }

            $tntPriceWeight->save();
        }
    }
}
