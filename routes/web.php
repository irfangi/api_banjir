<?php

/*
|--------------------------------------------------------------------------
| routerlication Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an routerlication.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->router->version();
});
$router->get('/list_status', function() {
    return str_random(32);
});


$router->get('api/get_lokasi/{id}', 'ApiController@get_lokasi');
$router->get('api/get_grafik/{id}', 'ApiController@get_grafik');
$router->get('api/get_status', 'ApiController@get_status');
$router->get('api/get_lokasi_status', 'ApiController@get_lokasi_status');
$router->get('api/get_lokasi_status/{id}', 'ApiController@get_lokasi_status_by_id');