<?php

require_once __DIR__ . '/env.php';
require_once __DIR__ . '/vendor/autoload.php';

use App\Http\Router;

$router = new Router();

// Rotas para o CRUD de usuários
$router->get('/users', 'UserController@index');
$router->get('/users/{id}', 'UserController@show');
$router->post('/users/create', 'UserController@create');
$router->delete('/users/{id}/delete', 'UserController@delete');
$router->put('/users/{id}/update', 'UserController@update');

// Rotas para o CRUD de endereços
$router->get('/address', 'AddressController@index');
$router->get('/address/{id}', 'AddressController@show');
$router->post('/address/create', 'AddressController@create');
$router->delete('/address/{id}/delete', 'AddressController@delete');
$router->put('/address/{id}/update', 'AddressController@update');


$router->resolve();
