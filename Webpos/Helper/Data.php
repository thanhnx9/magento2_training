<?php

namespace Magestore\Webpos\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     *
     * @param string $path
     * @return string
     */
    public function getStoreConfig($path){
        return $this->scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}