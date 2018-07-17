<?php
namespace Magestore\SampleProduct\Controller\Test;
class AddToCart extends \Magento\Framework\App\Action\Action
{
    protected $_product;
    protected $_cart;
    protected $_formKey;
    public function __construct(\Magento\Framework\App\Action\Context $context,
                                //\Magento\Framework\Data\Form\FormKey $formKey,
                                \Magento\Catalog\Model\Product $product,
                                \Magento\Checkout\Model\Cart $cart,
                                ProductFactory $productFactory)
    {
      //  $this->_formKey = $formKey;
        $this->_product=$product;
        $this->_cart=$cart;
        parent::__construct($context);
    }
    public function execute()
    {
        if ($id = $this->getRequest()->getParam('id'))  {
            $product=$this->_product->load($id);
            $params = [
              //  'form_key' => $this->formKey->getFormKey(),
                'product' => $id,
                'qty'   =>1     //quantity of product
            ];
            //Load the product based on productID
            $this->_cart->addProduct($product, $params);
            $this->_cart->save();
            //$this->_redirect("checkout\cart\index");
            echo json_encode($params);
        }

    }
}