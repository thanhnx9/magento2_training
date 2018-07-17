<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 4/16/2018
 * Time: 4:01 PM
 */
namespace Magestore\Multivendor\Controller\Adminhtml\Vendor;

/**
 * Class Edit
 * @package Magestore\Multivendor\Controller\Adminhtml\Vendor
 */
class Edit extends \Magestore\Multivendor\Controller\Adminhtml\Vendor{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * Edit constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(\Magento\Backend\App\Action\Context $context,
    \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {

        $this ->_resultPageFactory =$resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return $this|\Magento\Framework\View\Result\Page
     */
    // thực hiện lấy các Request đến
    //=> XỬ lý chúng
    //Khi không có ID=> tạo form trống
    //CÓ ID=> lưu dữ liệu vào các biến
    public function execute()
    {
        $id =$this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        $model = $this->_objectManager->create('Magestore\Multivendor\Model\Vendor');
        $registryObject = $this->_objectManager->get('Magento\Framework\Registry');

        if ($id){
            $model = $model->load($id); //load model thông qua id
            if (!$model->getId()){
                $this->messageManager->addError(__('This vendor no longer exists.'));
                return $resultRedirect->setPath('multivendoradmin/*/',['_current'=>true]);
            }

        }
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);

        if (!empty($data)){
            $model->setData($data);
        }
        $registryObject->register('current_vendor',$model); //tạo 1 biến tạm current_vendor để lưu dữ liệu

        $resultPage = $this->_resultPageFactory->create(); // render layout
        if (!$model->getId()){
            $pageTitle=__('New Vendor');

        }else{
            $pageTitle =__('Edit Vendor %1', $model->getName());
        }
        $resultPage->getConfig()->getTitle()->prepend($pageTitle);
        return $resultPage;
    }
}