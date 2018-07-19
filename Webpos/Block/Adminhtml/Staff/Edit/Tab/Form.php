<?php

namespace Magestore\Webpos\Block\Adminhtml\Staff\Edit\Tab;


class Form extends \Magento\Backend\Block\Widget\Form\Generic
    implements \Magento\Backend\Block\Widget\Tab\TabInterface

{

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * Form constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = array()
    )
    {
        $this->_objectManager = $objectManager;
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('page.title')->setPageTitle($this->getPageTitle());
    }

    protected function _prepareForm()
    {

        $model = $this->_coreRegistry->registry('current_staff');

        $data = array();
        if ($model->getId()) {
            $data = $model->getData();
        }

        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Staff Information')));

        if ($model->getId()) {
            $fieldset->addField('staff_id', 'hidden', array('name' => 'staff_id'));
        }

        $fieldset->addField('username', 'text', array(
            'label' => __('User Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'username'
        ));

        $fieldset->addField('display_name', 'text', array(
            'label' => __('Display Name'),
            'required' => true,
            'name' => 'display_name'
        ));
        $fieldset->addField('email', 'text', array(
            'label' => __('Email Address'),
            'class' => 'required-entry validate-email',
            'required' => true,
            'name' => 'email'
        ));

        if ((isset($data['staff_id']) && $data['staff_id']) || $this->getRequest()->getParam('id')) {
            $fieldset->addField('password', 'password', array(
                'label' => __('New Password'),
                'name' => 'new_password',
                'class' => 'input-text validate-admin-password',
            ));
            $fieldset->addField('password_confirmation', 'password', array(
                'label' => __('Password Confirmation'),
                'name' => 'password_confirmation',
                'class' => 'input-text validate-cpassword',
            ));
        } else {
            $fieldset->addField('password', 'password', array(
                'label' => __('Password'),
                'required' => true,
                'name' => 'password',
                'class' => 'input-text required-entry validate-admin-password',
            ));
            $fieldset->addField('password_confirmation', 'password', array(
                'label' => __('Password Confirmation'),
                'name' => 'password_confirmation',
                'required' => true,
                'class' => 'input-text required-entry validate-cpassword',
            ));
        }

        $fieldset->addField('customer_group', 'multiselect', array(
            'label' => __('Customer Group'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'customer_group',
            'values' => $this->_objectManager->get('Magestore\Webpos\Model\Source\Adminhtml\CustomerGroup')->toOptionArray()
        ));

        $fieldset->addField('status', 'select', array(
            'label' => __('Status'),
            'name' => 'status',
            'options' => ['1' => __('Enabled'), '2' => __('Disabled')],
        ));
        unset($data['password']);
        unset($data['password_confirmation']);

        $form->setValues($data);
        $this->setForm($form);
        return parent::_prepareForm();
    }
    public function getStaff()
    {
        return $this->_coreRegistry->registry('current_staff');
    }
    public function getPageTitle()
    {
        return $this->getStaff()->getId() ? __("Edit Staff %1",
            $this->escapeHtml($this->getStaff()->getDisplayName())) : __('New Staff');
    }

    /**
     * Return Tab label
     *
     * @return string
     * @api
     */
    public function getTabLabel()
    {
        return __('Staff Information');
    }

    /**
     * Return Tab title
     *
     * @return string
     * @api
     */
    public function getTabTitle()
    {
        return __('Staff Information');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     * @api
     */
    public function canShowTab()
    {
      return  true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     * @api
     */
    public function isHidden()
    {
        return false;
    }
}