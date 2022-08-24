<?php

return [
    'bot' => [
        'name' => env('TELEGRAM_NAME_BOT', ''),
        'api-key' => env('TELEGRAM_API_BOT', ''),
    ],
    'chat-log' => env('TELEGRAM_CHAT_ID', ''),
];
