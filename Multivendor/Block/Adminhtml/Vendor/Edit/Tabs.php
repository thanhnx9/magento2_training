<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 4/16/2018
 * Time: 4:41 PM
 */
namespace Magestore\Multivendor\Block\Adminhtml\Vendor\Edit;
/**
 * Class Tabs
 * @package Magestore\Multivendor\Block\Adminhtml\Vendor\Edit
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs{
    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('multivendor_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Vendor Information'));
    }

    /**
     * @return $this
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */

    //BLOCK gồm 2 TAB là multivendor_form
    //và product_section.
    protected function _beforeToHtml()
    {
        $this->addTab(
            'multivendor_form',
            [
                'label'=>__('General'),
                'title'=>__('General'),
                'content'=> $this->getLayout()
                    ->createBlock('Magestore\Multivendor\Block\Adminhtml\Vendor\Edit\Tab\Form')
                    ->toHtml(),
                'active'=>true
            ]
        );
        $this->addTab(
          'product_section',
          [
              'label'=>__('Product List'),
              'title'=>__('Product List'),
              'class'=>'ajax',
              'url'=> $this->getUrl('*/*/product',array('_current'=>true,'id'=>$this->getRequest()->getParam('id')))
          ]
        );
        return parent::_beforeToHtml();
    }
}