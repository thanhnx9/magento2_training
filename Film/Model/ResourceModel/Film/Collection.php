<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 5/7/2018
 * Time: 2:21 PM
 */
namespace Magestore\Film\Model\ResourceModel\Film;

class Collection extends  \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
    protected $_idFieldName = 'film_id';

    protected function _construct()
    {
        parent::_construct();

        $this->_init('Magestore\Film\Model\Film','Magestore\Film\Model\ResourceModel\Film');
    }

    protected function _initSelect()
    {
         parent::_initSelect();

        $this->getSelect()
            ->join('zero_training_four_film_category as film_category',
                'main_table.film_id = film_category.film_id')

            ->joinLeft('zero_training_four_category as category',
                'film_category.category_id = category.category_id',
                array('category_name' => 'GROUP_CONCAT(distinct category.name)'))

            ->joinRight('zero_training_four_film_actor as film_actor',
                'main_table.film_id = film_actor.film_id',
                array('actor_num'=>'COUNT(distinct film_actor.actor_id)'))

            ->group('main_table.film_id')
            ->join('zero_training_four_actor as actor',

                'actor.actor_id = film_actor.actor_id',
                array("actor_name" => "GROUP_CONCAT(distinct first_name,' ',last_name)"))

//            ->group('category.category_id')
            ->having("COUNT(distinct film_actor.actor_id) <5");
            return $this;

    }


}