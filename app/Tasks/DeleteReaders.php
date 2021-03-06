<?php

namespace App\Tasks;

use App\Models\Reader;
use Crontask\Tasks\Task;

class DeleteReaders extends Task
{
    /**
     * Удаляет старые записи статистики просмотров и скачиваний
     */
    public function run()
    {
        Reader::query()
            ->where('created_at', '<', strtotime('-3 month', SITETIME))
            ->delete();
    }
}

