<?php
namespace Magestore\Helloworld\Setup;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements  \Magento\Framework\Setup\InstallSchemaInterface{

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws \Zend_Db_Exception
     * @throws \Zend_Db_Exception
     */public function install(SchemaSetupInterface $setup,
                           ModuleContextInterface $context)
{
    // TODO: Implement install() method.
        $installer=$setup;
        $installer->startSetup();
        if(!$installer->tableExists('magestore_helloworld_post')){
            $table=$installer->getConnection()->newTable(
                $installer->getTable('magestore_helloworld_post')
            )
                ->addColumn(
                    'post_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity'=> true,
                        'nullable'=>false,
                        'primary'=>true,
                        'unsigned'=>true,
                    ],
                    'Post ID'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                    255,
                    [
                        'nullable'=>false
                    ],
                    'Post Name'
                )
                ->addColumn(
                    'url_key',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Post URL Key'
                )
                ->addColumn(
                    'post_content',
                    Table::TYPE_TEXT,
                    '64k',
                    [],
                    'Post Post Content'
                )
                ->addColumn(
                    'tags',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Post Tags'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_INTEGER,
                    1,
                    [],
                    'Post Status'
                )
                ->addColumn(
                    'featured_image',
                    Table::TYPE_TEXT,
                    255,
                    [],
                    'Post Feature Image'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    [
                        'nullable'=> false,
                        'default'=>Table::TIMESTAMP_INIT
                    ],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    [
                        'nullable'=>false,
                        'default'=>Table::TIMESTAMP_INIT_UPDATE
                    ],
                    'Updated At'
                )->setComment('Post Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('magestore_helloworld_post'),
                 $setup->getIdxName(
                      $installer->getTable('magestore_helloworld_post'),
                      ['name', 'url_key', 'post_content','tags','featured_image'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['name', 'url_key','post_content','tags','featured_image'],
            \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
        );
        }
    $installer->endSetup();
}
}