<?php
return [
    'kyivID' => [
        'client_id' => env('KYIV_ID_CLIENT'),
        'client_secret' => env('KYIV_ID_SECRET'),
        'redirect' => env('KYIV_ID_REDIRECT_URI'),
        'attempt' => env('KYIV_ID_ATTEMPT_URI'),
        'host' => env('KYIV_ID_HOST'),
        'host_api' => env('KYIV_ID_HOST_API'),
        'force_login' => env('KYIV_ID_FORCE_LOGIN_URI'),
        'logout' => env('KYIV_ID_LOGOUT_URI'),
        'create_order_endpoint' => env('KYIV_ID_CREATE_ORDER'),
    ],
];