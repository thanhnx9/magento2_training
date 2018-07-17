<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 5/7/2018
 * Time: 2:33 PM
 */
namespace Magestore\Film\Model\ResourceModel;

class Actor extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{

    /**
     *
     */
    protected function _construct()
    {
        // TODO: Implement _construct() method.
        $this->_init('zero_training_four_actor', 'actor_id');
    }
}