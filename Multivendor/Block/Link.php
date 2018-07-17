<?php
namespace Magestore\Multivendor\Block;
use Magento\Framework\View\Element\Template;

class Link extends \Magento\Framework\View\Element\Html\Link{
    protected $_configHelper;
    public function __construct(Template\Context $context,\Magestore\Multivendor\Helper\Config $configHelper, array $data = [])
    {
        $this->_configHelper=$configHelper;
        parent::__construct($context, $data);
    }
    public function getHref()
    {
        return $this->_storeManager->getStore()->getUrl('multivendor/vendor/listing');
    }
    public function  toHtml()
    {        if($this->_configHelper->getStoreConfig('multivendor/general/enable_toplink') == 0){
        return '';
    }
    else{
        return parent::toHtml();
    }
    }

}