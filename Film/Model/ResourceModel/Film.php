<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 5/7/2018
 * Time: 2:10 PM
 */
namespace Magestore\Film\Model\ResourceModel;

class Film extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{

    /**
     *
     */
    protected function _construct()
    {
        $this->_init('zero_training_four_film', 'film_id');
    }

}