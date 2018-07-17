<?php

namespace Magestore\Webpos\Model\Sales;

use Magestore\Webpos\Api\Data\Sales\OrderInterface;
use Magestore\Webpos\Api\Data\Checkout\InfoBuyInterface;

class Order extends \Magento\Sales\Model\Order implements \Magento\Sales\Model\EntityInterface, OrderInterface
{
    /**
     *
     * @var \Magento\Framework\App\ObjectManager 
     */
    protected $_objectManager;
    
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Sales\Model\Order\Config $orderConfig,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, 
        \Magento\Sales\Model\ResourceModel\Order\Item\CollectionFactory $orderItemCollectionFactory, 
        \Magento\Catalog\Model\Product\Visibility $productVisibility, 
        \Magento\Sales\Api\InvoiceManagementInterface $invoiceManagement, 
        \Magento\Directory\Model\CurrencyFactory $currencyFactory, 
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Sales\Model\Order\Status\HistoryFactory $orderHistoryFactory,
        \Magento\Sales\Model\ResourceModel\Order\Address\CollectionFactory $addressCollectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\Payment\CollectionFactory $paymentCollectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\Status\History\CollectionFactory $historyCollectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\Invoice\CollectionFactory $invoiceCollectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\Shipment\CollectionFactory $shipmentCollectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory $memoCollectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\Shipment\Track\CollectionFactory $trackCollectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesOrderCollectionFactory, 
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency, 
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productListFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ){
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        parent::__construct(
            $context, 
            $registry, 
            $extensionFactory, 
            $customAttributeFactory, 
            $timezone, 
            $storeManager, 
            $orderConfig, 
            $productRepository, 
            $orderItemCollectionFactory,
            $productVisibility,
            $invoiceManagement,
            $currencyFactory, 
            $eavConfig, 
            $orderHistoryFactory,
            $addressCollectionFactory, 
            $paymentCollectionFactory, 
            $historyCollectionFactory, 
            $invoiceCollectionFactory, 
            $shipmentCollectionFactory, 
            $memoCollectionFactory, 
            $trackCollectionFactory, 
            $salesOrderCollectionFactory, 
            $priceCurrency, 
            $productListFactory, 
            $resource, 
            $resourceCollection, 
            $data
        );
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magento\Sales\Model\ResourceModel\Order');
    }

    /**
     * Sets the rewardpoints sp earn pointent.
     *
     * @param float $earnPoint
     * @return $this
     */
    public function setRewardpointsEarn($earnPoint){
        return $this->setData(self::REWARDPOINTS_EARN, $earnPoint);
    }

    /**
     * Gets the rewardpoints earn point.
     *
     * @return float.
     */
    public function getRewardpointsEarn(){
        return $this->getData(OrderInterface::REWARDPOINTS_EARN);
    }

    /**
     * Sets the rewardpoints spent.
     *
     * @param float $spentPoint
     * @return $this
     */
    public function setRewardpointsSpent($spentPoint){
        return $this->setData(self::REWARDPOINTS_SPENT, $spentPoint);
    }

    /**
     * Gets the rewardpoints spent.
     *
     * @return float.
     */
    public function getRewardpointsSpent(){
        return $this->getData(OrderInterface::REWARDPOINTS_SPENT);
    }

    /**
     * Sets the rewardpoints discount.
     *
     * @param float $discount
     * @return $this
     */
    public function setRewardpointsDiscount($discount){
        return $this->setData(self::REWARDPOINTS_DISCOUNT, $discount);
    }

    /**
     * Gets the webpos rewardpoints discount.
     *
     * @return float.
     */
    public function getRewardpointsDiscount(){
        return -$this->getData(OrderInterface::REWARDPOINTS_DISCOUNT);
    }

    /**
     * Sets the webpos rewardpoints base discount.
     *
     * @param float $baseDiscount
     * @return $this
     */
    public function setRewardpointsBaseDiscount($baseDiscount){
        return $this->setData(self::REWARDPOINTS_BASE_DISCOUNT, $baseDiscount);
    }

    /**
     * Gets the webpos rewardpoints base discount.
     *
     * @return float.
     */
    public function getRewardpointsBaseDiscount(){
        return -$this->getData(OrderInterface::REWARDPOINTS_BASE_DISCOUNT);
    }

    /**
     * Sets the webpos giftcard discount.
     *
     * @param float $discount
     * @return $this
     */
    public function setGiftVoucherDiscount($discount){
        return $this->setData(self::GIFT_VOUCHER_DISCOUNT, $discount);
    }

    /**
     * Gets the webpos  giftcard discount.
     *
     * @return float.
     */
    public function getGiftVoucherDiscount(){
        return -$this->getData(OrderInterface::GIFT_VOUCHER_DISCOUNT);
    }

    /**
     * Sets the webpos base giftcard discount.
     *
     * @param float $baseDiscount
     * @return $this
     */
    public function setBaseGiftVoucherDiscount($baseDiscount){
        return $this->setData(self::BASE_GIFT_VOUCHER_DISCOUNT, $baseDiscount);
    }

    /**
     * Gets the webpos base giftcard discount.
     *
     * @return float.
     */
    public function getBaseGiftVoucherDiscount(){
        return -$this->getData(OrderInterface::BASE_GIFT_VOUCHER_DISCOUNT);
    }

    /**
     * Sets the webpos base credit amount.
     *
     * @param float $baseDiscount
     * @return $this
     */
    public function setBaseCustomercreditDiscount($baseDiscount){
        return $this->setData(self::BASE_CUSTOMERCREDIT_DISCOUNT, $baseDiscount);
    }

    /**
     * Gets the webpos base credit amount.
     *
     * @return float.
     */
    public function getBaseCustomercreditDiscount(){
        return -$this->getData(OrderInterface::BASE_CUSTOMERCREDIT_DISCOUNT);
    }

    /**
     * Sets the credit amount.
     *
     * @param float $discount
     * @return $this
     */
    public function setCustomercreditDiscount($discount){
        return $this->setData(self::CUSTOMERCREDIT_DISCOUNT, $discount);
    }

    /**
     * Gets the credit amount.
     *
     * @return float.
     */
    public function getCustomercreditDiscount(){
        return -$this->getData(OrderInterface::CUSTOMERCREDIT_DISCOUNT);
    }

    /**
     * Set Webpos base change
     *
     * @param float $webposBaseChange
     * @return $this
     */
    public function setWebposBaseChange($webposBaseChange)
    {
        return $this->setData(self::WEBPOS_BASE_CHANGE, $webposBaseChange);
    }

    /**
     * Returns Webpos base change
     *
     * @return float
     */
    public function getWebposBaseChange()
    {
        return $this->getData(OrderInterface::WEBPOS_BASE_CHANGE);
    }
    
    /**
     * Set Webpos change
     *
     * @param float $webposChange
     * @return $this
     */
    public function setWebposChange($webposChange)
    {
        return $this->setData(self::WEBPOS_CHANGE, $webposChange);
    }

    /**
     * Returns Webpos change
     *
     * @return float
     */
    public function getWebposChange()
    {
        return $this->getData(OrderInterface::WEBPOS_CHANGE);
    }
    
    /**
     * Set Webpos staff ID for Order
     *
     * @param int $webposStaffId
     * @return $this
     */
    public function setWebposStaffId($webposStaffId)
    {
        return $this->setData(self::WEBPOS_STAFF_ID, $webposStaffId);
    }

    /**
     * Returns Webpos staff ID
     *
     * @return int
     */
    public function getWebposStaffId()
    {
        return $this->getData(OrderInterface::WEBPOS_STAFF_ID);
    }

    /**
     * Sets the Webpos staff name for the order.
     *
     * @param string $webposStaffName
     * @return $this
     */
    public function setWebposStaffName($webposStaffName){
        return $this->setData(self::WEBPOS_STAFF_NAME, $webposStaffName);
    }

    /**
     * Gets the Webpos staff name for the order.
     *
     * @return string|null Webpos staff name.
     */
    public function getWebposStaffName(){
        if(!$this->getData(OrderInterface::WEBPOS_STAFF_NAME)){
            if($staffId = $this->getData(OrderInterface::WEBPOS_STAFF_ID)){
                return $this->_objectManager->create('Magestore\Webpos\Model\Staff\Staff')
                    ->load($staffId)->getDisplayName();
            }
        }
        return $this->getData(OrderInterface::WEBPOS_STAFF_NAME);
    }

    /**
     * Sets the Webpos location ID for the order.
     *
     * @param int $locationId
     * @return $this
     */
    public function setLocationId($locationId){
        return $this->setData(self::LOCATION_ID, $locationId);
    }

    /**
     * Gets the Webpos location ID for the order.
     *
     * @return int|null Webpos location ID.
     */
    public function getLocationId(){
        return $this->getData(OrderInterface::LOCATION_ID);
    }

    /**
     * Sets the Webpos delivery date for the order.
     *
     * @param string $deliveryDate
     * @return $this
     */
    public function setWebposDeliveryDate($deliveryDate){
        return $this->setData(OrderInterface::WEBPOS_DELIVERY_DATE, $deliveryDate);
    }

    /**
     * Gets the Webpos location ID for the order.
     *
     * @return string|null Webpos delivery date.
     */
    public function getWebposDeliveryDate(){
        return $this->getData(OrderInterface::WEBPOS_DELIVERY_DATE);
    }

    
    /**
     * Sets re-order params.
     *
     * @param \Magestore\Webpos\Api\Data\Checkout\ItemsInfoBuyInterface $itemsInfoBuy
     * @return $this
     */
    public function setItemsInfoBuy($itemsInfoBuy){
        return $this->setData(OrderInterface::ITEMS_INFO_BUY, $itemsInfoBuy);
    }

    /**
     * Gets re-order params.
     *
     * @return \Magestore\Webpos\Api\Data\Checkout\ItemsInfoBuyInterface.
     */
    public function getItemsInfoBuy(){
        return;
        $itemsBuyRequest = $this->_objectManager->create('Magestore\Webpos\Api\Data\Checkout\ItemsInfoBuyInterface');
        $items = $this->getAllVisibleItems();
        if(count($items) > 0){
            $itemsInfoBuy = [];
            foreach ($items as $item) {
                $labels = [];
                $itemInfo = $this->_objectManager->create('Magestore\Webpos\Api\Data\Checkout\InfoBuyInterface');
                if(!is_null($item->getProduct()) && $item->getProduct()->getTypeId() != 'customsale'){
                    $itemInfo->setId($item->getProduct()->getId());
                }
                $baseOriginalPrice = ($item->getBaseOriginalPrice())?$item->getBaseOriginalPrice():"";
                $originalPrice = ($item->getOriginalPrice())?$item->getOriginalPrice():"";
                $itemInfo->setBaseOriginalPrice($baseOriginalPrice);
                $itemInfo->setOriginalPrice($originalPrice);
                $itemInfo->setUnitPrice($item->getPrice());
                $itemInfo->setBaseUnitPrice($item->getBasePrice());
                
                $labels = array_merge($labels,$this->getBundleOptionsLabel($item->getProductOptionByCode("bundle_options")));
                $labels = array_merge($labels,$this->getOptionsLabel($item->getProductOptionByCode("attributes_info")));
                $labels = array_merge($labels,$this->getOptionsLabel($item->getProductOptionByCode("options")));
                $info = $item->getBuyRequest()->toArray();
                if(count($info) > 0){
                    foreach ($info as $key => $value) {
                        if(is_array($value)){
                            $options = [];
                            foreach ($value as $code => $data) {
                                $options[] = [
                                    "id" => $code,
                                    "value" => $data
                                ];
                            }
                            $value = $options;
                        }
                        $itemInfo->setData($key,$value);
                    }
                }
                if(!is_null($item->getProduct()) && $item->getProduct()->getTypeId() == 'customsale'){
                    $itemInfo->setId('custom_item');
                    $itemInfo->setCustomSalesInfo(
                        [
                            [
                                'product_id' => 'customsale',
                                'product_name' => $item->getName(),
                                'unit_price' => $item->getPrice(),
                                'tax_class_id' => $item->getCustomTaxClassId(),
                                'is_virtual' => $item->getIsVirtual(),
                                'qty' => $item->getQtyOrdered()
                            ]
                       ]
                    );
                }
                $childs = $item->getChildrenItems();
                if(count($childs) > 0){
                    $child = $childs[0];
                    $itemInfo->setChildId($child->getProductId());
                }
                $itemInfo->setData(InfoBuyInterface::KEY_OPTIONS_LABEL,implode(', ',$labels));
                $itemsInfoBuy[$item->getId()] = $itemInfo;
            }
            $itemsBuyRequest->setItems($itemsInfoBuy);
        }
        return $itemsBuyRequest;
    }
    /**
     * 
     * @param array $options
     * @return array
     */
    protected function getBundleOptionsLabel($options){
        $labels = [];
        if($options){
            foreach ($options as $option) {
                if(is_array($option['value'])){
                    foreach ($option['value'] as $data) {
                        $labels[] = $data['qty'] ."x ". $data['title'];
                    }
                }
            }
        }
        return $labels;
    }
    
    /**
     * 
     * @param array $options
     * @return array
     */
    protected function getOptionsLabel($options){
        $labels = [];
        if($options){
            foreach ($options as $option) {
                $labels[] = $option['value'];
            }
        }
        return $labels;
    }

}
