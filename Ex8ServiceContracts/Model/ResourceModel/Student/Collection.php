<?php

namespace Magestore\Ex8ServiceContracts\Model\ResourceModel\Student;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{

    public function _construct()
    {
        parent::_construct();
        $this->_init('Magestore\Ex8ServiceContracts\Model\Student', 'Magestore\Ex8ServiceContracts\Model\ResourceModel\Student');
    }
}