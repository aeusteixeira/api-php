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

// Rotas para o CRUD de cidades
$router->get('/cities', 'CityController@index');
$router->get('/cities/{id}', 'CityController@show');
$router->post('/cities/create', 'CityController@create');
$router->delete('/cities/{id}/delete', 'CityController@delete');
$router->put('/cities/{id}/update', 'CityController@update');

// Rotas para o CRUD de estados
$router->get('/states', 'StateController@index');
$router->get('/states/{id}', 'StateController@show');
$router->post('/states/create', 'StateController@create');
$router->delete('/states/{id}/delete', 'StateController@delete');
$router->put('/states/{id}/update', 'StateController@update');

$router->resolve();
