<?php
namespace Magestore\Webpos\Model;
class Session extends \Magento\Framework\Session\SessionManager
{

    public function setWebposId($staffId){
        $this->storage->setData('webpos_id', $staffId);
    }

    public function getWebposId(){
        return $this->storage->getData('webpos_id');
    }
}
