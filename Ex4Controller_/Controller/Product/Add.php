<?php
namespace Magestore\Ex4Controller_\Controller\Product;

class Add extends \Magento\Framework\App\Action\Action{

    protected $formKey;
    protected $cart;
    protected $product;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Model\Product $product
    ) {
        $this->formKey = $formKey;
        $this->cart = $cart;
        $this->product = $product;
        parent::__construct($context);
    }

    public function execute()
    {
        $number = $this->getRequest()->getParam('number');

        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
        $productCollectionFactory = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('type_id', array('eq' => 'simple'));
        $collection->addAttributeToFilter('entity_id', array('lteq' => $number));

        foreach ($collection as $product) {
            $params = array(
                'form_key' => $this->formKey->getFormKey(),
                'product' => $product->getId(),
                'qty' => 1
            );
            $this->cart->addProduct($product, $params);
        }

        $this->cart->save();
        $this->getResponse()->setRedirect('/magento2/checkout/cart/index');
    }
}