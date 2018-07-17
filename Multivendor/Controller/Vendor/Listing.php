<?php
namespace Magestore\Multivendor\Controller\Vendor;
class Listing extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $this->_view->loadLayout(); //load tất cả các block đã khai báo trong file layout<file .xml>
        $this->_view->renderLayout(); //render ra mã html => hiển thị trên trình duyệt các block đã khai báo
    }
}
