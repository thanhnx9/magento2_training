<?php

namespace Magestore\Webpos\Model\Checkout;

class Shipping extends \Magento\Framework\DataObject implements \Magestore\Webpos\Api\Data\Checkout\ShippingDataInterface
{
    /**
     * @param $code
     * @return $this|mixed
     */
    public function setCode($code){
        return $this->setData(self::CODE, $code);
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->getData(self::CODE);
    }

    /**
     * @param $title
     * @return $this|mixed
     */
    public function setTitle($title){
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @return mixed
     */
    public function getTitle(){
        return $this->getData(self::TITLE);
    }

    /**
     * @param $price
     * @return $this|mixed
     */
    public function setPrice($price){
        return $this->setData(self::PRICE, $price);
    }

    /**
     * @return mixed
     */
    public function getPrice(){
        return $this->getData(self::PRICE);
    }

}
