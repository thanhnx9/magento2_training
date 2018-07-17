<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 5/7/2018
 * Time: 2:33 PM
 */
namespace Magestore\Film\Model;


class Actor  extends \Magento\Framework\Model\AbstractModel{

    public function __construct(\Magento\Framework\Model\Context $context,
                                \Magento\Framework\Registry $registry,
                                \Magestore\Film\Model\ResourceModel\Film $resource,
                                \Magestore\Film\Model\ResourceModel\Actor\Collection $resourceCollection
    )
    {
        parent::__construct($context, $registry, $resource, $resourceCollection);
    }

}