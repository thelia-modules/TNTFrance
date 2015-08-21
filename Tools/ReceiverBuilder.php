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

use Thelia\Core\Translation\Translator;
use Thelia\Model\Order;
use Thelia\Model\OrderAddressQuery;
use TNTFrance\TNTFrance;
use TNTFrance\WebService\Model\TNTReceiver;

/**
 * Class ReceiverBuilder
 * @package TNTFrance\Tools
 * @author Julien Chanséaume <julien@thelia.net>
 */
class ReceiverBuilder
{
    public static function getFromOrder(Order $order)
    {
        $translator = Translator::getInstance();

        if ($order->getDeliveryModuleId() !== TNTFrance::getModuleId()) {
            throw new \InvalidArgumentException(
                $translator->trans(
                    "The order %id does not use the",
                    ['id' => $order->getId()],
                    TNTFrance::MESSAGE_DOMAIN
                )
            );
        }

        $data = TNTFrance::getExtraOrderData($order->getId(), false);

        if (empty($data)) {
            throw new \InvalidArgumentException(
                $translator->trans(
                    "No TNT data for order %id",
                    ['id' => $order->getId()],
                    TNTFrance::MESSAGE_DOMAIN
                )
            );
        }

        $receiver = new TNTReceiver();

        $receiver->setType($data['tnt_service']);
        $receiver->setEmailAddress($order->getCustomer()->getEmail());
        if (array_key_exists('tnt_instructions', $data)) {
            $receiver->setInstructions($data['tnt_instructions']);
        }

        if (array_key_exists('tnt_phoneNumber', $data)) {
            $phoneNumber = str_replace(" ", "", $data['tnt_phoneNumber']);
            $receiver->setPhoneNumber($phoneNumber);

        }

        //todo : $receiver->setSendNotification(TNTFrance::getConfigValue(TNTFranceConfigValue::NOTIFICATION_USER));

        switch ($data['tnt_service']) {
            case 'INDIVIDUAL':
            case 'ENTERPRISE':
                $address = OrderAddressQuery::create()->findPk($order->getDeliveryOrderAddressId());
                if (null !== $address) {
                    $receiver
                        ->setName($address->getCompany())
                        ->setAddress1($address->getAddress1())
                        ->setAddress2($address->getAddress2())
                        ->setZipCode($address->getZipcode())
                        ->setCity($address->getCity())
                        ->setContactLastName($address->getLastname())
                        ->setContactFirstName($address->getFirstname())
                    ;

                    if (array_key_exists('tnt_accessCode', $data)) {
                        $receiver->setAccessCode($data['tnt_accessCode']);
                    }

                    if (array_key_exists('tnt_floorNumber', $data)) {
                        $receiver->setAccessCode($data['tnt_floorNumber']);
                    }

                    if (array_key_exists('tnt_buildingId', $data)) {
                        $receiver->setAccessCode($data['tnt_buildingId']);
                    }
                }
                break;
            case 'DEPOT':
                $receiver
                    ->setTypeId($data['tnt_pexcode'])
                    ->setCity($data['tnt_depot_address']['city']);
                break;
            case 'DROPOFFPOINT':
                $receiver
                    ->setTypeId($data['tnt_exttcode']);
                break;
            default:
                throw new \InvalidArgumentException(
                    $translator->trans(
                        "TNT service %service is not valid for order %id",
                        ['%id' => $order->getId(), '%service' => $data['tnt_service']],
                        TNTFrance::MESSAGE_DOMAIN
                    )
                );
        }

        return $receiver;
    }
}
