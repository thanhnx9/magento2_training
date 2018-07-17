<?php

namespace Magestore\Webpos\Controller\Adminhtml\Staff;

class Delete extends \Magestore\Webpos\Controller\Adminhtml\Staff
{
    /**
     * @var \Magestore\Webpos\Model\StaffFactory
     */
    protected $_staffFactory;


//    public function __construct(
//        \Magento\Backend\App\Action\Context $context,
//        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
//        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
//        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
//        \Magestore\Webpos\Model\StaffFactory $staffFactory
//    ) {
//
//        $this->_staffFactory = $staffFactory;
//        parent::__construct($context, $resultPageFactory, $resultLayoutFactory, $resultForwardFactory);
//    }
//
//    /**
//     * @return $this
//     */
//    public function execute()
//    {
//        $resultRedirect = $this->resultRedirectFactory->create();
//        $userId = $this->getRequest()->getParam('staff_id');
//        if ($userId > 0) {
//            $userModel = $this->_staffFactory->create()->load($this->getRequest()->getParam('staff_id'));
//            try {
//                $userModel->delete();
//                $this->messageManager->addSuccess(__('Staff was successfully deleted'));
//            } catch (\Exception $e) {
//                $this->messageManager->addError($e->getMessage());
//                return $resultRedirect->setPath('*/*/edit', ['_current' => true]);
//            }
//        }
//        return $resultRedirect->setPath('*/*/');
//    }
public function execute()
{
    // TODO: Implement execute() method.
}
}
