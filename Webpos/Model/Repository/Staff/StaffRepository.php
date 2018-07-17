<?php

namespace Magestore\Webpos\Model\Repository\Staff;


use Magestore\Webpos\Api\Staff\StaffRepositoryInterface;

class StaffRepository implements StaffRepositoryInterface
{
    /**
     * @var \Magestore\Webpos\Model\Session
     */
    protected $session;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var Permission
     */
    protected $permissionHelper;


    /**
     * StaffManagement constructor.
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     * @param \Magestore\Webpos\Model\WebPosSession $webPosSession
     * @param \Magestore\Webpos\Model\Staff $staff
     */
    public function __construct(
        \Magestore\Webpos\Model\Session $session,
        \Magestore\Webpos\Helper\Permission $permission,
        \Magento\Framework\App\RequestInterface $request
    )
    {
        $this->session = $session;
        $this->permissionHelper = $permission;
        $this->request = $request;
    }

    /**
     * @param string $username
     * @param string $password
     * @return int|boolean
     */

    public function login($username, $password)
    {
        if ($username && $password) {
            try {
                $staffId = $this->permissionHelper->login($username, $password);
                if ($staffId) {
                    $this->session->setWebposId($staffId);
                    return true;
                } else {
                    return false;
                }
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }
        return false;

    }

    /**
     *
     * @return boolean
     */
    public function logout()
    {
        $this->session->setWebposId(null);
        return true;

    }
}