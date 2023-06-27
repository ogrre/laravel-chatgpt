<?php

namespace Ogrre\ChatGPT\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'role',
        'content',
        'chat_id',
    ];

    /**
     * @var string
     */
    protected $table = 'messages';

    /**
     * @return BelongsTo
     */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
}
