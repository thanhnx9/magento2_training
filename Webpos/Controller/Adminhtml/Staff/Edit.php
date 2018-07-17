<?php
namespace Magestore\Webpos\Controller\Adminhtml\Staff;


use Magestore\Webpos\Controller\Adminhtml\Staff;

class Edit extends Staff
{

    public function execute()
    {
        $id = $this->getRequest()->getParam('staff_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        $model = $this->_objectManager->create('Magestore\Webpos\Model\Staff');

        $registryObject = $this->_objectManager->get('Magento\Framework\Registry');

        if ($id) {
            $model = $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This staff no longer exists.'));
                return $resultRedirect->setPath('webpos/*/', ['_current' => true]);
            }
        }
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $registryObject->register('current_staff', $model);
        $resultPage = $this->_resultPageFactory->create();
        if (!$model->getId()) {
            $pageTitle = __('New Staff');
        } else {
            $pageTitle =  __('Edit Staff %1', $model->getDisplayName());
        }
        $resultPage->getConfig()->getTitle()->prepend($pageTitle);
        return $resultPage;

    }
}