<?php

require_once __DIR__ . '/env.php';
require_once __DIR__ . '/vendor/autoload.php';

use App\Http\Router;

$router = new Router();

$router->get('/users', 'UserController@index');
$router->get('/users/{id}', 'UserController@show');
$router->post('/users/create', 'UserController@create');
$router->delete('/users/{id}', 'UserController@delete');
$router->put('/users/{id}/update', 'UserController@update');
$router->resolve();
