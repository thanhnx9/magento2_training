<?php

namespace Magestore\Ex8ServiceContracts\Api;
use \Magestore\Ex8ServiceContracts\Api\Data\StudentInterface;
interface StudentRepositoryInterface {
    public function save(StudentInterface $student);
  //  public function getList();
    public function delete(StudentInterface $student);
//    public function deleteById($id);
//    public function getById($id);
}