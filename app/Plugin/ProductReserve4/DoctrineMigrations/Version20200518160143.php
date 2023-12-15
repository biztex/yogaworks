<?php
declare(strict_types=1);

namespace Plugin\ProductReserve4\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200518160143 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        if(!$schema->hasTable('plg_product_class_reserve4_extra')) {
            $table = $schema->createTable("plg_product_class_reserve4_extra");
            $table->addColumn('id', 'integer', array('notnull' => true, "unsigned"=>true, 'autoincrement' => true));
            $table->addColumn('product_class_id', 'integer', array('notnull' => false, "unsigned"=>true));
            $table->addColumn('class_category_id1', 'integer', array('notnull' => false, "unsigned"=>true));
            $table->addColumn('class_category_id2', 'integer', array('notnull' => false, "unsigned"=>true));
            $table->addColumn('product_id', 'integer',  array("unsigned"=>true));
            $table->addColumn('is_allowed', 'integer', array("default" => 0));
            $table->addColumn('start_date', 'datetimetz', array('notnull' => false));
            $table->addColumn('end_date', 'datetimetz', array('notnull' => false));
            $table->addColumn('shipping_date', 'datetimetz', array('notnull' => false));
            $table->addColumn('shipping_date_changed', 'integer', array('default' => 0));
            $table->addColumn('create_date', 'datetimetz');
            $table->addColumn('update_date', 'datetimetz');
            $table->setPrimaryKey(array('id'));
            $table->addForeignKeyConstraint('dtb_product_class', ['product_class_id'], ['id']);
            $table->addForeignKeyConstraint('dtb_class_category', ['class_category_id1'],['id']);
            $table->addForeignKeyConstraint('dtb_class_category', ['class_category_id2'],['id']);
            $table->addForeignKeyConstraint('dtb_product', ['product_id'],['id']);
        }
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        if ($schema->hasTable('plg_product_class_reserve4_extra')) {
            $schema->dropTable('plg_product_class_reserve4_extra');
        }
    }
}
