<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 4/17/2018
 * Time: 1:27 PM
 */
namespace Magestore\Multivendor\Block\Adminhtml\Vendor\Edit;
/**
 * Class Form
 * @package Magestore\Multivendor\Block\Adminhtml\Vendor\Edit
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic{
    /**
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $form =$this->_formFactory->create(
            array(
                'data'=>array(
                    'id'=>'edit_form',
                    'action'=>$this->getUrl('*/*/save',['store'=>$this->getRequest()->getParam('store')]),
                    'method'=>'post',
                    'enctype'=>'multipart/form-data'
                )
            )
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}

//Phần này sẽ khai báo id, action, method…(các thuộc tính cơ bản của form tương tự html).