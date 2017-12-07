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

$router->get('/', 'HomeController@index');

$router->group(['prefix' => 'api', 'namespace' => 'Api'], function () use ($router) {
    $router->get('version', function () use ($router) {
        return api(['version' => $router->app->version()]);
    });

    $router->group(['middleware' => 'api.token'], function () use ($router) {
        $router->addRoute(['GET', 'POST'], 'token/refresh', 'ApiTokenController@refreshToken');
    });
});
