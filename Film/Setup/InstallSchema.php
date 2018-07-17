<?php
/**
 * Created by PhpStorm.
 * User: ntxbaraka
 * Date: 5/4/2018
 * Time: 4:08 PM
 */
namespace Magestore\Film\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Db\Ddl\Table;
class InstallSchema implements InstallSchemaInterface{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup ;
        $installer ->startSetup();
        /*
         * Drop tables if exists
         */
        $installer->getConnection()->dropTable($installer->getTable('zero_training_four_film_category'));
        $installer->getConnection()->dropTable($installer->getTable('zero_training_four_film'));
        $installer->getConnection()->dropTable($installer->getTable('zero_training_four_actor'));
        $installer->getConnection()->dropTable($installer->getTable('zero_training_four_film_actor'));
        $installer->getConnection()->dropTable($installer->getTable('zero_training_four_category'));

        $table = $installer->getConnection()->newTable($installer->getTable('zero_training_four_film')
        )
            ->addColumn(
            'film_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Film ID'
        )
            ->addColumn(
            'title',
            Table::TYPE_TEXT,
            255,
            ['nullable'=>false, 'default'=>''],
            'Title Film'
        )
            ->addColumn(
                'description',
                Table::TYPE_TEXT,
                null,
                ['nullable'=>false ],
                'Description'
        )
            ->addColumn(
            'language_id',
            Table::TYPE_SMALLINT,
            5 ,['nullable'=>false,'default'=>'1'],
            'Language ID'
        )
            ->addColumn(
            'original_language_id',
            Table::TYPE_SMALLINT,
            5,
            ['nullable' =>false,'default'=>'1'],
            'Original Language ID'
        )
            ->addColumn(
                'rental_duration',
                Table::TYPE_SMALLINT,
                5,
                ['nullable' =>false,'default'=>'1'],
                'Rental Duration'
        )
            ->addColumn(
                'rental_rate',
                Table::TYPE_DECIMAL,
                '4,2',
                ['nullable' =>false],
                'Rental rate'
        )
            ->addColumn(
                'length',
                Table::TYPE_SMALLINT,
                5,
                ['nullable' =>false,'default'=>'1'],
                'Length'
        )
            ->addColumn(
                'replacement_cost',
                Table::TYPE_DECIMAL,
                '5,2',
                ['nullable' =>false],
                'Replacement Cost'
        )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' =>false],
                'Created at'
        )
            ->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' =>false],
                'Updated at'
        );
        $installer->getConnection()->createTable($table);
        //*********//

        $table = $installer->getConnection()->newTable($installer->getTable('zero_training_four_category')
        )
            ->addColumn(
                'category_id',
                Table::TYPE_INTEGER,
                10,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Category ID'
            )
            ->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false],
                'Name'
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable'=>false ],
                'Created at'
            )
            ->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable'=>false],
                'Updated at'
            );
        $installer->getConnection()->createTable($table);
        //*********//

        $table = $installer->getConnection()->newTable($installer->getTable('zero_training_four_actor')
        )
            ->addColumn(
                'actor_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                10,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Film ID'
            )
            ->addColumn(
                'first_name',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false],
                'First name'
            )
            ->addColumn(
                'last_name',
                Table::TYPE_TEXT,
                255,
                ['nullable'=>false],
                'Last name'
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' =>false],
                'Created at'
            )
            ->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' =>false],
                'Updated at'
            );
        $installer->getConnection()->createTable($table);

        //*********//
        $table = $installer->getConnection()->newTable($installer->getTable('zero_training_four_film_category')
        )
            ->addColumn(
                'film_id',
                Table::TYPE_INTEGER,
                10,
                ['nullable' => false, 'unsigned' => true],
                'Film ID'
            )
            ->addColumn(
                'category_id',
                Table::TYPE_INTEGER,
                10,
                ['nullable'=>false, 'unsigned' => true],
                'Category ID'
            )
            ->addForeignKey(
                $installer->getFkName(
                    'zero_training_four_film_category',
                    'film_id',
                    'zero_training_four_film',
                    'film_id'
                ),'film_id',
                $installer->getTable('zero_training_four_film'),
                'film_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $installer->getFkName(
                    'zero_training_four_film_category',
                    'category_id',
                    'zero_training_four_category',
                    'category_id'
                ),'category_id',
                $installer->getTable('zero_training_four_category'),
                'category_id',
                Table::ACTION_CASCADE
            );

        $installer->getConnection()->createTable($table);

            /////////////////////
        $table = $installer->getConnection()->newTable($installer->getTable('zero_training_four_film_actor')
        )
            ->addColumn(
                'film_id',
                Table::TYPE_INTEGER,
                10,
                ['nullable' => false, 'unsigned' =>true],
                'Film ID'
            )
            ->addColumn(
                'actor_id',
                Table::TYPE_INTEGER,
                10,
                ['nullable'=>false, 'unsigned' =>true],
                'Actor ID'
            )
            ->addForeignKey(
                $installer->getFkName(
                    'zero_training_four_film_actor'
                    ,'film_id',
                    'zero_training_four_film',
                    'film_id'
                ),'film_id',
                $installer->getTable('zero_training_four_film'),
                'film_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $installer->getFkName(
                    'zero_training_four_film_actor',
                    'actor_id',
                    'zero_training_four_actor',
                    'actor_id'
                ),'actor_id',
                $installer->getTable('zero_training_four_actor'),
                'actor_id',
                Table::ACTION_CASCADE
            );

        $installer->getConnection()->createTable($table);

        $installer ->endSetup();


    }
}