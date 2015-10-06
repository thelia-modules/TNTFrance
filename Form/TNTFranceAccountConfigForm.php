<?php

namespace TNTFrance\Form;

use Symfony\Component\Validator\Constraints\NotBlank;
use Thelia\Form\BaseForm;
use TNTFrance\Model\Config\TNTFranceConfigValue;
use TNTFrance\TNTFrance;

class TNTFranceAccountConfigForm extends BaseForm
{
    public function getName()
    {
        return 'tntfrance_account_config_form';
    }

    protected function buildForm()
    {
        $accountId = $this->getRequest()->attributes->get('id');

        $this->formBuilder
            ->add(
                TNTFranceConfigValue::ACCOUNT_LABEL,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Account label',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::ACCOUNT_LABEL,
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::ACCOUNT_LABEL),
                ]
            )
            ->add(
                TNTFranceConfigValue::ACCOUNT_NUMBER,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Your myTNT Account Number',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::ACCOUNT_NUMBER,
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::ACCOUNT_NUMBER),
                ]
            )
            ->add(
                TNTFranceConfigValue::USERNAME,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Your myTNT username',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::USERNAME,
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::USERNAME),
                ]
            )
            ->add(
                TNTFranceConfigValue::PASSWORD,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Password',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::PASSWORD,
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::PASSWORD),
                ]
            )
            ->add(
                TNTFranceConfigValue::SENDER_NAME,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Name',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::SENDER_NAME,
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::SENDER_NAME),
                ]
            )
            ->add(
                TNTFranceConfigValue::SENDER_ADDRESS1,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Address 1',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::SENDER_ADDRESS1,
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::SENDER_ADDRESS1),
                ]
            )
            ->add(
                TNTFranceConfigValue::SENDER_ADDRESS2,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Address 2',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::SENDER_ADDRESS2,
                    ],
                    'required' => false,
                    'constraints' => [],
                    'data' => TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::SENDER_ADDRESS2),
                ]
            )
            ->add(
                TNTFranceConfigValue::SENDER_ZIP_CODE,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Zip code',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::SENDER_ZIP_CODE,
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::SENDER_ZIP_CODE),
                ]
            )
            ->add(
                TNTFranceConfigValue::SENDER_CITY,
                'text',
                [
                    'label' => $this->translator->trans(
                        'City',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::SENDER_CITY,
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::SENDER_CITY),
                ]
            )
            ->add(
                TNTFranceConfigValue::CONTACT_LASTNAME,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Contact last name',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::CONTACT_LASTNAME,
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::CONTACT_LASTNAME),
                ]
            )
            ->add(
                TNTFranceConfigValue::CONTACT_FIRSTNAME,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Contact first name',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => 'contact_firstname',
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::CONTACT_FIRSTNAME),
                ]
            )
            ->add(
                TNTFranceConfigValue::CONTACT_EMAIL,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Contact email',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::CONTACT_EMAIL,
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::CONTACT_EMAIL),
                ]
            )
            ->add(
                TNTFranceConfigValue::CONTACT_PHONE,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Contact phone number',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::CONTACT_PHONE,
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::CONTACT_PHONE),
                ]
            )
            ->add(
                TNTFranceConfigValue::NOTIFICATION_EMAILS,
                'text',
                [
                    'label' => $this->translator->trans(
                        'Notification emails',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::NOTIFICATION_EMAILS,
                        'help' => $this->translator->trans(
                            'List of emails (separated by a ,) that will be notified on pick up anomaly.',
                            [],
                            TNTFrance::MESSAGE_DOMAIN
                        ),
                    ],
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ],
                    'data' => TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::NOTIFICATION_EMAILS),
                ]
            )
            ->add(
                TNTFranceConfigValue::NOTIFICATION_SUCCESS,
                'checkbox',
                [
                    'label' => $this->translator->trans(
                        'Notification on successful pick up',
                        [],
                        TNTFrance::MESSAGE_DOMAIN
                    ),
                    'label_attr' => [
                        'for' => TNTFranceConfigValue::NOTIFICATION_SUCCESS,
                    ],
                    'required' => false,
                    'constraints' => [],
                    'value' => TNTFrance::getAccountConfigValue(
                        $accountId,
                        TNTFranceConfigValue::NOTIFICATION_SUCCESS,
                        false
                    ),
                ]
            );
    }
}
