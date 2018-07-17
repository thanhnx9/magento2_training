<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 4/9/2018
 * Time: 2:23 PM
 */
namespace Magestore\Multivendor\Model;

/**
 * Class VendorProduct
 * @package Magestore\MultiVendor\Model
 */
class VendorProduct extends \Magento\Framework\Model\AbstractModel
{

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ResourceModel\VendorProduct $resource
     * @param ResourceModel\VendorProduct\Collection $resourceCollection
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magestore\Multivendor\Model\ResourceModel\VendorProduct $resource,
        \Magestore\Multivendor\Model\ResourceModel\VendorProduct\Collection $resourceCollection
        )

    {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
    }

}