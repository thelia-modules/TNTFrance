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
use Thelia\Model\Map\OrderProductTableMap;
use Thelia\Model\Order;
use TNTFrance\Event\Module\TNTFranceEvents;
use TNTFrance\Event\Module\TNTFrancePrintExpeditionEvent;
use TNTFrance\Model\TntOrderParcelResponseQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Mailer\MailerFactory;

/**
 * Class SendMailAction
 * @package TNTFrance\Action
 * @author Julien Chanséaume <julien@thelia.net>
 */
class SendMailAction implements EventSubscriberInterface
{

    protected $mailer;

    public function __construct(MailerFactory $mailer)
    {
        $this->mailer = $mailer;
    }

    public function printExpedition(TNTFrancePrintExpeditionEvent $event)
    {
        /** @var \Thelia\Model\Order $oldOrder */
        $oldOrder = null;
        $parcelResponses = [];

        foreach ($event->getTntOrderParceResponses() as $key => $tntOrderParcelResponse) {

            $order = $tntOrderParcelResponse->getOrderProduct()->getOrder();

            if (null != $oldOrder &&
                $oldOrder->getId() != $order->getId()) {

                $this->sendEmailFromOrder($oldOrder, $parcelResponses);
                $parcelResponses = [];

            }

            //check if there is many stickers (sequence_number) in the pdf
            $responses = TntOrderParcelResponseQuery::create()
                ->filterByFileName($tntOrderParcelResponse->getFileName())
                ->groupBySequenceNumber()
                ->groupByFileName()
            ;

            /** @var \TNTFrance\Model\TntOrderParcelResponse $response */
            foreach ($responses as $response) {
                //Get all the concerned orderProducts
                $listConcernedOrderProduct = TntOrderParcelResponseQuery::create()
                    ->useOrderProductQuery()
                    ->endUse()
                    ->filterByFileName($response->getFileName(), Criteria::LIKE)
                    ->groupByOrderProductId()
                    ->withColumn(OrderProductTableMap::TITLE, 'order_product_title')
                    ->find()
                    ->toArray()
                ;

                $response->setVirtualColumn('order_products', $listConcernedOrderProduct);
                $parcelResponses[] = $response->toArray();
            }

            if (count($event->getTntOrderParceResponses()) == $key + 1) {
                $this->sendEmailFromOrder($order, $parcelResponses);
            }
        }
    }

    public function sendEmailFromOrder(Order $order, $parcelResponses = [])
    {
        $customer = $order->getCustomer();

        $this->mailer->sendEmailToCustomer(
            'mail_tnt_france',
            $customer,
            [
                'customer_id' => $customer->getId(),
                'order_id' => $order->getId(),
                'order_ref' => $order->getRef(),
                'order_date' => $order->getCreatedAt(),
                'update_date' => $order->getUpdatedAt(),
                'parcel_responses' => $parcelResponses
            ]
        );
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
        return array(
            TNTFranceEvents::TNT_FRANCE_PRINT_EXPEDITION => ['printExpedition', 120]
        );
    }
}
