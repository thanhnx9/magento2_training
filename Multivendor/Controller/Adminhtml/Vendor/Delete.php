<?php
/**
 * Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
<<<<<<< HEAD
 * @
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 *
 * category    Magestore
=======
 * @category    Magestore
>>>>>>> 363b8e451d8b05959245959183f2eb11f4525779
 * @package     Magestore_Multivendor
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */
namespace Magestore\Multivendor\Controller\Adminhtml\Vendor;

class Delete extends \Magestore\Multivendor\Controller\Adminhtml\Vendor
{
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $vendorId = $this->getRequest()->getParam('id');
        if ($vendorId > 0) {
            $vendorModel = $this->_objectManager->create('Magestore\Multivendor\Model\Vendor')
                ->load($this->getRequest()->getParam('id'));
            try {
                $vendorModel->delete();
                $this->messageManager->addSuccess(__('Vendor was successfully deleted'));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['_current' => true]);
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}
