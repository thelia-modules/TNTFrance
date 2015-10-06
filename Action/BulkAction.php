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


namespace TNTFrance\Action;

use Propel\Runtime\ActiveQuery\Criteria;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Model\OrderProductQuery;
use Thelia\Model\OrderQuery;
use Thelia\Model\OrderStatusQuery;
use TNTFrance\Event\Module\TNTFranceCreateExpeditionEvent;
use TNTFrance\Event\Module\TNTFranceEvents;
use TNTFrance\Event\Module\TNTFranceExportEvent;
use TNTFrance\Event\Module\TNTFrancePrintExpeditionEvent;
use TNTFrance\Model\TntOrderParcelResponse;
use TNTFrance\Model\TntOrderParcelResponseQuery;
use TNTFrance\TNTFrance;
use TNTFrance\Tools\ParcelsRequestBuilder;
use TNTFrance\Tools\ReceiverBuilder;
use TNTFrance\WebService\CreateExpedition;
use TNTFrance\WebService\Model\TNTExpedition;
use TNTFrance\WebService\WebServiceFactory;

/**
 * Class BulkAction
 * @package TNTFrance\Action
 * @author Julien Chanséaume <julien@thelia.net>
 */
class BulkAction implements EventSubscriberInterface
{
    protected $wsFactory;

    public function __construct(WebServiceFactory $wsFactory)
    {
        $this->wsFactory = $wsFactory;
    }

    public function export(TNTFranceExportEvent $event)
    {

        $data = [];

        if (!empty($orderIdList)) {

            foreach ($event->getOrders() as $orderId => $orderDataSubmited) {

                if (null != $order = OrderQuery::create()->findPk($orderId)) {
                    // TNT data
                    $tntData = TNTFrance::getExtraOrderData($order, false);

                    if (array_key_exists(TNTFranceExportEvent::ORDER_PRODUCTS_LBL, $orderDataSubmited) &&
                        array_key_exists(TNTFranceExportEvent::ALL_IN_ONE_LBL, $orderDataSubmited) &&
                        $orderDataSubmited[TNTFranceExportEvent::ALL_IN_ONE_LBL] != TNTFranceExportEvent::ALL_IN_ONE) {

                        $order->clearOrderProducts();
                        $order->setOrderProducts(
                            OrderProductQuery::create()->findPks($orderDataSubmited[TNTFranceExportEvent::ORDER_PRODUCTS_LBL])
                        );

                    }

                    $ws = $this->getWSCreateExpedition(
                        $order,
                        $tntData,
                        $event->getShippingDate()
                    );

                    $orderData = $ws->getRequestArgs()['parameters'];

                    // Order Data
                    $orderData["order_id"] = $order->getId();
                    $orderData["order_ref"] = $order->getRef();
                    $orderData["order_invoice_ref"] = $order->getInvoiceRef();

                    $data[] = $orderData;
                }



            }

        }

        $event->setData($data);

    }

    protected function getWSCreateExpedition($order, $data, $shippingDate = null, $allInOne = true, $accountId = null)
    {
        /** @var CreateExpedition $ws */
        $ws = $this->wsFactory->get('createExpedition', $accountId);

        $receiver = ReceiverBuilder::getFromOrder($order);

        $parcelsRequest = ParcelsRequestBuilder::getFromOrder($order, $allInOne);

        $ws
            ->setServiceCode($data['tnt_serviceCode'])
            ->setShippingDate($shippingDate)
            ->setParcelsRequest($parcelsRequest)
            ->setQuantity(count($parcelsRequest))
            ->setReceiver($receiver)
        ;

        return $ws;
    }
    
