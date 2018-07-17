<?php
namespace Magestore\Helloworld\Controller\Index;

use Magento\Framework\App\Action\Context;

class Test extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     * @return \Magento\Framework\App\Action\Action
    */

    public function __construct(Context $context,
                                \Magento\Framework\View\Result\PageFactory $pageFactory)
    {   $this->_pageFactory=$pageFactory;
        return parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return void
     */
    public function execute()
    {
        // TODO: Implement execute() method.
    echo "Hello World";
    exit;
    }
}
