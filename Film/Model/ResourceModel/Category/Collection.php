<?php
namespace Magestore\Film\Model\ResourceModel\Category;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
    public function _construct(){

    parent::_construct();
    $this->_init('Magestore\Film\Model\Film', 'Magestore\Film\Model\ResourceModel\Film');
 }
}