<?php
namespace Magestore\Multivendor\Controller\Adminhtml\Vendor;
use Magento\Backend\App\Action\Context;
use Magestore\Multivendor\Model\ResourceModel\Vendor\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Magestore\Multivendor\Model\ResourceModel\Vendor\Collection;

/**
 * Class MassStatus
 * @package Magestore\Multivendor\Controller\Adminhtml\Vendor
 */
class MassStatus extends AbstractMassAction
{

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context, $filter, $collectionFactory);
    }


    /**
     * @param Collection $collection
     * @return \Magento\Framework\Controller\ResultInterface
     */
    protected function massAction(Collection $collection)
    {
        $vendorChangeStatus = 0;
        foreach ($collection as $vendor) {
            $vendor->setStatus($this->getRequest()->getParam('status'))->save();
            $vendorChangeStatus++;
        }

        if ($vendorChangeStatus) {
            $this->messageManager->addSuccess(__('A total of %1 record(s) were updated.', $vendorChangeStatus));
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($this->getComponentRefererUrl());

        return $resultRedirect;
    }
}
