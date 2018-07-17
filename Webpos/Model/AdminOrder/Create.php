<?php

namespace Magestore\Webpos\Model\AdminOrder;

use Magestore\Webpos\Api\Data\Checkout\ItemBuyRequestInterface;

class Create extends \Magento\Sales\Model\AdminOrder\Create
{
    /**
     * @var int
     */
    protected $_quote_id = 0;

    /**
     * Create a new quote
     * @return \Magento\Quote\Api\Data\CartInterface
     */
    public function createQuote(){
        $session = $this->getSession();
        $session->clearStorage();
        $quote = $this->quoteFactory->create();
        $quote->setIsActive(false);
        $quote->setIsMultiShipping(false);
        $quote->setStoreId($session->getStore()->getId());
        $this->quoteRepository->save($quote);
        return $quote;
    }

    /**
     * Start an API action
     * @param string $quoteId
     * @return $this
     */
    public function start($quoteId){
        $session = $this->getSession();
        if($quoteId){
            $this->_quote_id = $quoteId;
            $quote = $this->quoteRepository->get($quoteId, [$session->getStore()->getId()]);
        }else {
            $quote = $this->createQuote();
        }
        $this->setQuote($quote);
        $this->saveQuote();
        return $this;
    }

    /**
     * Finish action - save quote
     * @param bool $saveQuote
     * @return $this
     */
    public function finish($saveQuote = true){
        if($saveQuote){
            $this->saveQuote();
        }
        return $this;
    }

    /**
     * Save quote and collect rates
     * @return $this
     */
    public function saveQuote()
    {
        $this->quoteRepository->save($this->getQuote());
        $this->collectShippingRates();
        $this->collectRates();
        return $this;
    }

    /**
     * Get current quote
     * @return $this
     */
    public function getQuote()
    {
        $quoteId = $this->_quote_id;
        if(!$quoteId){
            $quote = $this->createQuote();
        }else{
            $session = $this->getSession();
            $quote = $this->quoteRepository->get($quoteId, [$session->getStore()->getId()]);
        }
        $this->setQuote($quote);
      //  \Zend_Debug::dump($quote);
        return $quote;
    }

    /**
     * Set quote
     * @param \Magento\Quote\Model\Quote $quote
     */
    public function setQuote(\Magento\Quote\Model\Quote $quote){
        $this->_quote_id = $quote->getId();
    }

    /**
     * Add multiple products to current quote
     *
     * @param $products
     * @return $this
     */
    public function addProducts(array $products)
    {
        foreach ($products as $productId => $infoBuy) {
            $config['qty'] = isset($infoBuy[ItemBuyRequestInterface::KEY_QTY]) ? (double)$infoBuy[ItemBuyRequestInterface::KEY_QTY] : 1;
            try {
                $this->addProduct($productId, $infoBuy);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
            } catch (\Exception $e) {
                throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
            }
        }
        return $this;
    }

    /**
     * Check the params of API to add new or update items
     * @param \Magestore\Webpos\Api\Data\Checkout\ItemBuyRequestInterface[] $items
     * @return $this
     */
    public function processItems($items){
        if(!empty($items)){
            $newItems = [];
            $quoteItems = [];
            $quote = $this->getQuote();
            foreach ($items as $item) {
                $quoteItem = $quote->getItemById($item->getItemId());
                if($quoteItem){
                    $quoteItems[$item->getItemId()] = $item->getData();
                }else{
                    $newItems[$item->getId()] = $item->getData();
                }
            }
            if(!empty($newItems)){
                $this->addProducts($newItems);
            }
            if(!empty($quoteItems)){
                $this->updateQuoteItems($quoteItems);
            }
        }
        return $this;
    }

    /**
     * Remove current quote
     */
    public function removeQuote(){
        $this->quoteRepository->delete($this->getQuote());
        $quote = $this->quoteFactory->create();
        $this->setQuote($quote);
        return $this;
    }

    /**
     * Add data to quote
     * @param $quoteData
     * @return $this
     */
    public function setQuoteData($quoteData){
        if(!empty($quoteData)){
            foreach ($quoteData as $data){
                $this->getQuote()->setData($data['key'], $data['value']);
            }
        }
        return $this;
    }

    /**
     * Assign customer to quote
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @return $this
     */
    public function assignCustomer($customer){
        if($customer){
            $this->getQuote()->setCustomerIsGuest(false);
            $this->getQuote()->assignCustomer($customer);
            $this->getSession()->setCustomerId($customer->getId());
        }else{
            $this->getQuote()->setCustomerIsGuest(true);
        }
        return $this;
    }
}
