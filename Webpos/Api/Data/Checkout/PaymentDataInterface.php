<?php

namespace Magestore\Webpos\Api\Data\Checkout;

/**
 * Interface ResponseInterface
 * @package Magestore\Webpos\Api\Data\Checkout
 */
interface PaymentDataInterface{
    const CODE = 'code';
    const TITLE = 'title';
    /**
     * @param $code
     * @return mixed
     */
    public function setCode($code);

    /**
     * @return mixed
     */
    public function getCode();

    /**
     * @param $title
     * @return mixed
     */
    public function setTitle($title);

    /**
     * @return mixed
     */
    public function getTitle();


}
