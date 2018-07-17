<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 4/19/2018
 * Time: 4:38 PM
 */
namespace Magestore\Multivendor\Controller\Adminhtml\Vendor;

use Magento\Framework\App\ResponseInterface;

/**
 * Class ProductGrid
 * @package Magestore\Multivendor\Controller\Adminhtml\Vendor
 */
class ProductGrid extends \Magestore\Multivendor\Controller\Adminhtml\Vendor {


    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $_resultLayoutFactory;

    /**
     * ProductGrid constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     */
    public function __construct(\Magento\Backend\App\Action\Context $context,
                                \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    )
    {
        $this->_resultLayoutFactory=$resultLayoutFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        $resultLayout->getLayout()->getBlock('vendor.edit.tab.product')
            ->setProductsVendor($this->getRequest()->getPost('products_vendor',null));
        return $resultLayout;
    }
}