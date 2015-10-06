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


namespace TNTFrance\Controller;

use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\FileFormat\Formatting\FormatterData;
use Thelia\Core\FileFormat\Formatting\FormatterManagerTrait;
use Thelia\Core\HttpFoundation\Response;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Model\Map\OrderTableMap;
use Thelia\Model\OrderProductQuery;
use Thelia\Model\OrderQuery;
use Thelia\Model\OrderStatus;
use Thelia\Model\OrderStatusQuery;
use TNTFrance\Event\Module\TNTFranceCreateExpeditionEvent;
use TNTFrance\Event\Module\TNTFranceEvents;
use TNTFrance\Event\Module\TNTFranceExportEvent;
use TNTFrance\Event\Module\TNTFrancePrintExpeditionEvent;
use TNTFrance\Model\Config\TNTFranceConfigValue;
use TNTFrance\Model\Map\TntOrderParcelResponseTableMap;
use TNTFrance\Model\TntOrderParcelResponseQuery;
use TNTFrance\TNTFrance;
use ZipArchive;

/**
 * Class TNTFranceAdminController
 * @package TNTFrance\Controller
 * @author Julien Chanséaume <julien@thelia.net>
 */
class TNTFranceAdminController extends BaseAdminController
{
    protected $currentRouter = "router.tntfrance";

    use FormatterManagerTrait;

    public function defaultAction()
    {
        $response = $this->checkAuth(AdminResources::MODULE, TNTFrance::getModuleCode(), AccessManager::VIEW);

        if (null !== $response) {
            return $response;
        }

        return $this->redirectToDefaultPage();
    }

    private function redirectToDefaultPage()
    {
        $accountId = $this->getRequest()->query->get('account', TNTFrance::getDefaultAccountId());

        $accountLabel = TNTFrance::getAccountConfigValue($accountId, TNTFranceConfigValue::ACCOUNT_LABEL);

        $orders_paid_id = OrderQuery::create()
            ->useOrderProductQuery()
                ->filterById(
                    TntOrderParcelResponseQuery::create()->select(TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID)->find()->toArray(),
                    Criteria::NOT_IN
                )
            ->endUse()
            ->filterByDeliveryModuleId(TNTFrance::getModuleId())
            ->orderById(Criteria::DESC)
            ->useOrderStatusQuery()
                ->filterByCode([OrderStatus::CODE_PAID, OrderStatus::CODE_PROCESSING], Criteria::IN)
            ->endUse()
            ->select(OrderTableMap::ID)
            ->find()
            ->toArray()
        ;

        $orders_processing_query = OrderQuery::create();

        if ($accountId !== null) {
            $orders_processing_query
                ->useOrderProductQuery()
                ->filterById(
                    TntOrderParcelResponseQuery::create()
                        ->filterByAccountId($accountId)
                        ->select(TntOrderParcelResponseTableMap::ORDER_PRODUCT_ID)
                        ->find()
                        ->toArray(),
                    Criteria::IN
                )
                ->endUse();
        }

        $orders_processing_id = $orders_processing_query
            ->filterByDeliveryModuleId(TNTFrance::getModuleId())
            ->orderById(Criteria::DESC)
            ->useOrderStatusQuery()
            ->filterByCode(OrderStatus::CODE_PROCESSING)
            ->endUse()
            ->select(OrderTableMap::ID)
            ->find()
            ->toArray()
        ;

        if (empty($orders_paid_id)) {
            $orders_paid_id = null;
        } else {
            $orders_paid_id = implode(',', $orders_paid_id);
        }

        if (empty($orders_processing_id)) {
            $orders_processing_id = null;
        } else {
            $orders_processing_id = implode(',', $orders_processing_id);
        }

        return $this->render(
            "tntfrance-order-list",
            [
                'account_id' => $accountId,
                'account_label' => $accountLabel,
                'orders_paid_id' => $orders_paid_id,
                'orders_processing_id' => $orders_processing_id
            ]
        );
    }

    public function trackingAction()
    {
        $response = $this->checkAuth(AdminResources::MODULE, TNTFrance::getModuleCode(), AccessManager::UPDATE);

        if (null !== $response) {
            return $response;
        }

        $this->checkXmlHttpRequest();

        $orderId = $this->getRequest()->request->get("order_id");
        $trackingNumber = $this->getRequest()->request->get("tracking_number");

        $jsonResponse = [
            'success' => false,
            'message' => ''
        ];

        try {
            $order = OrderQuery::create()->findPk($orderId);

            if (null === $order) {
                throw new \InvalidArgumentException("The order you want to update status does not exist");
            }

            $event = new OrderEvent($order);
            $event->setDeliveryRef($trackingNumber);

            $this->dispatch(TheliaEvents::ORDER_UPDATE_DELIVERY_REF, $event);

            $jsonResponse['success'] = true;
        } catch (\Exception $e) {
            $jsonResponse['message'] = $e->getMessage();
        }

        return $this->jsonResponse(json_encode($jsonResponse));
    }

