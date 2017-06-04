<?php

return [

    /*
     * Keys for API Responses.
     */
    'response' => [
        'key' => [
            'code' => 'code',
            'message' => 'msg',
        ],
        'code' => [
            'success' => 1,
        ],
    ],

    /*
     * The valid duration before the token expires.
     * You may set a larger number in the local environment to facilitate debugging.
     */
    'token_duration' => env('API_TOKEN_DURATION', 180),

    /*
     * All api clients that can make requests to this app's APIs.
     * The first one is this app itself, see `Api::defaultAppKey()`.
     *
     * 'app-key' => [
     *      'name' => 'app-name',
     *      'secret' => 'app-secret',
     *  ],
     *
     */
    'clients' => [
        'app-key' => [
            'name' => 'app-name',
            'secret' => 'app-secret',
        ],
    ],

];
