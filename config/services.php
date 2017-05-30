<?php

return [

    /*
     * Google Analytics
     * https://www.google.com/analytics
     */
    'google_analytics' => [
        // 'UA-xxxxxxxx-x'
        'id' => env('GOOGLE_ANALYTICS_ID'),
        // 'auto', 'none', 'example.com'
        'cookie_domain' => env('GOOGLE_ANALYTICS_COOKIE_DOMAIN', 'auto'),
    ],

];
