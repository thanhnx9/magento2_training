<?php

namespace Magestore\Webpos\Model\Checkout;

class Response extends \Magento\Framework\Model\AbstractExtensibleModel implements \Magestore\Webpos\Api\Data\Checkout\ResponseInterface
{
    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status){
        return $this->setData(self::KEY_STATUS, $status);
    }

    /**
     * @return string
     */
    public function getStatus(){
        return $this->getData(self::KEY_STATUS);
    }

    /**
     * @param \Magestore\Webpos\Api\Data\Checkout\QuoteDataInterface $quoteData
     * @return $this
     */
    public function setQuoteData($quoteData){
        return $this->setData(self::KEY_QUOTE_DATA, $quoteData);
    }

    /**
     * @return \Magestore\Webpos\Api\Data\Checkout\QuoteDataInterface
     */
    public function getQuoteData(){
        return $this->getData(self::KEY_QUOTE_DATA);
    }

    /**
     * @param string[] $messages
     * @return $this
     */
    public function setMessages($messages){
        return $this->setData(self::KEY_MESSAGES, $messages);
    }

    /**
     * @return string[]
     */
    public function getMessages(){
        return $this->getData(self::KEY_MESSAGES);
    }
}
