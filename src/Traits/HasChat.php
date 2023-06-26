<?php

namespace Ogrre\ChatGPT\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Ogrre\ChatGPT\Models\Chat;

trait HasChat
{
    /**
     * @return HasMany
     */
    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }

    /**
     * @param string $prompt
     * @param $chat_id
     * @return Chat
     */
    public function chat(string $prompt, $chat_id = null): Chat
    {
        $chat = $chat_id ? Chat::find($chat_id) : new Chat();

        $this->chats()->attach([$chat->id]);

        return $chat->send($prompt);
    }
}
