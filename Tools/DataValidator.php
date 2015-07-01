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

namespace TNTFrance\Tools;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints;
use Thelia\Core\Translation\Translator;
use TNTFrance\TNTFrance;

/**
 * Class DataValidator
 * @author Julien Chanséaume <julien@thelia.net>
 */
class DataValidator
{
    /**
     * @param $data
     * @param $service
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    public static function validateData($data, $service)
    {
        $translator = Translator::getInstance();

        $validator = Validation::createValidator();

        $constraints = new Constraints\Collection([
            'fields' => [
                'tnt_service' => [
                    new Constraints\Choice([
                        'choices' => array('INDIVIDUAL', 'ENTERPRISE', 'DEPOT', 'DROPOFFPOINT'),
                        'message' => $translator->trans('Unknown service', [], TNTFrance::MESSAGE_DOMAIN),
                        'groups' => ['INDIVIDUAL', 'ENTERPRISE', 'DEPOT', 'DROPOFFPOINT']
                    ])
                ],
                'tnt_serviceCode' => [
                    new Constraints\Length([
                        'min' => 1,
                        'minMessage' => $translator->trans('The service is not valid', [], TNTFrance::MESSAGE_DOMAIN),
                        'groups' => ['INDIVIDUAL', 'ENTERPRISE', 'DEPOT', 'DROPOFFPOINT']
                    ])
                ],
                'tnt_instructions' => [
                    new Constraints\Length([
                        'min' => 0,
                        'max' => 60,
                        'maxMessage' => $translator->trans('Instructions are too long', [], TNTFrance::MESSAGE_DOMAIN),
                        'groups' => ['INDIVIDUAL', 'ENTERPRISE', 'DEPOT', 'DROPOFFPOINT']
                    ])
                ],
                'tnt_contactLastName' => [
                    new Constraints\NotBlank([
                        'groups' => ['DEPOT', 'DROPOFFPOINT']
                    ]),
                    new Constraints\Length([
                        'min' => 0,
                        'max' => 19,
                        'maxMessage' => $translator->trans('Last name is too long', [], TNTFrance::MESSAGE_DOMAIN),
                        'groups' => ['DEPOT', 'DROPOFFPOINT']
                    ])
                ],
                'tnt_contactFirstName' => [
                    new Constraints\NotBlank([
                        'groups' => ['DEPOT', 'DROPOFFPOINT']
                    ]),
                    new Constraints\Length([
                        'min' => 0,
                        'max' => 12,
                        'maxMessage' => $translator->trans('First name is too long', [], TNTFrance::MESSAGE_DOMAIN),
                        'groups' => ['DEPOT', 'DROPOFFPOINT']
                    ])
                ],
                'tnt_emailAdress' => [
                    new Constraints\Email([
                        'groups' => ['DEPOT', 'DROPOFFPOINT']
                    ]),
                    new Constraints\Length([
                        'min' => 0,
                        'max' => 60,
                        'maxMessage' => $translator->trans('Email is too long', [], TNTFrance::MESSAGE_DOMAIN),
                        'groups' => ['DEPOT', 'DROPOFFPOINT']
                    ])
                ],
                'tnt_phoneNumber' => [
                    new Constraints\NotBlank([
                        'groups' => ['INDIVIDUAL', 'DROPOFFPOINT']
                    ]),
                    new Constraints\Length([
                        'min' => 0,
                        'max' => 60,
                        'maxMessage' => $translator->trans('Phone number is too long', [], TNTFrance::MESSAGE_DOMAIN),
                        'groups' => ['INDIVIDUAL', 'DROPOFFPOINT']
                    ])
                ],

                'tnt_pexcode' => new Constraints\NotBlank([
                    'groups' => ['DEPOT']
                ]),
                'tnt_depot_address' => new Constraints\NotBlank([
                    'groups' => ['DEPOT']
                ]),

                'tnt_xettcode' => new Constraints\NotBlank([
                    'groups' => ['DROPOFFPOINT']
                ]),
                'tnt_dop_address' => new Constraints\NotBlank([
                    'groups' => ['DROPOFFPOINT']
                ])
            ],
            //'groups' => ['INDIVIDUAL', 'ENTERPRISE', 'DEPOT', 'DROPOFFPOINT'],
            'allowMissingFields' => true,
            'allowExtraFields' => true
        ]);

        $errors = $validator->validateValue($data, $constraints, [$service]);

        return $errors;
    }
}
