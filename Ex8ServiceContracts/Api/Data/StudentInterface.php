<?php

namespace Magestore\Ex8ServiceContracts\Api\Data;

interface StudentInterface{
    const ID = 'id';
    const NAME = 'name';
    const _CLASS = 'class';
    const UNIVERSITY = 'university';

    public function setName($name);
    public function setId($id);
    public function setClass($class);
    public function setUniversity($university);
    public function getName();
    public function getId();
    public function getClass();
    public function getUniversity();
}