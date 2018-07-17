<?php
namespace Magestore\Webpos\Controller\Index;
use Magento\Payment\Gateway\Http\Client\Zend;

class Collection extends \Magento\Framework\App\Action\Action {
    public function execute()
    {
        $productCollection= $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection')
            ->addAttributetoSelect(['name', 'price','image']) // lay cac thuoc tinh cua Product
            ->addAttributeToFilter( 'entity_id', array( 'in' => array(210,211,212) ) )
        ->setPageSize(10,1);
        $output='';

        $productCollection->setDatatoAll('price',200);
        foreach ($productCollection as $product){
            $output .= \Zend_Debug::dump($product->debug(), null,false);
        }
        $this->getResponse()->setBody($output);
       echo $productCollection->getSelect()->__toString();

//       echo '</br>';
//        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//        $list = $objectManager->create('\Magestore\Webpos\Api\Checkout\CheckoutRepositoryInterface'); //goi DATA interface
//        \Zend_Debug::dump($list->saveCart());
    }
}