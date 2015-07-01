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

/**
 * Class TNTFranceExportEvent
 * @package TNTFrance\Event\Module
 * @author Julien Chanséaume <julien@thelia.net>
 */
class TNTFranceExportEvent extends ActionEvent
{
    //Allow to send all packages in the same package if able
    const ALL_IN_ONE_LBL = "all_in_one";
    const ALL_IN_ONE = 1;

    const ORDER_PRODUCTS_LBL = "order_products";

    /** @var array|null */
    protected $orders;

    protected $shippingDate;

    /** @var array */
    protected $data = [];

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param array|null $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getShippingDate()
    {
        return $this->shippingDate;
    }

    /**
     * @param mixed $shippingDate
     */
    public function setShippingDate($shippingDate)
    {
        $this->shippingDate = $shippingDate;
        return $this;
    }
}
