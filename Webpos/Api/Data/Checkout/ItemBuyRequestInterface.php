<?php

namespace Magestore\Webpos\Api\Data\Checkout;

/**
 * Interface ItemBuyRequestInterface
 * @package Magestore\Webpos\Api\Data\Checkout
 */
interface ItemBuyRequestInterface
{
    /**#@+
     * Config object data keys
     */
    const KEY_ITEM_ID = 'item_id';
    const KEY_ID = 'id';
    const KEY_QTY = 'qty';
    const KEY_CUSTOM_PRICE = 'custom_price';

    /**
     * @param string $itemId
     * @return $this
     */
    public function setItemId($itemId);

    /**
     * @return string
     */
    public function getItemId();

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getId();

    /**
     * @param string $qty
     * @return $this
     */
    public function setQty($qty);

    /**
     * @return string
     */
    public function getQty();

    /**
     * @param string $customPrice
     * @return $this
     */
    public function setCustomPrice($customPrice);

    /**
     * @return string
     */
    public function getCustomPrice();

}
