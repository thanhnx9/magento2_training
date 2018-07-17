<?php

namespace Magestore\Webpos\Block;


use Magento\Framework\View\Element\Template;

class AbstractBlock extends  Template
{
    protected $configProvider;

    public function __construct(Template\Context $context,
                                \Magestore\Webpos\Model\WebposConfigProvider\CompositeConfigProvider $configProvider,
                                array $data = [])
    {
        $this->configProvider=$configProvider;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function getWebposConfig(){
        return $this->configProvider->getConfig();
    }
    public function getLogoUrl(){
        return $this->getViewFileUrl('Magestore_Webpos::images/logo.png');
    }
}