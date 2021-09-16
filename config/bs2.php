<?php

return [
    'server' => env('BS2_SERVER', 'https://apihmz.bancobonsucesso.com.br'),

    'api_key' => env('BS2_API_KEY', ''),

    'api_secret' => env('BS2_API_SECRET', ''),

    'database_connection' => env('BS2_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
];