    public function bulkAction()
    {
        $response = $this->checkAuth(AdminResources::MODULE, TNTFrance::getModuleCode(), AccessManager::UPDATE);

        if (null !== $response) {
            return $response;
        }

        /*
        $this->getTokenProvider()->checkToken(
            $this->getRequest()->query->get("_token")
        );
        */

        $action = $this->getRequest()->request->get("action");

        switch ($action) {
            case 'export':
                return $this->generateExport();
                break;
            case 'create':
                return $this->createExpedition();
                break;
            case 'status':
                return $this->changeStatus();
                break;
            default:
        }

        return $this->defaultAction();
    }

    protected function generateExport()
    {
        $orderIdList =  $this->getRequest()->request->get("order-selection");
        $orderAllInOne =  $this->getRequest()->request->get("order-all-in-one");
        $shippingDate =  $this->getRequest()->request->get("export-date", null);
        $filename = 'tnt-export';

        $dataOrders = [];
        foreach ($orderIdList as $orderId) {

            if (!array_key_exists($orderId, $dataOrders)) {
                $dataOrders[$orderId] = [
                    TNTFranceExportEvent::ALL_IN_ONE_LBL => TNTFranceExportEvent::ALL_IN_ONE
                ];
            }

            if (array_key_exists($orderId, $orderAllInOne)) {
                $dataOrders[$orderId][TNTFranceExportEvent::ALL_IN_ONE_LBL] = $orderAllInOne[$orderId];

                //If there is a package for each order product
                if ($orderAllInOne[$orderId] != TNTFranceExportEvent::ALL_IN_ONE) {

                    if (null != $orderProductIds = $this->getRequest()->request->get("order-product-selection[".$orderId."]", null)) {

                        $dataOrders[$orderId][TNTFranceExportEvent::ORDER_PRODUCTS_LBL] = [];
                        foreach ($orderProductIds as $orderProductId) {
                            $dataOrders[$orderId][TNTFranceExportEvent::ORDER_PRODUCTS_LBL][] = $orderProductId;
                        }
                    }

                }
            }
        }

        $event = new TNTFranceExportEvent($dataOrders);
        $event->setShippingDate($shippingDate);

        $this->dispatch(TNTFranceEvents::TNT_FRANCE_EXPORT, $event);

        /**
         * Get needed services
         */
        $formatterManager = $this->getFormatterManager($this->container);

        try {
            /** @var \Thelia\Core\FileFormat\Formatting\AbstractFormatter $formatter */
            $exportFormat = $this->getRequest()->request->get("export-format", "CSV");
            if (!in_array($exportFormat, ["CSV", "Json", "XML"])) {
                $exportFormat = "CSV";
            }

            $formatter = $formatterManager->get($exportFormat);

            $formatterData = new FormatterData();

            $data = $event->getData();

            if ("CSV" == $exportFormat) {
                $this->flattenArrayRow($data);
            }

            $formatterData->setData($data);

            $formattedContent = $formatter
                ->encode($formatterData)
            ;

            return new Response(
                $formattedContent,
                200,
                [
                    "Content-Type" => $formatter->getMimeType(),
                    "Content-Disposition" =>
                        "attachment; filename=\"" . $filename . "." . strtolower($exportFormat) ."\"",
                ]
            );

        } catch (\Exception $e) {
            throw $e;
        }

        return $this->pageNotFound();
    }

