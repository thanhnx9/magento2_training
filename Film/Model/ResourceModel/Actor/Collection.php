<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 5/7/2018
 * Time: 2:33 PM
 */
namespace Magestore\Film\Model\ResourceModel\Actor;

class Collection extends  \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
    protected $_idFieldName = 'actor_id';

    protected function _construct()
    {
        parent::_construct();

        $this->_init('Magestore\Film\Model\Film','Magestore\Film\Model\ResourceModel\Actor');
    }
}