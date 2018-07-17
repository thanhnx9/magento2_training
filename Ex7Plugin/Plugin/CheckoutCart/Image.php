<?php
namespace Magestore\Ex7Plugin\Plugin\CheckoutCart;

const SHORTCUT_IMAGE = 'https://www.paypalobjects.com/webstatic/en_US/i/buttons/ppcredit-logo-medium.png';
const CHECKOUT_PAGE= 'checkout_index_index';
class Image extends \Magento\Catalog\Helper\Image
{

    public function afterGetWith(\Magento\Catalog\Helper\Image $subject, $result)
    {
        if($this->getFullRequest()=='checkout_index_index'){
            return 400;
        }else{
            return $result;
        }
    }
    public function afterGetHeight(\Magento\Catalog\Helper\Image $subject, $result)
    {
        if ($this->getFullRequest() == 'checkout_index_index') {
            return 600;
        } else {
            return $result;
        }
    }
    public function afterGetUrl(\Magento\Catalog\Helper\Image $subject, $result){
        if($this->getFullRequest() == 'checkout_index_index') {
            return "https://ptdesign.pt/wp-content/uploads/2012/04/magento_banner.jpg";
        } else {
            return $result;
        }
    }
    public function getFullRequest()
    {
        $routeName = $this->_getRequest()->getRouteName();
        $controllerName = $this->_getRequest()->getControllerName();
        $actionName = $this->_getRequest()->getActionName();
        return $routeName.'_'.$controllerName.'_'.$actionName;
    }
}