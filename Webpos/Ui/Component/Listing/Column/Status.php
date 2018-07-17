<?php

namespace Magestore\Webpos\Ui\Component\Listing\Column;


use Magento\Framework\Data\OptionSourceInterface;

class Status implements  OptionSourceInterface
{

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return [
            ['label' => __('Enabled'),'value' => 1],
            ['label' => __('Disabled'),'value' => 2],
        ];

    }
}