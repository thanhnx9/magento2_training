<?php
/**
 * Created by PhpStorm.
 * User: ntxba
 * Date: 7/2/2018
 * Time: 4:13 PM
 */

namespace Magestore\Webpos\Controller\Adminhtml;


use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;

abstract class  Staff extends Action
{
    protected $_resultFowardFactory;
    protected $_resultLayoutFactory;
    protected $_resultPageFactory;
    public function __construct(Context $context,
                                PageFactory $resultPageFactory,
                                LayoutFactory $resultLayoutFactory,
                                ForwardFactory $resultForwardFactory)
    {
        $this->_resultFowardFactory = $resultForwardFactory;
        $this->_resultLayoutFactory = $resultLayoutFactory;
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    protected function _initAction(){

        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Magestore_Webpos::staff');
        $resultPage->addBreadcrumb(__('Webpos'), __('Webpos'));

        $resultPage->addBreadcrumb(__('Staff'), __('Staff'));
        return $resultPage;

    }
    protected function _isAllowed(){
        return $this->_authorization->isAllowed('Magestore_Webpos::staff');

    }
}