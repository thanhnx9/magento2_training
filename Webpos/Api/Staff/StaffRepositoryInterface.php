<?php

namespace Magestore\Webpos\Api\Staff;


interface StaffRepositoryInterface
{
    /**
     * @param string $username
     * @param string $password
     * @return int|boolean
     */
    public function login($username, $password);

    /**
     *
     * @return boolean
     */
    public function logout();

}
