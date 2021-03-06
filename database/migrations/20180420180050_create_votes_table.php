<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CreateVotesTable extends AbstractMigration
{
    /**
     * Change Method.
     */
    public function change()
    {
        if (! $this->hasTable('votes')) {
            $table = $this->table('votes', ['collation' => env('DB_COLLATION')]);
            $table
                ->addColumn('title', 'string', ['limit' => 100])
                ->addColumn('count', 'integer', ['default' => 0])
                ->addColumn('closed', 'boolean', ['default' => 0])
                ->addColumn('created_at', 'integer')
                ->addColumn('topic_id', 'integer', ['null' => true])
                ->create();
        }
    }
}
