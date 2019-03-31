<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Dingo\Api\Routing\Router;

$api = app(Router::class);

$api->version('v1', function ($api) {

    $api->group(['namespace' => 'App\Api\V1\Controllers'], function(Router $api) {

        $api->group(['prefix' => 'auth'], function (Router $api) {
            $api->post('login', 'LoginController@login');
        });

        $api->group(['middleware' => ['jwt.auth']], function (Router $api) {

            $api->group(['prefix' => 'messages'], function (Router $api) {
                $api->get('get', 'MessageController@get');
                $api->post('create', 'MessageController@create');
                $api->post('{id}/edit', 'MessageController@edit');
                $api->delete('{id}/delete', 'MessageController@delete');
            });

        });

    });

});