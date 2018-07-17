<?php

namespace Magestore\Webpos\Api\Data\Sales;

interface OrderInterface extends \Magento\Sales\Api\Data\OrderInterface
{
    /*
     * Webpos staff id.
     */
    const WEBPOS_STAFF_ID = 'webpos_staff_id';
    /*
     * Webpos staff name.
     */
    const WEBPOS_STAFF_NAME = 'webpos_staff_name';
    /*
     * Webpos location id.
     */
    const LOCATION_ID = 'location_id';
    /*
     * Webpos order payments.
     */
    const WEBPOS_ORDER_PAYMENTS = "webpos_order_payments";
    /*
     * Items info buy request.
     */
    const ITEMS_INFO_BUY = "items_info_buy";
    /*
     * Items info buy request.
     */
    const WEBPOS_DELIVERY_DATE = "webpos_delivery_date";
    
    /*
     * Webpos base change amount.
     */
    const WEBPOS_BASE_CHANGE = "webpos_base_change";
    /*
     * Webpos change amount.
     */
    const WEBPOS_CHANGE = "webpos_change";

    /*
     * customer credit discount.
     */
    const CUSTOMERCREDIT_DISCOUNT = "customercredit_discount";
    /*
     * base customer credit discount.
     */
    const BASE_CUSTOMERCREDIT_DISCOUNT = "base_customercredit_discount";

    /*
     * rewardpoints earn.
     */
    const REWARDPOINTS_EARN = "rewardpoints_earn";

    /*
     * base rewardpoints spent.
     */
    const REWARDPOINTS_SPENT = "rewardpoints_spent";

    /*
     * rewardpoints discount.
     */
    const REWARDPOINTS_DISCOUNT = "rewardpoints_discount";

    /*
     * base rewardpoints base discount.
     */
    const REWARDPOINTS_BASE_DISCOUNT = "rewardpoints_base_discount";

    /*
     * giftvoucher discount.
     */
    const GIFT_VOUCHER_DISCOUNT = "gift_voucher_discount";

    /*
     * base giftvoucher discount.
     */
    const BASE_GIFT_VOUCHER_DISCOUNT = "base_gift_voucher_discount";

    /**
     * Sets the rewardpoints sp earn pointent.
     *
     * @param float $earnPoint
     * @return $this
     */
    public function setRewardpointsEarn($earnPoint);
    
    /**
     * Gets the rewardpoints earn point.
     *
     * @return float.
     */
    public function getRewardpointsEarn();

    /**
     * Sets the rewardpoints spent.
     *
     * @param float $spentPoint
     * @return $this
     */
    public function setRewardpointsSpent($spentPoint);

    /**
     * Gets the rewardpoints spent.
     *
     * @return float.
     */
    public function getRewardpointsSpent();

    /**
     * Sets the rewardpoints discount.
     *
     * @param float $discount
     * @return $this
     */
    public function setRewardpointsDiscount($discount);

    /**
     * Gets the webpos rewardpoints discount.
     *
     * @return float.
     */
    public function getRewardpointsDiscount();

    /**
     * Sets the webpos rewardpoints base discount.
     *
     * @param float $baseDiscount
     * @return $this
     */
    public function setRewardpointsBaseDiscount($baseDiscount);

    /**
     * Gets the webpos rewardpoints base discount.
     *
     * @return float.
     */
    public function getRewardpointsBaseDiscount();

    /**
     * Sets the webpos giftcard discount.
     *
     * @param float $discount
     * @return $this
     */
    public function setGiftVoucherDiscount($discount);

    /**
     * Gets the webpos  giftcard discount.
     *
     * @return float.
     */
    public function getGiftVoucherDiscount();

    /**
     * Sets the webpos base giftcard discount.
     *
     * @param float $baseDiscount
     * @return $this
     */
    public function setBaseGiftVoucherDiscount($baseDiscount);

    /**
     * Gets the webpos base giftcard discount.
     *
     * @return float.
     */
    public function getBaseGiftVoucherDiscount();

    /**
     * Sets the webpos base credit amount.
     *
     * @param float $baseDiscount
     * @return $this
     */
    public function setBaseCustomercreditDiscount($baseDiscount);

    /**
     * Gets the webpos base credit amount.
     *
     * @return float.
     */
    public function getBaseCustomercreditDiscount();
    
    /**
     * Sets the credit amount.
     *
     * @param float $discount
     * @return $this
     */
    public function setCustomercreditDiscount($discount);
    
    /**
     * Gets the credit amount.
     *
     * @return float.
     */
    public function getCustomercreditDiscount();

    /**
     * Sets the webpos base change amount.
     *
     * @param float $webposBaseChange
     * @return $this
     */
    public function setWebposBaseChange($webposBaseChange);

    /**
     * Gets the webpos base change amount.
     *
     * @return float.
     */
    public function getWebposBaseChange();

    /**
     * Sets the change amount.
     *
     * @param float $webposChange
     * @return $this
     */
    public function setWebposChange($webposChange);

    /**
     * Gets the change amount.
     *
     * @return float.
     */
    public function getWebposChange();
    
    /**
     * Sets the Webpos staff ID for the order.
     *
     * @param int $webposStaffId
     * @return $this
     */
    public function setWebposStaffId($webposStaffId);
    
    /**
     * Gets the Webpos staff ID for the order.
     *
     * @return int|null Webpos staff ID.
     */
    public function getWebposStaffId();

    /**
     * Sets the Webpos staff name for the order.
     *
     * @param string $webposStaffName
     * @return $this
     */
    public function setWebposStaffName($webposStaffName);

    /**
     * Gets the Webpos staff name for the order.
     *
     * @return string|null Webpos staff name.
     */
    public function getWebposStaffName();

    /**
     * Sets the Webpos location ID for the order.
     *
     * @param int $locationId
     * @return $this
     */
    public function setLocationId($locationId);

    /**
     * Gets the Webpos location ID for the order.
     *
     * @return int|null Webpos location ID.
     */
    public function getLocationId();

    /**
     * Sets the Webpos delivery date for the order.
     *
     * @param string $deliveryDate
     * @return $this
     */
    public function setWebposDeliveryDate($deliveryDate);

    /**
     * Gets the Webpos location ID for the order.
     *
     * @return string|null Webpos delivery date.
     */
    public function getWebposDeliveryDate();    
    /**
     * Sets items info buy request.
     *
     * @param \Magestore\Webpos\Api\Data\Checkout\ItemsInfoBuyInterface $itemsInfoBuy
     * @return $this
     */
    public function setItemsInfoBuy($itemsInfoBuy);

    /**
     * Gets items info buy request.
     *
     * @return \Magestore\Webpos\Api\Data\Checkout\ItemsInfoBuyInterface.
     */
    public function getItemsInfoBuy();

    /**
     * Gets items for the order.
     *
     * @return \Magestore\Webpos\Api\Data\Sales\OrderItemInterface[] Array of items.
     */
    public function getItems();
}
