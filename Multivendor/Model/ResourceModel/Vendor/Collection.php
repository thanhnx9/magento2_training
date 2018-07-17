<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 4/9/2018
 * Time: 2:12 PM
 */
namespace Magestore\Multivendor\Model\ResourceModel\Vendor;
/**
 * Class Collection
 * @package Magestore\Multivendor\Model\ResourceModel\Vendor
 *
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {
    protected  $_idFieldName = 'vendor_id';
    public function _construct()
    {
        parent::_construct();
        $this ->_init('Magestore\Multivendor\Model\Vendor',
            'Magestore\Multivendor\Model\ResourceModel\Vendor');
    }
}