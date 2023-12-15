<?php

declare(strict_types=1);

namespace Plugin\ProductReserve4\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200511155611 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        if(!$schema->hasTable('plg_product_reserve4_order')) {
            $table = $schema->createTable("plg_product_reserve4_order");
            $table->addColumn('id', 'integer', array('notnull' => true, 'autoincrement' => true));
            $table->addColumn('order_id', 'integer');
            $table->addColumn('product_id', 'integer');
            $table->addColumn('created_at', 'datetime');
            $table->setPrimaryKey(array('id'));
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        if ($schema->hasTable('plg_product_reserve4_order')) {
            $schema->dropTable('plg_product_reserve4_order');
        }
    }
}
