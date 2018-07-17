<?php
namespace Magestore\Ex8ServiceContracts\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $installer->getConnection()->dropTable($installer->getTable('student'));

        $table = $installer->getConnection()->newTable($installer->getTable('student'))
            ->addColumn(
                'id', Table::TYPE_INTEGER, null,
                ['identity'=>true, 'unsigned'=>true, 'nullable'=>false, 'primary'=>true],
                'ID'
            )
            ->addColumn(
                'name', Table::TYPE_TEXT, 255,
                ['nullable'=>false, 'default'=>''],
                'Name'
            )
            ->addColumn(
                'class', Table::TYPE_TEXT, 255,
                ['nullable'=>false, 'default'=>''],
                'Class'
            )
            ->addColumn(
                'university', Table::TYPE_TEXT, 255,
                ['nullable'=>false, 'default'=>''],
                'University'
            );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}