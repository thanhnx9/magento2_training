<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 5/7/2018
 * Time: 2:26 PM
 */

/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 5/7/2018
 * Time: 2:12 PM
 */
namespace Magestore\Film\Model;


class Category  extends \Magento\Framework\Model\AbstractModel{

    public function __construct(\Magento\Framework\Model\Context $context,
                                \Magento\Framework\Registry $registry,
                                \Magestore\Film\Model\ResourceModel\Category $resource,
                                \Magestore\Film\Model\ResourceModel\Category\Collection $resourceCollection
    )
    {
        parent::__construct($context, $registry, $resource, $resourceCollection);
    }

}