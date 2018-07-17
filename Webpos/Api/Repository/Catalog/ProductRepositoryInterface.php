<?php

namespace Magestore\Webpos\Api\Repository\Catalog;

/**
 * @api
 */
interface ProductRepositoryInterface extends \Magento\Catalog\Api\ProductRepositoryInterface
{
    const TYPE_ID = 'type_id';
    const NAME = 'name';
    const PRICE = 'price';
    const SPECIAL_PRICE = 'special_price';
    const SPECIAL_FROM_DATE = 'special_from_date';
    const SPECIAL_TO_DATE = 'special_to_date';
    const SKU = 'sku';
    const SHORT_DESCRIPTION = 'short_description';
    const DESCRIPTION = 'description';
    const IMAGE = 'image';
    const FINAL_PRICE = 'final_price';

    /**
     * Get info about product by product SKU
     *
     * @param string $sku
     * @param bool $editMode
     * @param int|null $storeId
     * @param bool $forceReload
     * @return \Magestore\Webpos\Api\Data\Catalog\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($sku, $editMode = false, $storeId = null, $forceReload = false);

    /**
     * Get product list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magestore\Webpos\Api\Data\Catalog\ProductSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

}
