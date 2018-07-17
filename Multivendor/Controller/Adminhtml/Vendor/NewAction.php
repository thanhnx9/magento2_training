<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 4/16/2018
 * Time: 3:56 PM
 */
namespace Magestore\Multivendor\Controller\Adminhtml\Vendor;

use Magento\Framework\Controller\ResultFactory;
/**
 * Class NewAction
 * @package Magestore\Multivendor\Controller\Adminhtml\Vendor
 */

//Thực hiện khi người dùng bấm vào nút Add Vendor
class NewAction extends \Magestore\Multivendor\Controller\Adminhtml\Vendor{

  /**
   * @return mixed
   */
    public function execute()
    {
        $resultForward =$this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        return $resultForward->forward('edit'); //=> điều hướng chuyển đến Form EDIT
    }
}


