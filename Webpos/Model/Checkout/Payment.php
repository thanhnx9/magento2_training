<?php

namespace Magestore\Webpos\Model\Checkout;

class Payment extends \Magento\Framework\DataObject implements \Magestore\Webpos\Api\Data\Checkout\PaymentDataInterface
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


}
