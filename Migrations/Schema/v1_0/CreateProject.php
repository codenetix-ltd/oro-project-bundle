<?php

namespace Codenetix\Oro\Bundle\ProjectBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\OrderedMigrationInterface;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * @author Egor Zyuskin <ezyuskin@codenetix.com>
 */
class CreateProject implements Migration, OrderedMigrationInterface
{
    /**
     * @param Schema   $schema
     * @param QueryBag $queries
     *
     * @return void
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->createTable('codenetix_oro_project');

        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('brief', 'string', ['length' => 100, 'notnull' => true]);
        $table->addColumn('name', 'string', ['length' => 255, 'notnull' => true]);
        $table->addColumn('business_unit_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime');
        $table->addColumn('updated_at', 'datetime');

        $table->addUniqueIndex(['brief']);
        $table->addIndex(['business_unit_owner_id']);
        $table->addIndex(['organization_id']);

        $table->addForeignKeyConstraint($schema->getTable('oro_business_unit'), ['business_unit_owner_id'], ['id'], ['onDelete' => 'SET NULL', 'onUpdate' => null]);
        $table->addForeignKeyConstraint($schema->getTable('oro_organization'), ['organization_id'], ['id'], ['onDelete' => 'SET NULL', 'onUpdate' => null]);

        $table->setPrimaryKey(['id']);
    }

    /**
     * @return integer
     */
    public function getOrder()
    {
        return 0;
    }
}
