<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', 'HomeController@index');

$app->group(['prefix' => 'api', 'namespace' => 'Api'], function () use ($app) {
    $app->get('version', function () use ($app) {
        return api(['version' => $app->version()]);
    });

    $app->group(['middleware' => 'api.token'], function () use ($app) {
        $app->addRoute(['GET', 'POST'], 'token/refresh', 'ApiTokenController@refreshToken');
    });
});
