<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 5/7/2018
 * Time: 2:12 PM
 */
namespace Magestore\Film\Model;


class Film  extends \Magento\Framework\Model\AbstractModel{

    public function __construct(\Magento\Framework\Model\Context $context,
                                \Magento\Framework\Registry $registry,
                                \Magestore\Film\Model\ResourceModel\Film $resource,
                                \Magestore\Film\Model\ResourceModel\Film\Collection $resourceCollection
                                )
    {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection);
    }

}