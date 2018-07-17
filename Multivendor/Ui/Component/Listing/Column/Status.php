<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 4/16/2018
 * Time: 1:56 PM
 */

namespace Magestore\Multivendor\Ui\Component\Listing\Column;
use Magento\Framework\Data\OptionSourceInterface;
class Status implements OptionSourceInterface
{
    public function toOptionArray()
    {
        return [
            ['label' => __('Enabled'),'value' => 1],
            ['label' => __('Disabled'),'value' => 2],
        ];
    }
}
