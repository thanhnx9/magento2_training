<?php
namespace Magestore\Webpos\Model\Repository\Checkout;
use Magestore\Webpos\Api\Data\Checkout\QuoteDataInterface as QuoteDataInterface;
use Magestore\Webpos\Api\Data\Checkout\ResponseInterface as ResponseInterface;
use Magento\Framework\Cache\Frontend\Adapter\Zend;

class CheckoutRepository implements \Magestore\Webpos\Api\Checkout\CheckoutRepositoryInterface
{
    /**
     * @var ResponseInterface
     */
    protected $_responseModelData;

    /**
     * @var QuoteDataInterface
     */
    protected $_quoteModelData;

    /**
     * @var \Magestore\Webpos\Model\AdminOrder\Create
     */
    protected $_orderCreateModel;

    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $_customerRepository;

    /**
     * @var \Magento\Payment\Model\MethodList
     */
    protected $_paymentMethodList;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $_orderRepository;
    /**
     * @var \Magestore\Webpos\Api\Data\Checkout\ShippingDataInterfaceFactory
     */
    protected $_shippingData;
    /**
     * @var \Magestore\Webpos\Api\Data\Checkout\PaymentDataInterface
     */
    protected $_paymentData;
    /**
     * CheckoutRepository constructor.
     * @param ResponseInterface $responseModelData
     * @param QuoteDataInterface $quoteModelData
     * @param \Magestore\Webpos\Model\AdminOrder\Create $orderCreateModel
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Payment\Model\MethodList $paymentMethodList
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magestore\Webpos\Api\Data\Checkout\ShippingDataInterfaceFactory $shippingData
     * @param \Magestore\Webpos\Api\Data\Checkout\PaymentDataInterfaceFactory $paymentData
     */
    //instance
    public function __construct(
        \Magestore\Webpos\Api\Data\Checkout\ResponseInterface $responseModelData,
        \Magestore\Webpos\Api\Data\Checkout\QuoteDataInterface $quoteModelData,
        \Magestore\Webpos\Model\AdminOrder\Create $orderCreateModel,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Payment\Model\MethodList $paymentMethodList,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magestore\Webpos\Api\Data\Checkout\ShippingDataInterfaceFactory $shippingData,
        \Magestore\Webpos\Api\Data\Checkout\PaymentDataInterfaceFactory $paymentData
    ) {
        $this->_responseModelData = $responseModelData;
        $this->_quoteModelData = $quoteModelData;
        $this->_orderCreateModel = $orderCreateModel;
        $this->_customerRepository = $customerRepository;
        $this->_paymentMethodList = $paymentMethodList;
        $this->_orderRepository = $orderRepository;
        $this->_shippingData=$shippingData;
        $this->_paymentData=$paymentData;
    }

    /**
     * Save cart when click checkout button
     * @param int|null $quoteId
     * @param \Magestore\Webpos\Api\Data\Checkout\ItemBuyRequestInterface[] $items
     * @param string $customerId
     * @param string[] $section
     * @return \Magestore\Webpos\Api\Data\Checkout\QuoteDataInterface
     */
    public function saveCart($quoteId, $items, $customerId, $section){
        $customer = $this->_customerRepository->getById($customerId);

        $this->_orderCreateModel->start($quoteId);
        $this->_orderCreateModel->processItems($items,$quoteId);

        $this->_orderCreateModel->assignCustomer($customer);
        $this->_orderCreateModel->finish();

        return $this->_getResponse(ResponseInterface::STATUS_SUCCESS, [], $section);

    }

    /**
     * Remove cart when click clear cart button
     * @param string $quoteId
     * @return \Magestore\Webpos\Api\Data\Checkout\QuoteDataInterface
     */
    public function removeCart($quoteId){
        $this->_orderCreateModel->start($quoteId);
        $this->_orderCreateModel->removeQuote();
        $this->_orderCreateModel->finish(false);
        return $this->_getResponse(ResponseInterface::STATUS_SUCCESS, [], [], true);
    }

    /**
     * Remove quote item
     * @param string $quoteId
     * @param string $itemId
     * @return $this
     */
    public function removeItem($quoteId, $itemId){
        $this->_orderCreateModel->start($quoteId);
        $this->_orderCreateModel->removeQuoteItem($itemId);
        $this->_orderCreateModel->finish();
        return $this->_getResponse();
    }

    /**
     * Save shipping method
     * @param string $quoteId
     * @param string $shippingMethod
     * @return $this
     */
    public function saveShippingMethod($quoteId, $shippingMethod){
        $this->_orderCreateModel->start($quoteId);
        $this->_orderCreateModel->setShippingMethod($shippingMethod);
        $this->_orderCreateModel->finish();
        return $this->_getResponse();
    }

    /**
     * Save payment method
     * @param string $quoteId
     * @param string $paymentMethod
     * @return $this
     */
    public function savePaymentMethod($quoteId, $paymentMethod){
        $this->_orderCreateModel->start($quoteId);
        $this->_orderCreateModel->setPaymentMethod($paymentMethod);
        $this->_orderCreateModel->finish();
        return $this->_getResponse();
    }

    /**
     * Save data to quote
     * @param string $quoteId
     * @param string $quoteData
     * @return $this
     */
    public function saveQuoteData($quoteId, $quoteData){
        $this->_orderCreateModel->start($quoteId);
        $this->_orderCreateModel->finish();
        return $this->_getResponse();
    }

    /**
     * Assign customer to quote
     * @param string $quoteId
     * @param string $customerId
     * @return $this
     */
    public function selectCustomer($quoteId, $customerId){
        $customer = $this->_customerRepository->getById($customerId);
        $this->_orderCreateModel->start($quoteId);
        $this->_orderCreateModel->assignCustomer($customer);
        $this->_orderCreateModel->finish();
        return $this->_getResponse();
    }

