<?php

namespace Magestore\Webpos\Api\Data\Checkout;

/**
 * Interface ResponseInterface
 * @package Magestore\Webpos\Api\Data\Checkout
 */
interface ResponseInterface
{
    const STATUS_SUCCESS = 1;
    const STATUS_ERROR = 0;

    /**#@+
     * Config object data keys
     */

    const KEY_STATUS = 'status';
    const KEY_QUOTE_DATA = 'quote_data';
    const KEY_MESSAGES = 'messages';

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param \Magestore\Webpos\Api\Data\Checkout\QuoteDataInterface $quoteData
     * @return $this
     */
    public function setQuoteData($quoteData);

    /**
     * @return \Magestore\Webpos\Api\Data\Checkout\QuoteDataInterface
     */
    public function getQuoteData();

    /**
     * @param string[] $messages
     * @return $this
     */
    public function setMessages($messages);

    /**
     * @return string[]
     */
    public function getMessages();

}
