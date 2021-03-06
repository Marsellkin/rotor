<?php

use Phinx\Migration\AbstractMigration;

class CreatePollingsTable extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change()
    {
        if (! $this->hasTable('pollings')) {
            $table = $this->table('pollings', ['collation' => env('DB_COLLATION')]);
            $table
                ->addColumn('relate_type', 'string', ['limit' => 50])
                ->addColumn('relate_id', 'integer')
                ->addColumn('user_id', 'integer')
                ->addColumn('vote', 'string', ['limit' => 1])
                ->addColumn('created_at', 'integer')
                ->addIndex(['relate_type', 'relate_id', 'user_id'], ['name' => 'relate_type'])
                ->create();
        }
    }
}
