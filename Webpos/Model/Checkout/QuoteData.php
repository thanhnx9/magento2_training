<?php

namespace Magestore\Webpos\Model\Checkout;

class QuoteData extends \Magento\Framework\Model\AbstractExtensibleModel implements \Magestore\Webpos\Api\Data\Checkout\QuoteDataInterface
{

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function setQuoteId($quoteId){
        return $this->setData(self::KEY_QUOTE_ID, $quoteId);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function getQuoteId(){
        return $this->getData(self::KEY_QUOTE_ID);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function setShipping($shipping){
        return $this->setData(self::KEY_SHIPPING, $shipping);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function getShipping(){
        return $this->getData(self::KEY_SHIPPING);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function setPayment($payment){
        return $this->setData(self::KEY_PAYMENT, $payment);
    }

    /**
     * @return array
     */
    public function getPayment(){
        return $this->getData(self::KEY_PAYMENT);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function setItems($items){
        return $this->setData(self::KEY_ITEMS, $items);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function getItems(){
        return $this->getData(self::KEY_ITEMS);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function setTotals($totals){
        return $this->setData(self::KEY_TOTALS, $totals);
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function getTotals(){
        return $this->getData(self::KEY_TOTALS);
    }
}
