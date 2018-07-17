<?php
namespace Magestore\Multivendor\Controller\Vendor;
class View extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;
    protected $_coreRegistry = null;
    protected $_storeManager;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->_storeManager = $storeManager;
    }
    public function execute() {
        if(!$this->_coreRegistry->registry('current_category')){
            $category=$this->_objectManager->create('Magento\Catalog\Model\Category')
                ->load($this->_storeManager->getStore()->getRootCategoryId());
            $this->_coreRegistry->register('current_category', $category);
        }
        $resultPage = $this->resultPageFactory->create();// render từ file multivendor_vendor_view.xml

        $id=$this->getRequest()->getParam('id');
        $vendorModel=$this->_objectManager->create('Magestore\Multivendor\Model\Vendor')->load($id);
        $resultPage->addHandle('catalog_category_view'); //handle view cua catalog_category_view
        $resultPage->getConfig()->getTitle()->set($vendorModel->getName());
        return $resultPage;
    }
}
