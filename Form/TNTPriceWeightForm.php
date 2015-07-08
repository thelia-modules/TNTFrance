<?php
/**
 * Created by PhpStorm.
 * User: gbarral
 * Date: 06/07/15
 * Time: 10:54
 */

namespace TNTFrance\Form;


use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use TNTFrance\Model\Config\TNTFranceConfigValue;
use TNTFrance\TNTFrance;

class TNTPriceWeightForm extends BaseForm
{

    /**
     *
     * in this function you add all the fields you need for your Form.
     * Form this you have to call add method on $this->formBuilder attribute :
     *
     * $this->formBuilder->add("name", "text")
     *   ->add("email", "email", array(
     *           "attr" => array(
     *               "class" => "field"
     *           ),
     *           "label" => "email",
     *           "constraints" => array(
     *               new \Symfony\Component\Validator\Constraints\NotBlank()
     *           )
     *       )
     *   )
     *   ->add('age', 'integer');
     *
     * @return null
     */
    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                TNTFranceConfigValue::FREE_SHIPPING,
                'integer',
                [
                    'label' => Translator::getInstance()->trans(
                            'Free shipping',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::FREE_SHIPPING
                    ],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::FREE_SHIPPING)
                ]
            )
            ->add(
                TNTFranceConfigValue::SURCHARGE_FUEL,
                'number',
                [
                    'label' => Translator::getInstance()->trans(
                            'Fuel surchage',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::SURCHARGE_FUEL,
                        'description' => Translator::getInstance()->trans(
                                'Based on the monthly average price of a liter of diesel at the pump released by the National Committee Road, for all of your domestic shipments.',
                                [],
                                TNTFrance::MESSAGE_DOMAIN
                            ),
                        'helper' => Translator::getInstance()->trans(
                                '(Around %default_price€ per expedition by default)',
                                [
                                    '%default_price' => 0.60
                                ],
                                TNTFrance::MESSAGE_DOMAIN
                            )
                    ],
                    'constraints' => [
                        new NotBlank()
                    ],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::SURCHARGE_FUEL)
                ]
            )
            ->add(
                TNTFranceConfigValue::SURCHARGE_SECURITY_FEE,
                'number',
                [
                    'label' => Translator::getInstance()->trans(
                            'Security fee',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::SURCHARGE_SECURITY_FEE,
                        'helper' => Translator::getInstance()->trans(
                                '(%default_price€ per package by default)',
                                [
                                    '%default_price' => 0.36
                                ],
                                TNTFrance::MESSAGE_DOMAIN
                            )
                    ],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::SURCHARGE_SECURITY_FEE)
                ]
            )
            ->add(
                TNTFranceConfigValue::SURCHARGE_MULTI_PACKAGE,
                'number',
                [
                    'label' => Translator::getInstance()->trans(
                            'Multi package treatment',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::SURCHARGE_MULTI_PACKAGE,
                        'description' => Translator::getInstance()->trans(
                                'From the second package.',
                                [
                                    '%default_price' => 0.50
                                ],
                                TNTFrance::MESSAGE_DOMAIN
                            ),
                        'helper' => Translator::getInstance()->trans(
                                '(%default_price€ per package by default)',
                                [
                                    '%default_price' => 0.50
                                ],
                                TNTFrance::MESSAGE_DOMAIN
                            )
                    ],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::SURCHARGE_MULTI_PACKAGE)
                ]
            )
            ->add(
                TNTFranceConfigValue::SEPARATE_PRODUCT_IN_PACKAGE,
                'integer',
                [
                    'label' => Translator::getInstance()->trans(
                            'Do one package per product',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::SEPARATE_PRODUCT_IN_PACKAGE,
                        'description' => Translator::getInstance()->trans(
                                'Allows you to send several packages even if the max weight is not reached.',
                                [
                                    '%default_price' => 0.50
                                ],
                                TNTFrance::MESSAGE_DOMAIN
                            )
                    ],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::SEPARATE_PRODUCT_IN_PACKAGE)
                ]
            )
            ->add(
                TNTFranceConfigValue::OPTION_P_PAYMENT_BACK,
                'number',
                [
                    'label' => Translator::getInstance()->trans(
                            'Option payment back',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::OPTION_P_PAYMENT_BACK,
                        'description' => Translator::getInstance()->trans(
                                'Delivery against payment by check.',
                                [],
                                TNTFrance::MESSAGE_DOMAIN
                            ),
                        'helper' => Translator::getInstance()->trans(
                                '(%default_price€ per expedition by default)',
                                [
                                    '%default_price' => 16.50
                                ],
                                TNTFrance::MESSAGE_DOMAIN
                            )
                    ],
                    'constraints' => [
                        new NotBlank()
                    ],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::OPTION_P_PAYMENT_BACK)
                ]
            )
            ->add(
                TNTFranceConfigValue::OPTION_W_EXPEDITION_UNDER_PROTECTION,
                'number',
                [
                    'label' => Translator::getInstance()->trans(
                            'Option expedition under protection',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::OPTION_W_EXPEDITION_UNDER_PROTECTION,
                        'description' => Translator::getInstance()->trans(
                                'For your sensitive goods, exclusive feature and enhanced for maximum safety, from pickup to delivery.',
                                [],
                                TNTFrance::MESSAGE_DOMAIN
                            ),
                        'helper' => Translator::getInstance()->trans(
                                '(%default_price€ per package by default)',
                                [
                                    '%default_price' => 3.60
                                ],
                                TNTFrance::MESSAGE_DOMAIN
                            )
                    ],
                    'constraints' => [
                        new NotBlank()
                    ],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::OPTION_W_EXPEDITION_UNDER_PROTECTION)
                ]
            )
            ->add(
                TNTFranceConfigValue::OPTION_D_RELAY_PACKAGE,
                'number',
                [
                    'label' => Translator::getInstance()->trans(
                            'Option relay package',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::OPTION_D_RELAY_PACKAGE,
                        'description' => Translator::getInstance()->trans(
                                'Package delivered in one of the 4,200 Relay Colis.',
                                [],
                                TNTFrance::MESSAGE_DOMAIN
                            ),
                        'helper' => Translator::getInstance()->trans(
                                '(%default_price€ per package by default)',
                                [
                                    '%default_price' => 1.90
                                ],
                                TNTFrance::MESSAGE_DOMAIN
                            )
                    ],
                    'constraints' => [
                        new NotBlank()
                    ],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::OPTION_D_RELAY_PACKAGE)
                ]
            )
            ->add(
                TNTFranceConfigValue::OPTION_Z_HOME_DELIVERY,
                'number',
                [
                    'label' => Translator::getInstance()->trans(
                            'Option home delivery',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::OPTION_Z_HOME_DELIVERY,
                        'description' => Translator::getInstance()->trans(
                                'Parcels delivered to the recipient (if absent or access problem: the package is automatically deposited into a Relais Colis).',
                                [],
                                TNTFrance::MESSAGE_DOMAIN
                            ),
                        'helper' => Translator::getInstance()->trans(
                                '(%default_price€ per package by default)',
                                [
                                    '%default_price' => 2.90
                                ],
                                TNTFrance::MESSAGE_DOMAIN
                            )
                    ],
                    'constraints' => [
                        new NotBlank()
                    ],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::OPTION_Z_HOME_DELIVERY)
                ]
            )
            ->add(
                TNTFranceConfigValue::OPTION_E_WITHOUT_ANNOTATING,
                'number',
                [
                    'label' => Translator::getInstance()->trans(
                            'Option delivery without annotating',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::OPTION_E_WITHOUT_ANNOTATING,
                        'description' => Translator::getInstance()->trans(
                                'Contractual TNT option.',
                                [],
                                TNTFrance::MESSAGE_DOMAIN
                            ),
                        'helper' => Translator::getInstance()->trans(
                                '(%default_price€ per expedition by default)',
                                [
                                    '%default_price' => 0
                                ],
                                TNTFrance::MESSAGE_DOMAIN
                            )
                    ],
                    'constraints' => [
                        new NotBlank()
                    ],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::OPTION_E_WITHOUT_ANNOTATING)
                ]
            )
            ->add(
                TNTFranceConfigValue::PRICE_ONE_KG,
                'collection',
                [
                    'type'         => 'number',
                    'label'        => Translator::getInstance()->trans(
                            'Price',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'options'      => [
                        'constraints' => [
                            new NotBlank(),
                            new GreaterThan(
                                array('value' => 0)
                            )
                        ]
                    ]
                ]
            )
            ->add(
                TNTFranceConfigValue::PRICE_KG_SUP,
                'collection',
                [
                    'type'         => 'number',
                    'label'        => Translator::getInstance()->trans(
                            'Price kg sup',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'options'      => [
                        'constraints' => [
                            new NotBlank(),
                            new GreaterThan(
                                array('value' => 0)
                            )
                        ]
                    ]
                ]
            )
        ;
    }

    /**
     * @return string the name of you form. This name must be unique
     */
    public function getName()
    {
        return 'tnt_price_weight_form';
    }
}
