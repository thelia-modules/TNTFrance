<?php
/**
 * Created by PhpStorm.
 * User: gbarral
 * Date: 03/07/15
 * Time: 16:17
 */

namespace TNTFrance\Loop;


use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Type\EnumListType;
use Thelia\Type\TypeCollection;
use TNTFrance\Model\TntPriceWeightQuery;

class TntPriceWeightLoop extends BaseLoop implements PropelSearchLoopInterface
{

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var \TNTFrance\Model\TntPriceWeight $tntPriceWeight */
        foreach ($loopResult->getResultDataCollection() as $tntPriceWeight) {

            $loopResultRow = new LoopResultRow($tntPriceWeight);
            $loopResultRow
                ->set("ID", $tntPriceWeight->getId())
                ->set("AREA_ID", $tntPriceWeight->getAreaId())
                ->set("TNT_PRODUCT_LABEL", $tntPriceWeight->getTntProductLabel())
                ->set("TNT_PRODUCT_CODE", $tntPriceWeight->getTntProductCode())
                ->set("WEIGHT", $tntPriceWeight->getWeight())
                ->set("PRICE", $tntPriceWeight->getPrice())
                ->set("PRICE_KG_SUP", $tntPriceWeight->getPriceKgSup())
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
            Argument::createIntListTypeArgument('area_id'),
            Argument::createAnyTypeArgument('tnt_product_code'),
            new Argument(
                'order_by',
                new TypeCollection(
                    new EnumListType(
                        [
                            'area_id', 'tnt_product_code', 'tnt_product_label'
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
        $search = TntPriceWeightQuery::create();

        if (null !== $areaId = $this->getAreaId()) {
            $search->filterByAreaId($areaId, Criteria::IN);
        }

        if (null !== $tntProductCodes = $this->getTntProductCode()) {

            $search->filterByTntProductCode(explode(',', $tntProductCodes) , Criteria::IN);
        }

        if (null != $orderBys  = $this->getOrderBy()) {
            foreach ($orderBys as $orderBy) {
                switch ($orderBy) {
                    case "id":
                        $search->orderById();
                        break;

                    case "area_id":
                        $search->orderByAreaId();
                        break;

                    case "tnt_product_code":
                        $search->orderByTntProductCode();
                        break;

                    case "tnt_product_label":
                        $search->orderByTntProductLabel();
                        break;
                }
            }
        }

        return $search;
    }
}
