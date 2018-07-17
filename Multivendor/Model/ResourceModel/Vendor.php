<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 4/9/2018
 * Time: 1:56 PM
 */
namespace Magestore\Multivendor\Model\ResourceModel;

class Vendor extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{

    /**
     * class Vendor
     * @package Magestore\Multivendor\Model\ResourceModel
     */
    protected function _construct()
    {
        $this->_init('multivendor_vendor','vendor_id');

    }
}