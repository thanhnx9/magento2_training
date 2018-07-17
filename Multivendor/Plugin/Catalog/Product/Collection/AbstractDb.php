<?php

namespace Magestore\Multivendor\Plugin\Catalog\Product\Collection;

class AbstractDb extends \Magento\Framework\Data\Collection\AbstractDb
{
    public function beforeGetSize(\Magento\Framework\Data\Collection\AbstractDb $object){
        $object->_totalRecords = null;
    }
    public function getResource() {
        return parent::getResource();
    }
}
