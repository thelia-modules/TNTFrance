<?php

namespace TNTFrance\Form;

use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;
use TNTFrance\Model\Config\TNTFranceConfigValue;
use TNTFrance\TNTFrance;

/**
 * Prices and weights configuration form.
 */
class TNTPriceWeightForm extends BaseForm
{
    public function getName()
    {
        return 'tnt_price_weight_form';
    }

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                TNTFranceConfigValue::FREE_SHIPPING,
                'integer',
                [
                    'label' => $this->translator->trans(
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
                    'label' => $this->translator->trans(
                        'Fuel surchage',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::SURCHARGE_FUEL,
                        'description' => $this->translator->trans(
                            'Based on the monthly average price of a liter of diesel at the pump released by the National Committee Road, for all of your domestic shipments.',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                        'helper' => $this->translator->trans(
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
                    'label' => $this->translator->trans(
                        'Security fee',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::SURCHARGE_SECURITY_FEE,
                        'helper' => $this->translator->trans(
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
                    'label' => $this->translator->trans(
                        'Multi package treatment',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::SURCHARGE_MULTI_PACKAGE,
                        'description' => $this->translator->trans(
                            'From the second package.',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                        'helper' => $this->translator->trans(
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
                    'label' => $this->translator->trans(
                        'Do one package per product',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::SEPARATE_PRODUCT_IN_PACKAGE,
                        'description' => $this->translator->trans(
                            'Allows you to send several packages even if the max weight is not reached.',
                            [],
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
                    'label' => $this->translator->trans(
                        'Option payment back',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::OPTION_P_PAYMENT_BACK,
                        'description' => $this->translator->trans(
                            'Delivery against payment by check.',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                        'helper' => $this->translator->trans(
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
                    'label' => $this->translator->trans(
                        'Option expedition under protection',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::OPTION_W_EXPEDITION_UNDER_PROTECTION,
                        'description' => $this->translator->trans(
                            'For your sensitive goods, exclusive feature and enhanced for maximum safety, from pickup to delivery.',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                        'helper' => $this->translator->trans(
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
                    'label' => $this->translator->trans(
                        'Option relay package',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::OPTION_D_RELAY_PACKAGE,
                        'description' => $this->translator->trans(
                            'Package delivered in one of the 4,200 Relay Colis.',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                        'helper' => $this->translator->trans(
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
                    'label' => $this->translator->trans(
                        'Option home delivery',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::OPTION_Z_HOME_DELIVERY,
                        'description' => $this->translator->trans(
                            'Parcels delivered to the recipient (if absent or access problem: the package is automatically deposited into a Relais Colis).',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                        'helper' => $this->translator->trans(
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
                    'label' => $this->translator->trans(
                        'Option delivery without annotating',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::OPTION_E_WITHOUT_ANNOTATING,
                        'description' => $this->translator->trans(
                            'Contractual TNT option.',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                        'helper' => $this->translator->trans(
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
                    'type' => 'number',
                    'label' => $this->translator->trans(
                        'Price',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'options' => [
                        'constraints' => [
                            new NotBlank(),
                            new GreaterThan(['value' => 0]),
                        ]
                    ]
                ]
            )
            ->add(
                TNTFranceConfigValue::PRICE_KG_SUP,
                'collection',
                [
                    'type' => 'number',
                    'label' => $this->translator->trans(
                        'Price kg sup',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'options' => [
                        'constraints' => [
                            new NotBlank(),
                            new GreaterThan(['value' => 0]),
                        ]
                    ]
                ]
            );
    }
}
