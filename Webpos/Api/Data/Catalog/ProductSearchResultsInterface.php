<?php
namespace Magestore\Webpos\Api\Data\Catalog;

/**
 * @api
 */
interface ProductSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface{

    /**
     * Get attributes list.
     *
     * @return \Magestore\Webpos\Api\Data\Catalog\ProductInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param \Magestore\Webpos\Api\Data\Catalog\ProductInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}