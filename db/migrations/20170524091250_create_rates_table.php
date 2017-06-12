<?php

use Phinx\Migration\AbstractMigration;

class CreateRatesTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $rates = $this->table("rates");
        $rates->addColumn("updated", "timestamp", array("default" => CURRENT_TIMESTAMP))
            ->addColumn("rate", "decimal")
            ->addColumn("currency", "string", array("limit" => 3))
            ->create();
    }
}
