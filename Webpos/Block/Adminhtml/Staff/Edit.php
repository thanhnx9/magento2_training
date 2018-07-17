<?php
/**
 * Created by PhpStorm.
 * User: ntxba
 * Date: 7/3/2018
 * Time: 8:42 AM
 */

namespace Magestore\Webpos\Block\Adminhtml\Staff;



use Magento\Backend\Block\Widget\Form\Container;

class Edit extends Container
{
    protected $_coreRegistry = null;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Magestore_Webpos';
        $this->_controller = 'adminhtml_staff';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save'));
        $this->buttonList->update('delete', 'label', __('Delete'));
        $this->buttonList->add(
            'saveandcontinue',
            array(
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => array(
                    'mage-init' => array('button' => array('event' => 'saveAndContinueEdit', 'target' => '#edit_form'))
                )
            ),
            -100
        );

    }

    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('current_user')->getId()) {
            return __("Edit Staff '%1'", $this->escapeHtml($this->_coreRegistry->registry('current_staff')->getData('display_name')));
        } else {
            return __('New Staff');
        }
    }

}