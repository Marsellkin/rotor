<?php

use Phinx\Migration\AbstractMigration;

class CreateOnlineTable extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change()
    {
        if (! $this->hasTable('online')) {
            $table = $this->table('online', ['collation' => env('DB_COLLATION')]);
            $table
                ->addColumn('ip', 'string', ['limit' => 15])
                ->addColumn('brow', 'string', ['limit' => 25])
                ->addColumn('updated_at', 'integer', ['null' => true])
                ->addColumn('user_id', 'integer', ['null' => true])
                ->addIndex('ip')
                ->addIndex('updated_at')
                ->addIndex('user_id')
                ->create();
        }
    }
}
