<?php
namespace Magestore\Ex8ServiceContracts\Model;

use Magestore\Ex8ServiceContracts\Api\Data\StudentInterface;

class Student extends \Magento\Framework\Model\AbstractModel implements StudentInterface{

    protected function _construct()
    {
        $this->_init('Magestore\Ex8ServiceContracts\Model\ResourceModel\Student');
    }

    public function setName($name)
    {
        return $this->setData('name', $name);
    }

    public function setId($id)
    {
        $this->setData($this->_idFieldName, $id);
        return $this;
    }

    public function setClass($class)
    {
        return $this->setData('class', $class);
    }

    public function setUniversity($university)
    {
        return $this->setData('university', $university);
    }

    public function getName()
    {
        return $this->getData('name');
    }

    public function getId()
    {
        return $this->_getData($this->_idFieldName);
    }

    public function getClass()
    {
        return $this->getData('class');
    }

    public function getUniversity()
    {
        return $this->getData('university');
    }

}