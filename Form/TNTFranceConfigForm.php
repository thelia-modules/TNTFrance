<?php

namespace TNTFrance\Form;

use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;
use TNTFrance\Model\Config\TNTFranceConfigValue;
use TNTFrance\TNTFrance;

/**
 * General configuration form.
 */
class TNTFranceConfigForm extends BaseForm
{
    public function getName()
    {
        return 'tntfrance_config_form';
    }

    protected function buildForm()
    {
        $this->formBuilder
            ->add(
                TNTFranceConfigValue::ENABLED,
                'checkbox',
                [
                    'label' => $this->translator->trans(
                        'Do you want to activate TNT Express National',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::ENABLED,
                    ],
                    'required' => false,
                    'constraints' => [],
                    'value' => TNTFrance::getConfigValue(TNTFranceConfigValue::ENABLED, false),
                ]
            )
            ->add(
                TNTFranceConfigValue::MODE_PRODUCTION,
                'checkbox',
                [
                    'label' => $this->translator->trans(
                        'Use the production mode ?',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::MODE_PRODUCTION,
                        'help' => $this->translator->trans(
                            'If not checked the test mode will be used.',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    ],
                    'required' => false,
                    'constraints' => [],
                    'value' => TNTFrance::getConfigValue(TNTFranceConfigValue::MODE_PRODUCTION, false),
                ]
            )
            ->add(
                TNTFranceConfigValue::USE_INDIVIDUAL,
                'checkbox',
                [
                    'label' => $this->translator->trans(
                        'Use individual delivery',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::USE_INDIVIDUAL,
                    ],
                    'required' => false,
                    'constraints' => [],
                    'value' => TNTFrance::getConfigValue(TNTFranceConfigValue::USE_INDIVIDUAL, false),
                ]
            )
            ->add(
                TNTFranceConfigValue::USE_ENTERPRISE,
                'checkbox',
                [
                    'label' => $this->translator->trans(
                        'Use enterprise delivery',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::USE_ENTERPRISE,
                    ],
                    'required' => false,
                    'constraints' => [],
                    'value' => TNTFrance::getConfigValue(TNTFranceConfigValue::USE_ENTERPRISE, false),
                ]
            )
            ->add(
                TNTFranceConfigValue::USE_DEPOT,
                'checkbox',
                [
                    'label' => $this->translator->trans(
                        'Use TNT depot delivery',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::USE_DEPOT,
                    ],
                    'required' => false,
                    'constraints' => [],
                    'value' => TNTFrance::getConfigValue(TNTFranceConfigValue::USE_DEPOT, false),
                ]
            )
            ->add(
                TNTFranceConfigValue::USE_DROPOFFPOINT,
                'checkbox',
                [
                    'label' => $this->translator->trans(
                        'Use drop off point delivery',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::USE_DROPOFFPOINT,
                    ],
                    'required' => false,
                    'constraints' => [],
                    'value' => TNTFrance::getConfigValue(TNTFranceConfigValue::USE_DROPOFFPOINT, false),
                ]
            )
            ->add(
                TNTFranceConfigValue::PRODUCTS_ENABLED,
                'text',
                [
                    'label' => $this->translator->trans(
                        'List of available products',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::PRODUCTS_ENABLED,
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::PRODUCTS_ENABLED),
                ]
            )
            ->add(
                TNTFranceConfigValue::OPTIONS_ENABLED,
                'text',
                [
                    'label' => $this->translator->trans(
                        'List of available options',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::OPTIONS_ENABLED,
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::OPTIONS_ENABLED),
                ]
            )
            ->add(
                TNTFranceConfigValue::REGULAR_PICKUP,
                'checkbox',
                [
                    'label' => $this->translator->trans(
                        'Regular pickup',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::REGULAR_PICKUP,
                    ],
                    'required' => false,
                    'constraints' => [],
                    'value' => TNTFrance::getConfigValue(TNTFranceConfigValue::REGULAR_PICKUP, false),
                ]
            )
            ->add(
                TNTFranceConfigValue::LABEL_FORMAT,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Print format, options',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::LABEL_FORMAT,
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::LABEL_FORMAT),
                ]
            )
            ->add(
                TNTFranceConfigValue::FREE_SHIPPING,
                'checkbox',
                [
                    'label' => $this->translator->trans(
                        'Use free shipping',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::FREE_SHIPPING,
                    ],
                    'required' => false,
                    'constraints' => [],
                    'value' => TNTFrance::getConfigValue(TNTFranceConfigValue::FREE_SHIPPING, false),
                ]
            )
            ->add(
                TNTFranceConfigValue::MAX_WEIGHT_PACKAGE,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Max weight per package (kg)',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::MAX_WEIGHT_PACKAGE,
                    ],
                    'required' => false,
                    'constraints' => [],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::MAX_WEIGHT_PACKAGE),
                ]
            )
            ->add(
                TNTFranceConfigValue::TRACKING_URL,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Parcel tracking URL',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::TRACKING_URL,
                        'help' => $this->translator->trans(
                            '%tracking-number% will be replaced by the parcel tracking number.',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    ],
                    'required' => false,
                    'constraints' => [],
                    'data' => TNTFrance::getConfigValue(TNTFranceConfigValue::TRACKING_URL),
                ]
            );
    }
}
