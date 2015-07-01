<?php
/**
 * Created by PhpStorm.
 * User: gbarral
 * Date: 16/06/15
 * Time: 16:13
 */

namespace TNTFrance\Smarty;


use Thelia\Model\OrderProductQuery;
use Thelia\Model\OrderQuery;
use TheliaSmarty\Template\AbstractSmartyPlugin;
use TheliaSmarty\Template\an;
use TheliaSmarty\Template\SmartyPluginDescriptor;
use TNTFrance\Model\Config\TNTFranceConfigValue;
use TNTFrance\Model\TntOrderParcelResponseQuery;
use TNTFrance\TNTFrance;

class TNTFormat extends AbstractSmartyPlugin
{

    /**
     * @return an array of SmartyPluginDescriptor
     */
    public function getPluginDescriptors()
    {
        return array(
            new SmartyPluginDescriptor("function", "order_number_package", $this, "orderNumberPackage"),
            new SmartyPluginDescriptor("function", "order_product_number_package", $this, "orderProductNumberPackage"),
            new SmartyPluginDescriptor("function", "order_total_weight", $this, "orderTotalWeight")
        );
    }

    public function orderNumberPackage($params, $template = null)
    {
        $numberOfPackage = 1;

        $maxWeightPackage = TNTFrance::getConfigValue(TNTFranceConfigValue::MAX_WEIGHT_PACKAGE, 25);

        if (null != $orderId = $this->getParam($params, "order_id", null)) {

            if (null != $order = OrderQuery::create()->findPk($orderId)) {

                $orderTotalWeight = 0;
                foreach ($order->getOrderProducts() as $orderProduct) {

                    //Be sure that this orderProduct has no package already
                    if (null == $tntResponse = TntOrderParcelResponseQuery::create()
                            ->findOneByOrderProductId($orderProduct->getId())) {
                        $orderTotalWeight += $orderProduct->getQuantity() * $orderProduct->getWeight();
                    }

                }

                $numberOfPackage = ceil($orderTotalWeight / $maxWeightPackage);
            }
        }

        return $numberOfPackage;
    }

    public function orderProductNumberPackage($params, $template = null)
    {
        $numberOfPackage = 1;

        $maxWeightPackage = TNTFrance::getConfigValue(TNTFranceConfigValue::MAX_WEIGHT_PACKAGE, 25);

        if (null != $orderProductId = $this->getParam($params, "order_product_id", null)) {

            if (null != $orderProduct = OrderProductQuery::create()->findPk($orderProductId)) {

                $orderProductTotalWeight = $orderProduct->getQuantity() * $orderProduct->getWeight();

                $numberOfPackage = ceil($orderProductTotalWeight / $maxWeightPackage);
            }
        }

        return $numberOfPackage;
    }

    public function orderTotalWeight($params, $template = null)
    {
        $totalWeight = 0;

        if (null != $orderId = $this->getParam($params, "order_id", null)) {

            $orderProducts = OrderProductQuery::create()->filterByOrderId($orderId)->find();

            /** @var \Thelia\Model\OrderProduct $orderProduct */
            foreach ($orderProducts as $orderProduct) {
                $totalWeight += $orderProduct->getQuantity() * $orderProduct->getWeight();
            }
        }

        return round($totalWeight, 2);
    }
}
