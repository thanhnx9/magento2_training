<?php

namespace Magestore\Webpos\Api\Data\Checkout;

/**
 * Interface ResponseInterface
 * @package Magestore\Webpos\Api\Data\Checkout
 */
interface ShippingDataInterface
{
    const CODE = 'code';
    const TITLE = 'title';
    const PRICE='price';

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

    /**
     * @param $price
     * @return mixed
     */
    public function setPrice($price);

    /**
     * @return mixed
     */
    public function getPrice();


}
