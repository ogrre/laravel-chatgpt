<?php

return [

    'openai' => [

        /*
         *
         */

        'model' => env('OPENAI_MODEL', 'gpt-3.5-turbo')
    ],

    'models' => [

        /*
         *
         */

        'chat' => Ogrre\ChatGPT\Models\Chat::class,

        /*
         *
         */

        'message' => Ogrre\ChatGPT\Models\Message::class,
    ],

    'secrets' => [

        /*
         *
         */

        'api_key' => env('OPENAI_API_KEY'),

        /*
         *
         */

        'organization' => env('OPENAI_ORGANIZATION'),
    ],
];
