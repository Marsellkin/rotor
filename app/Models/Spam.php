<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Spam
 *
 * @property int id
 * @property string relate_type
 * @property int relate_id
 * @property int user_id
 * @property int created_at
 * @property string path
 */
class Spam extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spam';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Возвращает связанные сообщения
     *
     * @return MorphTo
     */
    public function relate(): MorphTo
    {
        return $this->morphTo('relate');
    }
}
