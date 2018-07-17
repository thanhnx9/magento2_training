<?php
namespace Magestore\Multivendor\Controller\Adminhtml\Vendor;
/**
 * Class Index
 * @package Magestore\Multivendor\Controller\Adminhtml\Vendor
 */
class Index extends \Magestore\Multivendor\Controller\Adminhtml\Vendor
{
    protected $resultPageFactory;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
