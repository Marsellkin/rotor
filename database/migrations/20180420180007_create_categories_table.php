<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateCategoriesTable extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change()
    {
        if (! $this->hasTable('categories')) {
            $table = $this->table('categories', ['collation' => env('DB_COLLATION')]);
            $table
                ->addColumn('sort', 'integer', ['default' => 0])
                ->addColumn('parent_id', 'integer', ['default' => 0])
                ->addColumn('name', 'string', ['limit' => 100])
                ->addColumn('count_blogs', 'integer', ['default' => 0])
                ->addColumn('closed', 'boolean', ['default' => 0])
                ->create();
        }
    }
}
