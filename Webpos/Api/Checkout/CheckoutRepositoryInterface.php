<?php

namespace Magestore\Webpos\Api\Checkout;

/**
 * Interface CheckoutRepositoryInterface
 * @package Magestore\Webpos\Api\Checkout
 */
interface CheckoutRepositoryInterface
{
    /**
     * @param string|null $quoteId
     * @param \Magestore\Webpos\Api\Data\Checkout\ItemBuyRequestInterface[] $items
     * @param string $customerId
     * @param string[] $section
     * @return \Magestore\Webpos\Api\Data\Checkout\ResponseInterface
     */
    public function saveCart($quoteId, $items, $customerId, $section);

    /**
     * @param string $quoteId
     * @return \Magestore\Webpos\Api\Data\Checkout\ResponseInterface
     */
    public function removeCart($quoteId);

    /**
     * @param string $quoteId
     * @param string $itemId
     * @return \Magestore\Webpos\Api\Data\Checkout\ResponseInterface
     */
    public function removeItem($quoteId, $itemId);

    /**
     * @param string $quoteId
     * @param string $shippingMethod
     * @return \Magestore\Webpos\Api\Data\Checkout\ResponseInterface
     */
    public function saveShippingMethod($quoteId, $shippingMethod);

    /**
     * @param string $quoteId
     * @param string $paymentMethod
     * @return \Magestore\Webpos\Api\Data\Checkout\ResponseInterface
     */
    public function savePaymentMethod($quoteId, $paymentMethod);

    /**
     * @param string $quoteId
     * @param string $quoteData
     * @return \Magestore\Webpos\Api\Data\Checkout\ResponseInterface
     */
    public function saveQuoteData($quoteId, $quoteData);

    /**
     * @param string $quoteId
     * @param string $customerId
     * @return \Magestore\Webpos\Api\Data\Checkout\ResponseInterface
     */
    public function selectCustomer($quoteId, $customerId);

    /**
     * @param string $quoteId
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    public function placeOrder($quoteId);

}
