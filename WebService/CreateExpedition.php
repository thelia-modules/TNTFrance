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


namespace TNTFrance\WebService;

use TNTFrance\WebService\Model\TNTExpedition;
use TNTFrance\WebService\Model\TNTParcelRequest;
use TNTFrance\WebService\Model\TNTParcelResponse;
use TNTFrance\WebService\Model\TNTPayBackInfo;
use TNTFrance\WebService\Model\TNTReceiver;
use TNTFrance\WebService\Model\TNTSender;

/**
 * Class CreateExpedition
 * @package TNTFrance\WebService
 * @author Julien Chanséaume <julien@thelia.net>
 */
class CreateExpedition extends BaseTNTFranceWebService
{
    protected $shippingDate;
    /** @var TNTSender */
    protected $sender;
    /** @var TNTReceiver */
    protected $receiver;
    /** @var string */
    protected $serviceCode;
    protected $quantity = 1;
    /** @var TNTParcelRequest[] */
    protected $parcelsRequest;
    protected $saturdayDelivery = 0;
    /** @var  TNTPayBackInfo */
    protected $paybackInfo;


    public function __construct()
    {
        parent::__construct('expeditionCreation');
    }

    public function getRequestArgs()
    {
        $t = "";
        return [
            'parameters' => [
                'pickUpRequest' => $this->config->getPickUpRequest()->toArray(),
                'shippingDate' => (null === $this->getShippingDate())
                    ? $this->config->getShippingDate()
                    : $this->getShippingDate(),
                'accountNumber' => $this->config->getAccountNumber(),
                'sender' => $this->config->getSender()->toArray(),
                'receiver' => $this->getReceiver()->toArray(),
                'serviceCode' => $this->getServiceCode(),
                'quantity' => $this->getQuantity(),
                'parcelsRequest' => array_map(
                    function (TNTParcelRequest $pr) {
                        return $pr->toArray();
                    },
                    $this->getParcelsRequest()
                ),
                'saturdayDelivery' => $this->getSaturdayDelivery(),
                'paybackInfo' => ($this->getPaybackInfo())?$this->getPaybackInfo()->toArray():null,
                'labelFormat' => $this->config->getLabelFormat()
            ]
        ];
    }

    public function getFormattedResponse(\stdClass $response)
    {
        $expedition = null;

        if (property_exists($response, 'Expedition')) {

            $expedition = new TNTExpedition();

            $expedition->setPdfLabels($response->Expedition->PDFLabels);
            $expedition->setPickUpNumber($response->Expedition->pickUpNumber);

            $parcels = [];

            $nb = count($response->Expedition->parcelResponses);
            if ($nb > 1) {
                foreach ($response->Expedition->parcelResponses as $Colis) {
                    $parcels[] = $this->getTNTParcelResponse($Colis);
                }
            } elseif ($nb == 1) {
                $parcels[] = $this->getTNTParcelResponse($response->Expedition->parcelResponses);
            }

            $expedition->setParcelResponses($parcels);

        }

        return $expedition;

    }

    protected function getTNTParcelResponse(\stdClass $pr)
    {
        $parcelResponse = new TNTParcelResponse();
        $parcelResponse
            ->setSequenceNumber($pr->sequenceNumber)
            ->setParcelNumber($pr->parcelNumber)
            ->setTrackingURL($pr->trackingURL)
            ->setStickerNumber($pr->stickerNumber)
        ;

        return $parcelResponse;
    }

    /**
     * @param TNTParcelRequest[]
     *
     * @return CreateExpedition
     */
    public function setParcelsRequest($parcelsRequest)
    {
        $this->parcelsRequest = $parcelsRequest;

        return $this;
    }

    /**
     * @return TNTParcelRequest[]
     */
    public function getParcelsRequest()
    {
        return $this->parcelsRequest;
    }

    /**
     * @param TNTPayBackInfo $paybackInfo
     *
     * @return CreateExpedition
     */
    public function setPaybackInfo($paybackInfo)
    {
        $this->paybackInfo = $paybackInfo;

        return $this;
    }

    /**
     * @return TNTPayBackInfo
     */
    public function getPaybackInfo()
    {
        return $this->paybackInfo;
    }

    /**
     * @param int $quantity
     *
     * @return CreateExpedition
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param \TNTFrance\WebService\Model\TNTReceiver $receiver
     *
     * @return CreateExpedition
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @return \TNTFrance\WebService\Model\TNTReceiver
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param int $saturdayDelivery
     *
     * @return CreateExpedition
     */
    public function setSaturdayDelivery($saturdayDelivery)
    {
        $this->saturdayDelivery = $saturdayDelivery;

        return $this;
    }

    /**
     * @return int
     */
    public function getSaturdayDelivery()
    {
        return $this->saturdayDelivery;
    }

    /**
     * @param \TNTFrance\WebService\Model\TNTSender $sender
     *
     * @return CreateExpedition
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return \TNTFrance\WebService\Model\TNTSender
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param string $serviceCode
     *
     * @return CreateExpedition
     */
    public function setServiceCode($serviceCode)
    {
        $this->serviceCode = $serviceCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getServiceCode()
    {
        return $this->serviceCode;
    }

    /**
     * @param mixed $shippingDate
     *
     * @return CreateExpedition
     */
    public function setShippingDate($shippingDate)
    {
        $this->shippingDate = $shippingDate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingDate()
    {
        return $this->shippingDate;
    }
}
