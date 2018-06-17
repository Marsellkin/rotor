<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateItemsTable extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change()
    {
        if (! $this->hasTable('items')) {
            $table = $this->table('items', ['collation' => env('DB_COLLATION')]);
            $table
                ->addColumn('board_id', 'integer')
                ->addColumn('title', 'string', ['limit' => 100])
                ->addColumn('text', 'text', ['null' => true])
                ->addColumn('user_id', 'integer')
                ->addColumn('price', 'integer')
                ->addColumn('created_at', 'integer')
                ->addColumn('updated_at', 'integer', ['null' => true])
                ->addColumn('expires_at', 'integer')
                ->addIndex('category_id')
                ->addIndex('created_at');
        }
    }
}