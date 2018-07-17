<?php
namespace Magestore\Ex7Rewrite\Helper;
class Image extends \Magento\Catalog\Helper\Image {

    public function getUrl()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $requestInterface = $objectManager->get('Magento\Framework\App\RequestInterface');
        $moduleName     = $requestInterface->getModuleName();
        $controllerName = $requestInterface->getControllerName();
        $actionName     = $requestInterface->getActionName();
        $current= $moduleName.'_'.$controllerName.'_'.$actionName;
        if($current == 'checkout_index_index') {
            return "https://ptdesign.pt/wp-content/uploads/2012/04/magento_banner.jpg";
        }
        else {
            try {
                $this->applyScheduledActions();
                return $this->_getModel()->getUrl();
            } catch (\Exception $e) {
                return $this->getDefaultPlaceholderUrl();
            }
   }
 }
}