    protected function createExpedition()
    {
        $orderIdList =  $this->getRequest()->request->get("order-selection");
        $orderAllInOne = $this->getRequest()->request->get("order-all-in-one");
        $orderPackage = $this->getRequest()->request->get("order-package");
        $orderProductPackage = $this->getRequest()->request->get("order-product-package");
        $accountId = $this->getRequest()->request->get("account_id");

        if (!is_array($orderIdList)) {
            $orderIdList = [$orderIdList];
        }
        $shippingDate =  $this->getRequest()->request->get("create-date", null);

        $message = null;

        try {
            foreach ($orderIdList as $orderId) {
                $order = OrderQuery::create()->findPk($orderId);

                $orderProductIdList =  $this->getRequest()->request->get("order-product-selection", null);

                if (null === $order) {
                    throw new \InvalidArgumentException("The order you want to create expedition does not exist");
                }

                $event = new TNTFranceCreateExpeditionEvent();

                $event->setAccountId($accountId);

                $order->clearOrderProducts();
                $order->setOrderProducts(
                    OrderProductQuery::create()->findPks($orderProductIdList[$orderId])
                );

                //Order Package
                if (array_key_exists($orderId, $orderPackage)) {
                    $order->setVirtualColumn(TNTFranceCreateExpeditionEvent::PACKAGE, $orderPackage[$orderId]);
                }

                if (array_key_exists($orderId, $orderAllInOne) &&
                    $orderAllInOne[$orderId] == 0) {

                    $event->setAllInOne(false);

                    foreach ($order->getOrderProducts() as $orderProduct) {

                        if (array_key_exists($orderProduct->getId(), $orderProductPackage)) {
                            $orderProduct->setVirtualColumn(
                                TNTFranceCreateExpeditionEvent::PACKAGE,
                                $orderProductPackage[$orderProduct->getId()]
                            );
                        }

                    }
                }



                $event
                    ->setShippingDate($shippingDate)
                    ->setOrder($order)
                ;



                $this->dispatch(TNTFranceEvents::TNT_FRANCE_CREATE_EXPEDITION, $event);
            }

        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        if (null !== $message) {
            $this->getRequest()->getSession()->getFlashBag()->add(
                'tntfrance-error',
                $message
            );
        }

        return $this->generateRedirectFromRoute(
            'tntfrance.orders.list',
            [
                'account' => $accountId,
            ]
        );
    }

    protected function changeStatus()
    {
        $orderIdList =  $this->getRequest()->request->get("order-selection");
        if (!is_array($orderIdList)) {
            $orderIdList = [$orderIdList];
        }

        $statusId =  $this->getRequest()->request->get("status-status", null);
        $message = null;

        try {
            $status = OrderStatusQuery::create()->findPk($statusId);

            if (null === $status) {
                throw new \InvalidArgumentException("The status you want to set to the order does not exist");
            }

            foreach ($orderIdList as $orderId) {
                $order = OrderQuery::create()->findPk($orderId);

                if (null === $order) {
                    throw new \InvalidArgumentException("The order you want to update status does not exist");
                }

                $event = new OrderEvent($order);
                $event->setStatus($statusId);

                $this->dispatch(TheliaEvents::ORDER_UPDATE_STATUS, $event);
            }

        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        if (null !== $message) {
            $this->getRequest()->getSession()->getFlashBag()->add(
                'tntfrance-error',
                $message
            );
        }

        return $this->generateRedirectFromRoute('tntfrance.orders.list');
    }


    protected function flattenArrayRow(array &$data)
    {
        foreach ($data as &$row) {
            $this->flatten($row);

        }
    }


    protected function flatten(array &$data, array $subnode = null, $path = null)
    {
        if (null === $subnode) {
            $subnode = & $data;
        }
        foreach ($subnode as $key => $value) {
            if (is_array($value)) {
                $nodePath = $path ? $path.'.'.$key : $key;
                $this->flatten($data, $value, $nodePath);
                if (null === $path) {
                    unset($data[$key]);
                }
            } elseif (null !== $path) {
                $data[$path.'.'.$key] = $value;
            }
        }
    }

    public function stickerAction()
    {
        $response = $this->checkAuth(AdminResources::MODULE, TNTFrance::getModuleCode(), AccessManager::UPDATE);

        if (null !== $response) {
            return $response;
        }

        $tntOrderParcelResponseIdList = $this->getRequest()->request->get("tnt-order-parcel-response");

        if ($tntOrderParcelResponseIdList) {


            $tntOrderParcelResponses = TntOrderParcelResponseQuery::create()
                ->findPks($tntOrderParcelResponseIdList)
            ;

            $event = new TNTFrancePrintExpeditionEvent($tntOrderParcelResponses);

            $this->dispatch(TNTFranceEvents::TNT_FRANCE_PRINT_EXPEDITION, $event);

            $zipName = "stickers.zip";

            if (file_exists($zipName)) {
                unlink($zipName);
            }

            $zip = new ZipArchive();

            if ($zip->open($zipName, ZipArchive::CREATE) === true) {

                $zip->addEmptyDir('stickers');

                foreach ($event->getTntOrderParceResponses() as $tntOrderParcelResponse) {

                    $fileName = $tntOrderParcelResponse->getOrderProductId() . '.pdf';
                    $filePath = TNTFrance::getUploadDirectory() . $fileName;

                    if (file_exists($filePath)) {
                        $handle = fopen($filePath, 'r');
                        $contents = fread($handle, filesize($filePath));
                        fclose($handle);
                        $zip->addFromString('stickers/'.$fileName, $contents);
                    }

                }

                $zip->close();

                //If no pdf found, zip won't exists
                if (file_exists($zipName)) {
                    if ($downloadZip = fopen($zipName, "r")) {

                        $zipSize = filesize($zipName);

                        header("Content-type: application/zip");
                        header("Content-Disposition: attachment; filename=\"".$zipName."\"");
                        header("Content-length: $zipSize");
                        header('Content-Transfer-Encoding: binary');

                        echo fpassthru($downloadZip); // deliver the zip file

                    }

                    fclose($downloadZip);
                }

            }
        }

        return $this->redirectToDefaultPage();
    }

    public function getValidPickUpDateAction()
    {
        return new Response(json_encode(TNTFrance::getDisablePickUpDate()), 200, array(
            'content-type' => 'application/json'
        ));
    }
}
