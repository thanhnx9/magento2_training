<?php
namespace Magestore\Ex8ServiceContracts\Model\ResourceModel;

class Student extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
    protected function _construct()
    {
        $this->_init('student', 'id');
    }
}