<?php
return [

    'appKey' => env('APP_KEY'),

    'apiVersion' => env('API_VERSION'),

    'PAGINATION_SIZE' => env('PAGINATION_SIZE', 10),

    'ENCRYPT_KEY' => 'kZN2g9Tg6+mi1YNc+sSiZByJLhLAUVc=',
    'IV_KEY' => 'hello--interpay',

    'firebase' => [
        'firebase_id' => env('FIREBASE_ID'),
        'use_new_rtdb_uri' => env('FIREBASE_USE_NEW_RTDB_URI'),
        'service_account_json' => env('FIREBASE_SERVICE_ACCOUNT_JSON'),
    ],

]
?>
