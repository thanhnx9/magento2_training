<?php

namespace Magestore\Webpos\Model\ResourceModel\Staff;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName ='staff_id';

    protected function _construct()
    {
        $this->_init('\Magestore\Webpos\Model\Staff','Magestore\Webpos\Model\ResourceModel\Staff');
    }
}