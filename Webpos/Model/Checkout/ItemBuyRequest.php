<?php

namespace Magestore\Webpos\Model\Checkout;

class ItemBuyRequest extends \Magento\Framework\Model\AbstractExtensibleModel implements \Magestore\Webpos\Api\Data\Checkout\ItemBuyRequestInterface
{
    /**
     * @param string $itemId
     * @return $this
     */
    public function setItemId($itemId){
        return $this->setData(self::KEY_ITEM_ID, $itemId);
    }

    /**
     * @return string
     */
    public function getItemId(){
        return $this->getData(self::KEY_ITEM_ID);
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id){
        return $this->setData(self::KEY_ID, $id);
    }

    /**
     * @return string
     */
    public function getId(){
        return $this->getData(self::KEY_ID);
    }

    /**
     * @param string $qty
     * @return $this
     */
    public function setQty($qty){
        return $this->setData(self::KEY_QTY, $qty);
    }

    /**
     * @return string
     */
    public function getQty(){
        return $this->getData(self::KEY_QTY);
    }

    /**
     * @param string $customPrice
     * @return $this
     */
    public function setCustomPrice($customPrice){
        return $this->setData(self::KEY_CUSTOM_PRICE, $customPrice);
    }

    /**
     * @return string
     */
    public function getCustomPrice(){
        return $this->getData(self::KEY_CUSTOM_PRICE);
    }
}
