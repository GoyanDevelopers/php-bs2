<?php

return [
    'server' => env('BS2_SERVER', "https://apihmz.bancobonsucesso.com.br"),

    'api_key' => env('BS2_API_KEY', ""),

    'api_secret' => env('BS2_API_SECRET', ""),

    'scope' => env('BS2_SCOPE', "saldo extrato pagamento transferencia boleto cobv.write cobv.read cob.write cob.read pix.write pix.read dict.write dict.read pix.write pix.read pix.write pix.read pix.write pix.read pix.write pix.read webhook.read webhook.write"),

    'database_connection' => env('BS2_DB_CONNECTION', env('DB_CONNECTION', "mysql")),
];
