<?php

return [

    /*
     * Authentication via request parameters.
     */
    'url_auth' => [
        'key' => env('URL_AUTH_KEY'),
        'value' => env('URL_AUTH_VALUE'),
        'values' => [
            //
        ],
    ],

    /*
     * Password for accessing something.
     */
    'access_password' => env('ACCESS_PASSWORD'),

];
