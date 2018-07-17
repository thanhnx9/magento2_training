<?php
namespace Magestore\Ex4Controller_\Controller\Product;

class GetCollection extends \Magento\Framework\App\Action\Action
{

    public function __construct(
        \Magento\Framework\App\Action\Context $context
    )
    {
        parent::__construct($context);
    }

    public function execute()
    {
        $number = $this->getRequest()->getParam('number');

        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
        $productCollectionFactory = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->setPageSize($number);
        foreach ($collection as $product) {
            echo $product->getName();
            echo "<br>";
        }
    }
}