<?php
namespace Magestore\Webpos\Controller\Adminhtml\Staff;

use Magento\Framework\App\ResponseInterface;

class Index extends \Magestore\Webpos\Controller\Adminhtml\Staff
{

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Staff Management'));
        return $resultPage;

    }
}