    /**
     * Place order
     * @param string $quoteId
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    public function placeOrder($quoteId){
        $this->_orderCreateModel->start($quoteId);
        $order = $this->_orderCreateModel->createOrder();
        if(!$order){
            throw new \Magento\Framework\Exception\LocalizedException(__('Có gì đó sai sai'));
        }
        return $this->_orderRepository->get($order->getId());
    }

    /**
     * Get response for API request
     * @param int $status
     * @param array $messages
     * @param array $sections
     * @param bool $emptyQuote
     * @return mixed
     */
    protected function _getResponse($status = ResponseInterface::STATUS_SUCCESS, $messages = [], $sections = [], $emptyQuote = false){
        $data = array(
            ResponseInterface::KEY_STATUS => $status,
            ResponseInterface::KEY_MESSAGES => $messages,
            ResponseInterface::KEY_QUOTE_DATA => $this->_getQuoteData($sections, $emptyQuote)
        );
        return $this->_responseModelData->setData($data);
    }

    /**
     * Get quote data to send to client
     * @param $sections
     * @param $model
     * @return array
     */
    protected function _getQuoteData($sections = array(), $empty = false){
        $data = array(
            QuoteDataInterface::KEY_QUOTE_ID  => '',
            QuoteDataInterface::KEY_ITEMS  => '',
            QuoteDataInterface::KEY_TOTALS  => '',
            QuoteDataInterface::KEY_SHIPPING  => '',
            QuoteDataInterface::KEY_PAYMENT  => ''
        );
        if($empty == false){
            if(empty($sections) || $sections == QuoteDataInterface::KEY_QUOTE_ID || (is_array($sections) && in_array(QuoteDataInterface::KEY_QUOTE_ID, $sections))){
                $data[QuoteDataInterface::KEY_QUOTE_ID] = $this->_orderCreateModel->getQuote()->getId();
            }
            if(empty($sections) || $sections == QuoteDataInterface::KEY_ITEMS || (is_array($sections) && in_array(QuoteDataInterface::KEY_ITEMS, $sections))){
                $data[QuoteDataInterface::KEY_ITEMS] = $this->_getQuoteItems();
            }
            if(empty($sections) || $sections == QuoteDataInterface::KEY_TOTALS || (is_array($sections) && in_array(QuoteDataInterface::KEY_TOTALS, $sections))){
                $data[QuoteDataInterface::KEY_TOTALS] = $this->_getTotals();
            }
            if(empty($sections) || $sections == QuoteDataInterface::KEY_SHIPPING || (is_array($sections) && in_array(QuoteDataInterface::KEY_SHIPPING, $sections))){
                $data[QuoteDataInterface::KEY_SHIPPING] = $this->_getShipping();
            }
            if(empty($sections) || $sections == QuoteDataInterface::KEY_PAYMENT || (is_array($sections) && in_array(QuoteDataInterface::KEY_PAYMENT, $sections))){
                $data[QuoteDataInterface::KEY_PAYMENT] = $this->_getPayment();
            }
        }
        return $this->_quoteModelData->setData($data);
    }

    /**
     * Get quote items data
     * @return array
     */
    protected function _getQuoteItems(){
        $result = array();
        $items = $this->_orderCreateModel->getQuote()->getAllVisibleItems();

        if(count($items)){
            foreach ($items as $item){
                $result[$item->getId()] = $item->getData();
                $result[$item->getId()]['offline_item_id'] =  $item->getBuyRequest()->getData('item_id');
            }
        }

        return $result;
    }

    /**
     * Get all quote totals data
     * @return array
     */
    protected function _getTotals(){
        try {
            $totals = $this->_orderCreateModel->getQuote()->getTotals();
        }catch (\Exception $e){
            print_r($e);
        }
        $totalsResult = array();
        foreach ($totals as $total) {
            $totalsResult[] = $total->getData();
        }
        return $totalsResult;
    }

    /**
     * Get shipping list
     * @return array
     */
    protected function _getShipping(){
        $shippingList = array();
        $quote = $this->_orderCreateModel->getQuote();
        $shippingAddress = $quote->getShippingAddress();
        if (!$shippingAddress->getCountryId()) {
            throw new  \Magento\Framework\Exception\LocalizedException(__('Shipping address not set.'));
        }
        $shippingAddress->collectShippingRates()->save();
        $shippingRates = $shippingAddress->getGroupedAllShippingRates();
        foreach ($shippingRates as $carrierRates) {
            foreach ($carrierRates as $rate) {
                $methodCode = $rate->getCode();
                $methodTitle = $rate->getCarrierTitle().' - '.$rate->getMethodTitle();
                $methodPrice = ($rate->getPrice() != null) ? $rate->getPrice() : '0';
                $shipping=$this->_shippingData->create()->setCode($methodCode)->setTitle($methodTitle)->setPrice($methodPrice);
                $shippingList[] = $shipping;
            }
        }
        return $shippingList;
    }

    /**
     * Get payment list
     * @return array
     */
    protected function _getPayment(){
        $paymentList = array();
        $quote = $this->_orderCreateModel->getQuote();
        $methods =  $this->_paymentMethodList->getAvailableMethods($quote);
        foreach ($methods as $method) {
//            $paymentList[] = array(
//                'code' => $method->getCode(),
//                'title' => $method->getTitle(),
//            );
            $payment=$this->_paymentData->create()->setCode($method->getCode())->setTitle($method->getTitle());
            $paymentList[]=$payment;
        };
        return $paymentList;
    }
}
