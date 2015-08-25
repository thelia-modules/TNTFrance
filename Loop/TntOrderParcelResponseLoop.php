<?php
/**
 * Created by PhpStorm.
 * User: gbarral
 * Date: 09/06/15
 * Time: 11:20
 */

namespace TNTFrance\Loop;


use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\Map\OrderProductTableMap;
use Thelia\Model\Map\OrderTableMap;
use Thelia\Type\EnumListType;
use Thelia\Type\TypeCollection;
use TNTFrance\Model\Map\TntOrderExpeditionTableMap;
use TNTFrance\Model\Map\TntOrderParcelResponseTableMap;
use TNTFrance\Model\TntOrderParcelResponseQuery;

class TntOrderParcelResponseLoop extends BaseLoop implements PropelSearchLoopInterface
{

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var \TNTFrance\Model\TntOrderParcelResponse $tntOrderParcelResponse */
        foreach ($loopResult->getResultDataCollection() as $tntOrderParcelResponse) {

            $loopResultRow = new LoopResultRow($tntOrderParcelResponse);
            $loopResultRow
                ->set("ID", $tntOrderParcelResponse->getId())
                ->set("ACCOUNT_ID", $tntOrderParcelResponse->getAccountId())
                ->set("SEQUENCE_NUMBER", $tntOrderParcelResponse->getSequenceNumber())
                ->set("PARCEL_NUMBER_ID", $tntOrderParcelResponse->getParcelNumberId())
                ->set("STICKER_NUMBER", $tntOrderParcelResponse->getStickerNumber())
                ->set("TRACKING_URL", $tntOrderParcelResponse->getTrackingUrl())
                ->set("ORDER_PRODUCT_ID", $tntOrderParcelResponse->getOrderProductId())
                ->set("PRODUCT_SALE_ELEMENTS_REF", $tntOrderParcelResponse->getOrderProduct()->getProductSaleElementsRef())
                ->set("ORDER_ID", $tntOrderParcelResponse->getOrderProduct()->getOrderId())
                ->set("PICK_UP_NUMBER", $tntOrderParcelResponse->getPickUpNumber())
                ->set("FILE_NAME", $tntOrderParcelResponse->getFileName())
                ->set("PRINTED", $tntOrderParcelResponse->getPrinted())
                ->set("WEIGHT", $tntOrderParcelResponse->getWeight())
            ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    /**
     * Definition of loop arguments
     *
     * example :
     *
     * public function getArgDefinitions()
     * {
     *  return new ArgumentCollection(
     *
     *       Argument::createIntListTypeArgument('id'),
     *           new Argument(
     *           'ref',
     *           new TypeCollection(
     *               new Type\AlphaNumStringListType()
     *           )
     *       ),
     *       Argument::createIntListTypeArgument('category'),
     *       Argument::createBooleanTypeArgument('new'),
     *       ...
     *   );
     * }
     *
     * @return \Thelia\Core\Template\Loop\Argument\ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('account_id'),
            Argument::createIntListTypeArgument('order_id'),
            Argument::createIntListTypeArgument('order_product_id'),
            Argument::createIntListTypeArgument('id'),
            Argument::createBooleanTypeArgument('printed'),
            Argument::createAnyTypeArgument('file_name'),
            Argument::createIntListTypeArgument('sequence_number'),
            new Argument(
                'group_by',
                new TypeCollection(
                    new EnumListType(
                        [
                            'package', 'sticker', 'order_product'
                        ]
                    )
                ),
                'id'
            )
        );
    }

    /**
     * this method returns a Propel ModelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $search = TntOrderParcelResponseQuery::create();

        //Join order_product table
        $orderProductJoin = new Join(
            TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID,
            OrderProductTableMap::ID,
            Criteria::INNER_JOIN
        );
        $search->addJoinObject($orderProductJoin, 'order_product_join');

        //Join order_product table
        $orderJoin = new Join(
            OrderProductTableMap::ORDER_ID,
            OrderTableMap::ID,
            Criteria::INNER_JOIN
        );
        $search->addJoinObject($orderJoin, 'order_join');

        if (null !== $accountId = $this->getAccountId()) {
            $search->filterByAccountId($accountId, Criteria::IN);
        }

        if (null !== $orderProductId = $this->getOrderProductId()) {
            $search->addJoinCondition(
                'order_product_join',
                'order_product.id IN ('.implode(',', $orderProductId).')'
            );
        }

        if (null !== $orderId = $this->getOrderId()) {
            $search->addJoinCondition(
                'order_join',
                'order.id IN ('.implode(',', $orderId).')'
            );
        }

        if (null !== $id = $this->getId()) {
            $search->filterById($id, Criteria::IN);
        }

        if (null != $printed = $this->getPrinted()) {
            $search->filterByPrinted($printed, Criteria::EQUAL);
        }

        if (null != $fileName = $this->getFileName()) {
            $search->filterByFileName($fileName, Criteria::LIKE);
        }

        if (null != $sequenceNumber = $this->getSequenceNumber()) {
            $search->filterBySequenceNumber($sequenceNumber, Criteria::IN);
        }

        if (null != $groupBys  = $this->getGroupBy()) {
            foreach ($groupBys as $groupBy) {
                switch ($groupBy) {
                    case "id":
                        $search->groupById();
                        break;

                    case "package":
                        $search->groupByFileName();
                        $search->groupBySequenceNumber();
                        break;

                    case "sticker":
                        $search->groupByFileName();
                        break;

                    case "order_product":
                        $search->groupByOrderProductId();
                        break;
                }
            }
        }

        return $search;
    }
}
