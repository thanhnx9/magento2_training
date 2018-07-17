<?php

namespace Magestore\Ex8ServiceContracts\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magestore\Ex8ServiceContracts\Api\StudentRepositoryInterface;
use \Magestore\Ex8ServiceContracts\Api\Data\StudentInterface;
class StudentRepository implements StudentRepositoryInterface{

    protected $_studentResource;
    protected $_instances = [];
    public function __construct(
        \Magestore\Ex8ServiceContracts\Model\ResourceModel\Student $studentResource

    ){
        $this->_studentResource = $studentResource;
    }

//    public function getList()
//    {
//        return $this->_studentResource->getData();
//    }

    public function save(StudentInterface $student)
    {
       try {
         return   $this->_studentResource->save($student);
       } catch (\Exception $ex){
           echo $ex;
       }
    }

    public function delete(StudentInterface $student)
    {
        try {
            return   $this->_studentResource->delete($student);
        } catch (\Exception $ex){
            echo $ex;
        }
    }
//    public function getById($id)
//    {
//        if (!isset($this->_instances[$id])) {
//
//            $student = $this->_studentResource->create();
//            $this->_studentResource->load($student, $id);
//            if (!$student->getId()) {
//                throw new NoSuchEntityException(__('Requested data doesn\'t exist'));
//            }
//            $this->_instances[$id] = $student;
//        }
//        return $this->_instances[$id];
//    }
//
//    public function deleteById($id){
//        $student= $this->getById($id);
//        return $this->_studentResource->delete($student);
//    }
}