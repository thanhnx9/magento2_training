<?php
namespace Magestore\Multivendor\Plugin\Catalog\Model;
class Product
{
    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        return 12;
    }
//
//    public function afterGetName(\Magento\Catalog\Model\Product $subject, $result)
//    {
//        return 12;
//    }
    public function aroundGetName(\Magento\Catalog\Model\Product $subject, $process) {
        $result = $process();
        return '|'.$result;
    }
}
?>