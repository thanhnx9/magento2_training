<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 4/9/2018
 * Time: 2:36 PM
 */
namespace Magestore\Multivendor\Model\ResourceModel\VendorProduct;
/**
 * Class Collection
 * @package Magestore\Multivendor\Model\ResourceModel\Vendor
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
    public function _construct()
    {
        parent::_construct();
        $this ->_init('Magestore\Multivendor\Model\VendorProduct',
            'Magestore\Multivendor\Model\ResourceModel\VendorProduct'
            );
    }
}