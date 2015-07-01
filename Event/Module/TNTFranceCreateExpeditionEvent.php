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


namespace TNTFrance\Event\Module;

use Thelia\Core\Event\ActionEvent;
use Thelia\Model\Order;
use TNTFrance\WebService\Model\TNTExpedition;

/**
 * Class TNTFranceCreateExpeditionEvent
 * @package TNTFrance\Event\Module
 * @author Julien Chanséaume <julien@thelia.net>
 */
class TNTFranceCreateExpeditionEvent extends ActionEvent
{
    const PACKAGE = "package";

    /** @var Order */
    protected $order;

    /** @var string */
    protected $shippingDate;

    /** @var TNTExpedition  */
    protected $expedition;

    /** @var  bool */
    protected $allInOne;

    public function __construct(Order $order = null)
    {
        $this->order = $order;
        $this->allInOne = true;
    }

    /**
     * @return mixed
     */
    public function getExpedition()
    {
        return $this->expedition;
    }

    /**
     * @param mixed $expedition
     */
    public function setExpedition($expedition)
    {
        $this->expedition = $expedition;
        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return string
     */
    public function getShippingDate()
    {
        return $this->shippingDate;
    }

    /**
     * @param string $shippingDate
     */
    public function setShippingDate($shippingDate)
    {
        $this->shippingDate = $shippingDate;
        return $this;
    }

    /**
     * @param boolean $allInOne
     *
     * @return TNTFranceCreateExpeditionEvent
     */
    public function setAllInOne($allInOne)
    {
        $this->allInOne = $allInOne;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getAllInOne()
    {
        return $this->allInOne;
    }
}
