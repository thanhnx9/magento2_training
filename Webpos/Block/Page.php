<?php

namespace Magestore\Webpos\Block;



class Page extends AbstractBlock
{
    public function toHtml()
    {
        $isLogin = \Magento\Framework\App\ObjectManager::getInstance()->create('Magestore\Webpos\Helper\Permission')
            ->isLogin();
        if(!$isLogin)
            return parent::toHtml();
        return '';
    }

}