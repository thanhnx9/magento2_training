<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 4/16/2018
 * Time: 4:26 PM
 */
namespace  Magestore\Multivendor\Block\Adminhtml\Vendor;
class Edit extends \Magento\Backend\Block\Widget\Form\Container{

    /**
     * @var \Magento\Framework\Registry|null
     */
    protected $_coreRegistry = null;

    /**
     * Edit constructor.
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */

    public  function __construct(\Magento\Backend\Block\Widget\Context $context,
                                 \Magento\Framework\Registry $registry,
                                 array $data = [])
    {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Magestore_Multivendor';
        $this->_controller = 'adminhtml_vendor';

        parent::_construct();

        $this->buttonList->update('save','label',__('Save'));
        $this->buttonList->update('delete','label',__('Delete'));
        $this->buttonList->add('saveandcontinue',array('label'=>__('Save and Continue Edit'),
            'class'=>'save',
            'data_arrtribute'=>array(
                'mage-init'=>array('button'=>array('event'=>'saveAndContinueEdit','target'=>'#edit_form'))
            )
        ),
        -100
        );
    }

    /**
     * @return \Magento\Framework\Phrase
     */

    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('current_vendor')->getId()){
            return __("Edit Vendor '%1'",$this->escapeHtml($this->_coreRegistry->registry('current_vendor')->getData('display_name')));

        }else{
            return __('New Vendor');
        }
    }
}
//Thay đổi các nút bấm lúc đầu