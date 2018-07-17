<?php

namespace Magestore\Ex8ServiceContracts\Controller\Index;
use Magento\Framework\Api\DataObjectHelper ;
use Magento\Framework\App\Action\Context;
use Magestore\Ex8ServiceContracts\Api\Data\StudentInterface;
use Magestore\Ex8ServiceContracts\Api\StudentRepositoryInterface;
class Index extends \Magento\Framework\App\Action\Action
{
    public function __construct(Context $context)
    {
        parent::__construct($context);

    }

    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $student = $objectManager->create('Magestore\Ex8ServiceContracts\Api\Data\StudentInterface'); //goi DATA interface

        $student->setName('THANH');
        $student->setClass('ATTT K59');
        $student->setUniversity('BKHN');
        $_studentRepository = $objectManager->create('Magestore\Ex8ServiceContracts\Api\StudentRepositoryInterface'); //goi DATA interface
//        \Zend_Debug::dump($student->getID().' have name '.$student->getName());
//        \Zend_Debug::dump($student->getList());
        $_studentRepository->save($student);

       echo 'id= ' . $student->getId() . ' have name is ' . $student->getName() . ' created....';
       echo '<br>';
        $_studentRepository->delete($student);
        echo 'Delete successfull';
        //     \Zend_Debug::dump($studentRespository->getList());


    }
}
