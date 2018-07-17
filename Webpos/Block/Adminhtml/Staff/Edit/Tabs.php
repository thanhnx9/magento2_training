<?php


namespace Magestore\Webpos\Block\Adminhtml\Staff\Edit;


class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('staff_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Staff Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab(
            'webpos_form',
            [
                'label' => __('General'),
                'title' => __('General'),
                'content' => $this->getLayout()->createBlock('Magestore\Webpos\Block\Adminhtml\Staff\Edit\Tab\Form')
                    ->toHtml(),
                'active' => true
            ]
        );

        return parent::_beforeToHtml();
    }


}