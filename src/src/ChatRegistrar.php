<?php

namespace Ogrre\ChatGPT;

use Ogrre\ChatGPT\Models\Chat;

class ChatRegistrar
{
    protected string $chatClass;

    public function __construct(){

        $this->chatClass = config('chatgpt.models.chat');
    }

    /**
     * @return Chat
     */
    public function getChatClass(): Chat
    {
        return app($this->chatClass);
    }
}
