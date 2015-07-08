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
use Thelia\Model\OrderProduct;
use TNTFrance\Event\Module\TNTFranceCreateExpeditionEvent;
use TNTFrance\Model\Config\TNTFranceConfigValue;
use TNTFrance\TNTFrance;
use TNTFrance\WebService\Model\TNTParcelRequest;

/**
 * Class ParcelsRequestBuilder
 * @package TNTFrance\Tools
 * @author Julien Chanséaume <julien@thelia.net>
 */
class ParcelsRequestBuilder
{
    public static function getFromOrder(Order $order, $allInOne = true)
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

        $maxWeightPackage = TNTFrance::getConfigValue(TNTFranceConfigValue::MAX_WEIGHT_PACKAGE, 25);

        $parcelsRequest = [];

        $orderTotalWeight = 0;
        $packages = [];

        foreach ($order->getOrderProducts() as $orderProduct) {
            $orderProductWeight = $orderProduct->getQuantity() * $orderProduct->getWeight();
            $orderTotalWeight += $orderProductWeight;

            if (!$allInOne) {
                //If customer has choosen a manual number of package
                if ($orderProduct->getVirtualColumn(TNTFranceCreateExpeditionEvent::PACKAGE) &&
                    intval($orderProduct->getVirtualColumn(TNTFranceCreateExpeditionEvent::PACKAGE)) == $orderProduct->getVirtualColumn(TNTFranceCreateExpeditionEvent::PACKAGE)) {
                    $orderProductPackages = $orderProduct->getVirtualColumn(TNTFranceCreateExpeditionEvent::PACKAGE);
                } else {

                    if ($maxWeightPackage != 0) {
                        $orderProductPackages = ceil($orderProductWeight / $maxWeightPackage);
                    } else {
                        $orderProductPackages = 1;
                    }

                }

                //Divide the weight between packages
                for ($i = 1; $i <= $orderProductPackages; $i++) {
                    $packages[] = round($orderProductWeight / $orderProductPackages, 2);
                }

            }
        }

        if ($allInOne) {
            //If customer has choosen a manual number of package
            if ($order->getVirtualColumn(TNTFranceCreateExpeditionEvent::PACKAGE) &&
                intval($order->getVirtualColumn(TNTFranceCreateExpeditionEvent::PACKAGE)) == $order->getVirtualColumn(TNTFranceCreateExpeditionEvent::PACKAGE)) {
                $orderPackages = $order->getVirtualColumn(TNTFranceCreateExpeditionEvent::PACKAGE);
            } else {
                $orderPackages = ceil($orderTotalWeight / $maxWeightPackage);
            }

            //Divide the weight between packages
            for ($i = 1; $i <= $orderPackages; $i++) {
                $packages[] = round($orderTotalWeight / $orderPackages, 2);
            }
        }


        foreach ($packages as $key => $packageWeight) {
            $parcelRequest = new TNTParcelRequest();
            $parcelRequest
                ->setSequenceNumber($key + 1)
                ->setCustomerReference($order->getCustomer()->getRef())
                ->setWeight($packageWeight)
                //->setComment($data['tnt_instructions'])
            ;

            $parcelsRequest[] = $parcelRequest;
        }

        if (count($parcelsRequest) == 0) {
            $parcelRequest = new TNTParcelRequest();

            $weight = 0.0;
            /** @var OrderProduct $orderProduct */
            foreach ($order->getOrderProducts() as $orderProduct) {
                $weight += $orderProduct->getQuantity() * floatval($orderProduct->getWeight());
            }

            $parcelRequest->setWeight($weight);
            $parcelRequest->setSequenceNumber(1);
            //$parcelRequest->setComment($data['tnt_instructions']);
            $parcelRequest->setCustomerReference($order->getCustomer()->getRef());

            $parcelsRequest[] = $parcelRequest;
        }



        return $parcelsRequest;
    }
}
