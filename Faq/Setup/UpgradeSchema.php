<?php
namespace Magestore\Faq\Setup;
use Magento\Catalog\Model\Indexer\Product\Price\UpdateIndexInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Db\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface {
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if(version_compare($context->getVersion(), '1.0.1', '<')) {
            $installer->getConnection()->dropColumn(
                $installer->getTable('faq_category'),
                'ordering'
            );
            $installer->getConnection()->dropColumn(
                $installer->getTable('faq'),
                'ordering'
            );
        }
        //Nâng version FAQ lên 1.0.2, thêm cột sort_order vào bảng faq_category và faq

        if(version_compare($context->getVersion(), '1.0.2','<')){
            $faq_categoryTable=$installer->getTable('faq_category');
            $faqTable=$installer->getTable('faq');
            if($installer->getConnection()->isTableExists($faq_categoryTable) == true){
                $installer->getConnection()->addColumn(
                    $faq_categoryTable,
                    'sort_order',
                    [
                        'type'=>Table::TYPE_SMALLINT,
                        'size'=>null,
                        'nullable'=>false,
                        'comment'=>'Sort Order'
                    ]
                );
            }
            if($installer->getConnection()->isTableExists($faqTable) == true){
                $installer->getConnection()->addColumn(
                    $faqTable,
                    'sort_order',
                    [
                        'type'=>Table::TYPE_SMALLINT,
                        'size'=>null,
                        'nullable'=>false,
                        'comment'=>'Sort Order'
                    ]
                );
            }
        }
    }
}