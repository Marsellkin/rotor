<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateStatusTable extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change()
    {
        if (! $this->hasTable('status')) {
            $table = $this->table('status', ['collation' => env('DB_COLLATION')]);
            $table
                ->addColumn('topoint', 'integer')
                ->addColumn('point', 'integer')
                ->addColumn('name', 'string', ['limit' => 50])
                ->addColumn('color', 'string', ['limit' => 10, 'null' => true])
                ->addIndex('point')
                ->addIndex('topoint')
                ->create();
        }
    }
}
