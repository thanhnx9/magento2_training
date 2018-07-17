<?php

namespace Magestore\Webpos\Api\Sales;

interface InvoiceRepositoryInterface extends \Magento\Sales\Api\InvoiceRepositoryInterface
{
    /**
     * Performs persist operations for a specified invoice.
     *
     * @param \Magento\Sales\Api\Data\InvoiceInterface $entity The invoice.
     * @param string|null $invoiceAmount
     * @return \Magestore\Webpos\Api\Data\Sales\OrderInterface Order interface.
     */
    public function saveInvoice(
        \Magento\Sales\Api\Data\InvoiceInterface $entity,
        $invoiceAmount = null
    );
}
