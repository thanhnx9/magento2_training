<?php

namespace Magestore\Faq\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Db\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;
//sai chinh ta
class InstallSchema implements InstallSchemaInterface
{

    /**
     * Installs DB schema for a module
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        /*
         * Drop tables if exists
         * */
        $installer->getConnection()->dropTable($installer->getTable('faq_category'));
        $installer->getConnection()->dropTable($installer->getTable('faq_category_value'));
        $installer->getConnection()->dropTable($installer->getTable('faq'));
        $installer->getConnection()->dropTable($installer->getTable('faq_value'));
        /*************************/
        $table = $installer->getConnection()->newTable(
            $installer->getTable('faq_category')
        )->addColumn(
            'category_id',
            Table:: TYPE_INTEGER,
            null,
            ['identity'=>true,'unsigned' =>true,'nullable'=>false, 'primary'=>true],
            'category ID'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            ['nullable'=>false, 'default'=>''],
            'Faq Name'
        )->addColumn(
            'ordering',
            Table::TYPE_INTEGER,
            null ,
            ['nullable'=>false,'default'=>'1'],
            'Ordering'
        )->addColumn(
            'status',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' =>true,'default'=>'0'],
            'Status'
        );
        $installer->getConnection()->createTable($table);

        /**************/
        $table = $installer->getConnection()->newTable(
            $installer->getTable('faq_category_value')
        )->addColumn(
            'category_value_id',
            Table::TYPE_INTEGER,
            null,['identity'=>true,'unsigned'=>true,'nullable'=>false,'primary'=>true],
            'ID'
        )->addColumn(
            'category_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable'=>false,'unsigned'=>true],
            'Category id'
        )->addColumn(
            'store_id',
            Table::TYPE_SMALLINT,
            null,
            ['nullable'=>false,'unsigned'=>true],
            'Store Ids'
        )
            ->addColumn(
                'attribute_code',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'unsigned'=>true],
                'Attribute Code'
            )
            ->addColumn('value',
                Table::TYPE_TEXT,
                null,
                ['nullable'=>false,'unsigned'=>true],
                'Value'
            )
            ->addForeignKey(
                $installer->getFkName('faq_category_value', 'category_id', 'faq_category', 'category_id'),
                'category_id',
                $installer->getTable('faq_category'),
                'category_id',
                //when the parent is deleted, delete the row with foreign key
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $installer->getFkName('faq_category_value', 'store_id', 'store', 'store_id'),
                'store_id',
                $installer->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE

            );
        $installer->getConnection()->createTable($table);

        /************************************/

        $table=$installer->getConnection()->newTable(
            $installer->getTable('faq')
        )
            ->addColumn(
                'faq_id',
                Table::TYPE_INTEGER,
                null,
                ['indentity'=>true,'nullable'=>false,'unsigned'=>true, 'primary'=>true],
                'ID'
            )
            ->addColumn(
                'title',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false, 'unsigned'=>true],
                'Title'
            )
            ->addColumn(
                'category_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable'=>false, 'unsigned'=>true,'default'=> '0'],
                'Category ID'
            )
            ->addColumn(
                'description',
                Table::TYPE_TEXT,
                null,
                ['nullable'=>false, 'unsigned'=>true],
                'Description'
            )
            ->addColumn(
                'status',
                Table::TYPE_SMALLINT,
                null,
                ['nullable'=>false, 'unsigned'=>true,'default'=>'1'],
                'Status'
            )
            ->addColumn(
                'create_time',
                Table::TYPE_DATETIME,
                null ,
                ['nullable'=>true],
                'Create Time'
            )
            ->addColumn(
                'update_time',
                Table::TYPE_DATETIME,
                null ,
                ['nullable'=>true],
                'Update Time'
            )
            ->addColumn(
                'url_key',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>''],
                'Url key'
            )
            ->addColumn(
                'ordering',
                Table::TYPE_INTEGER,
                null,
                ['nullable'=>false,'default'=>'1'],
                'Ordering'
            )
            ->addColumn(
                'most_frequently',
                Table::TYPE_SMALLINT,
                null,
                ['nullable'=>false,'default'=>'1'],
                'Most Frequently'
            )
            ->addColumn(
                'tag',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false,'default'=>''],
                'Tag'
            )
            ->addColumn(
                'metakeyword',
                Table::TYPE_TEXT,
                null,
                ['nullable'=>false,'default'=>''],
                'MetaKeyWord'
            )
            ->addColumn(
                'metadecription',
                Table::TYPE_TEXT,
                null,
                ['nullable'=>false,'default'=>''],
                'Metadecription'
            )
            ->addIndex(
                $installer->getIdxName('faq', ['category_id'], AdapterInterface::INDEX_TYPE_UNIQUE),
                ['category_id'],
                AdapterInterface::INDEX_TYPE_UNIQUE
            )
            ->addForeignKey(
                $installer->getFkName('faq', 'category_id', 'faq_category', 'category_id'),
                'category_id',
                $installer->getTable('faq_category'),
                'category_id',
                //when the parent is deleted, delete the row with foreign key
                Table::ACTION_CASCADE
            );
        $installer->getConnection()->createTable($table);
        /***********************************/

        $table=$installer->getConnection()->newTable(
            $installer->getTable('faq_value')
        )
            ->addColumn(
                'faq_value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity'=>true,'nullable'=>false,'unsigned'=>true, 'primary'=>true],
                'ID'
            )
            ->addColumn(
                'faq_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable'=>false,'unsigned'=>true, 'default'=>0],
                'Faq ID'
            )
            ->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['nullable'=>false,'unsigned'=>true],
                'Store Ids')
            ->addColumn(
                'attribute_code',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>true],
                'Attribute Code'
            )
            ->addColumn(
                'value',
                Table::TYPE_TEXT,
                null,
                [
                    'nullable'=>false,
                    'default'=>''
                ],
                'Value'
            )
            ->addIndex(
                $installer->getIdxName('faq_value', ['faq_value_id'], AdapterInterface::INDEX_TYPE_UNIQUE),
                ['faq_value_id'],
                AdapterInterface::INDEX_TYPE_UNIQUE
          )
            ->addForeignKey(
                $installer->getFkName('faq_value', 'faq_id', 'faq', 'faq_id'),
                'faq_id',
                $installer->getTable('faq'),
                'faq_id',
                //when the parent is deleted, delete the row with foreign key
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $installer->getFkName('faq_value', 'store_id', 'store', 'store_id'),
                'store_id',
                $installer->getTable('store'),
                'store_id',
                //when the parent is deleted, delete the row with foreign key
                Table::ACTION_CASCADE
            );
        $installer->getConnection()->createTable($table);
        /***********************************/

        $installer->endSetup();
    }
}