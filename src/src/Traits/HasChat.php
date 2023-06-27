<?php

namespace Ogrre\ChatGPT\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Ogrre\ChatGPT\Resources\ChatResource;
use Ogrre\ChatGPT\ChatRegistrar;
use Ogrre\ChatGPT\Models\Message;
use Ogrre\ChatGPT\Models\Chat;

trait HasChat
{
    /**
     * @return MorphToMany
     */
    public function chats(): MorphToMany
    {
        return $this->morphToMany(Chat::class, "model", "model_has_chats");
    }

    /**
     * @return Chat
     */
    public function newChat(string $title = null, string $role = null): Chat
    {
        $chat = Chat::create(["title" => $title ?? "New Chat"]);
        $this->chats()->syncWithoutDetaching($chat);

        $first_message = new Message();
        $first_message->fill([
            "role" => "system",
            "content" => $role ?? "You are a helpful assistant"
        ]);

        $chat->messages()->save($first_message);

        return $chat;
    }

    /**
     * @param string $prompt
     * @param Chat $chat
     * @return ChatResource
     */
    public function chatgpt(string $prompt, Chat $chat)
    {
        $chat->gpt($prompt);

        return $chat->display();
    }
}
