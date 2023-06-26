<?php

namespace Ogrre\ChatGPT;

use Ogrre\ChatGPT\Models\Chat;

class ChatRegistrar
{
    protected string $chatClass;

    public function __construct(){

        $this->chatClass = config('chat.models.chat');
    }

    /**
     * @return Chat
     */
    public function getChatClass(): Chat
    {
        return app($this->chatClass);
    }
}
