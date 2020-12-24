<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/api/rooms', 'RoomsController@listRooms');
$router->get('/api/rooms/{slug}', 'RoomsController@getRoom');
$router->post('/api/rooms/{slug}', 'RoomsController@saveRoom');
$router->post('/api/rooms', 'RoomsController@createRoom');

$router->post('/api/rooms/{slug}/record', 'TemperatureController@addReading');
