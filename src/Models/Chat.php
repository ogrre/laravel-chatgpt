<?php

namespace Ogrre\ChatGPT\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use OpenAI;

class Chat extends Model
{
    public mixed $client;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->client = OpenAI::client(config('openai.api_key'));
    }

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
    ];

    /**
     * @var string
     */
    protected $table = 'chats';

    /**
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * @param string $prompt
     * @return $this
     */
    public function send(string $prompt): static
    {
        $messages = $this->messages();

        $user_message = new Message();
        $user_message->fill([
            "role" => "user",
            "content" => $prompt,
        ]);
        $messages->save($user_message);

        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages,
        ]);

        $assistant_message = new Message();
        $assistant_message->fill([
            "role" => "assistant",
            "content" => $response->choices[0]->message->content,

        ]);
        $messages->save($assistant_message);

        return $this;
    }
}
