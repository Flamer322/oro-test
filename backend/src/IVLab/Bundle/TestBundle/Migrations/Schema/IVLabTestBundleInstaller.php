<?php

namespace IVLab\Bundle\TestBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class IVLabTestBundleInstaller implements Installation
{
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createCategoryCategoriesTable($schema);
        $this->createProductProductsTable($schema);

        /** Foreign keys generation **/
        $this->addCategoryCategoriesForeignKeys($schema);
        $this->addProductProductsForeignKeys($schema);
    }

    /**
     * Create category_categories table
     *
     * @param Schema $schema
     */
    protected function createCategoryCategoriesTable(Schema $schema)
    {
        $table = $schema->createTable('category_categories');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('parent_category_id', 'integer', ['notnull' => false]);
        $table->addColumn('name', 'string', ['length' => 300]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['parent_category_id'], 'idx_1ced1616796a8f92', []);
    }

    /**
     * Create product_products table
     *
     * @param Schema $schema
     */
    protected function createProductProductsTable(Schema $schema)
    {
        $table = $schema->createTable('product_products');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('category_id', 'integer', []);
        $table->addColumn('name', 'string', ['length' => 300]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['category_id'], 'idx_780a30cd12469de2', []);
    }

    /**
     * Add category_categories foreign keys.
     *
     * @param Schema $schema
     */
    protected function addCategoryCategoriesForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('category_categories');
        $table->addForeignKeyConstraint(
            $schema->getTable('category_categories'),
            ['parent_category_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
    }

    /**
     * Add product_products foreign keys.
     *
     * @param Schema $schema
     */
    protected function addProductProductsForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('product_products');
        $table->addForeignKeyConstraint(
            $schema->getTable('product_products'),
            ['category_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'CASCADE']
        );
    }
}