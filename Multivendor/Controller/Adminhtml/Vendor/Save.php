<?php
namespace Magestore\Multivendor\Controller\Adminhtml\Vendor;
use Magento\Framework\App\Filesystem\DirectoryList;
class Save extends \Magestore\Multivendor\Controller\Adminhtml\Vendor
{
    protected $_imageHelper;
    const BASE_MEDIA_PATH = 'magestore/multivendor/images';
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magestore\Multivendor\Helper\Image $imageHelper)
    {
        $this->_imageHelper = $imageHelper;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $vendorId = (int)$this->getRequest()->getParam('vendor_id');
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if($vendorId){
                $vendor_model = $this->_objectManager->create('Magestore\Multivendor\Model\Vendor')->load($vendorId);
            }
            else{
                $vendor_model = $this->_objectManager->create('Magestore\Multivendor\Model\Vendor');
            }
            $vendor_model->setData($data);

            try{
                $this->_imageHelper->mediaUploadImage($vendor_model,'logo',self::BASE_MEDIA_PATH, true);
                $vendor_model->save();
                if(isset($data['in_products'])){
                    $productIds = preg_replace("/(&)/", ',', $data['in_products']);
                    $vendorId = $vendor_model->getId();
                    $vendorProductModel = $this->_objectManager->create('Magestore\Multivendor\Model\VendorProduct')->load($vendorId, 'vendor_id');
                    if (!$vendorProductModel->getId()) {
                        $vendorProductModel = $this->_objectManager->create('Magestore\Multivendor\Model\VendorProduct');
                    }
                    $vendorProductModel->setData('vendor_id', $vendorId);
                    $vendorProductModel->setData('product_ids', $productIds);

                    $vendorProductModel->save();
                }
                $this->messageManager->addSuccess(__('Vendor was successfully saved'));
            }catch (\Exception $e){
                $this->messageManager->addError($e->getMessage());
                return  $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
            if ($this->getRequest()->getParam('back') == 'edit') {
                return  $resultRedirect->setPath('*/*/edit', ['id' =>$vendor_model->getId()]);
            }

            return $resultRedirect->setPath('*/*/');
        }
    }
}