    public function createExpedition(TNTFranceCreateExpeditionEvent $event)
    {
        $accountId = $event->getAccountId();
        $order = $event->getOrder();

        if (null !== $order) {

            $tntData = TNTFrance::getExtraOrderData($order->getId(), false);
            $ws = $this->getWSCreateExpedition(
                $order,
                $tntData,
                $event->getShippingDate(),
                $event->getAllInOne(),
                $accountId
            );

            /* @var TNTExpedition $tntExpedition */
            $tntExpedition = $ws->exec();

            if (null !== $tntExpedition) {

                $event->setExpedition($tntExpedition);

                $tntData = $tntExpedition->toArray();
                $fileName = null;

                foreach ($order->getOrderProducts() as $orderProduct) {

                    //One pdf contain all stickers, it is not necessary to save it for each orderProduct
                    if (is_null($fileName)) {

                        $fileName = $orderProduct->getId().'.pdf';
                        file_put_contents(TNTFrance::getUploadDirectory() . $fileName, $tntData['pdfLabels']);

                    }


                    /** @var \TNTFrance\WebService\Model\TNTParcelResponse $parcelResponse */
                    foreach ($tntData["parcelResponses"] as $parcelResponse) {

                        $weight = 0;
                        /** @var \TNTFrance\WebService\Model\TNTParcelRequest $parcelRequest */
                        foreach ($ws->getParcelsRequest() as $parcelRequest) {
                            if ($parcelRequest->getSequenceNumber() == $parcelResponse->getSequenceNumber()) {
                                $weight = $parcelRequest->getWeight();
                                break;
                            }
                        }
                        (new TntOrderParcelResponse())
                            ->setAccountId($accountId)
                            ->setOrderProductId($orderProduct->getId())
                            ->setFileName($fileName)
                            ->setPickUpNumber($tntData['pickUpNumber'])
                            ->setSequenceNumber($parcelResponse->getSequenceNumber())
                            ->setParcelNumberId($parcelResponse->getParcelNumber())
                            ->setStickerNumber($parcelResponse->getStickerNumber())
                            ->setTrackingUrl($parcelResponse->getTrackingURL())
                            ->setPrinted(0)
                            ->setWeight($weight)
                            ->save()
                        ;
                    }

                }

                //If this order is not processing yet, change its status
                if ($order->getStatusId() != OrderStatusQuery::getProcessingStatus()->getId()) {
                    //Reload the order with the correct orderProducts
                    $orderProducts = OrderProductQuery::create()->filterByOrderId($order->getId())->find();
                    $order->setOrderProducts($orderProducts);

                    $orderEvent = new OrderEvent($order);
                    $orderEvent->setStatus(OrderStatusQuery::getProcessingStatus()->getId());
                    $event->getDispatcher()->dispatch(TheliaEvents::ORDER_UPDATE_STATUS, $orderEvent);
                }
            }
        }
    }

    public function printExpedition(TNTFrancePrintExpeditionEvent $event)
    {
        //Foreach sticker, verify if all the sticker's order are printed. if true, update the order status
        foreach ($event->getTntOrderParceResponses() as $tntOrderParcelResponse) {

            //Find all the packages with the same pdf
            $tntOrderParcelResponses = TntOrderParcelResponseQuery::create()
                ->filterByFileName($tntOrderParcelResponse->getFileName(), Criteria::LIKE)
                ->find()
            ;

            /** @var \TNTFrance\Model\TntOrderParcelResponse $response */
            foreach ($tntOrderParcelResponses as $response) {
                $response->setPrinted(1)->save();
            }

            if (null != $orderProductConcerned = OrderProductQuery::create()
                    ->findPk($tntOrderParcelResponse->getOrderProductId())) {

                //If all packages are send for this order, then update the order status
                $orderProducts = OrderProductQuery::create()
                    ->filterByOrderId($orderProductConcerned->getOrderId())
                    ->find()
                ;

                $allPackagesSent = true;
                /** @var \Thelia\Model\OrderProduct $orderProduct */
                foreach ($orderProducts as $orderProduct) {

                    $responses = TntOrderParcelResponseQuery::create()
                            ->filterByOrderProductId($orderProduct->getId())
                            ->find()
                    ;

                    if (count($responses) > 0) {

                        /** @var \TNTFrance\Model\TntOrderParcelResponse $response */
                        foreach ($responses as $response) {

                            if ($response->getPrinted() == 0) {
                                $allPackagesSent = false;
                                break;
                            }
                        }
                    } else {
                        $allPackagesSent = false;
                        break;
                    }
                }

                $order = $tntOrderParcelResponse->getOrderProduct()->getOrder();
                if ($allPackagesSent &&
                    $order->getStatusId() != OrderStatusQuery::getSentStatus()->getId()) {
                    //Update order status
                    $orderEvent = new OrderEvent($order);
                    $orderEvent->setStatus(OrderStatusQuery::getSentStatus()->getId());
                    $event->getDispatcher()->dispatch(TheliaEvents::ORDER_UPDATE_STATUS, $orderEvent);
                }

            }
        }
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return [
            TNTFranceEvents::TNT_FRANCE_EXPORT => ['export', 128],
            TNTFranceEvents::TNT_FRANCE_CREATE_EXPEDITION => ['createExpedition', 128],
            TNTFranceEvents::TNT_FRANCE_PRINT_EXPEDITION => ['printExpedition', 128]
        ];
    }
}
