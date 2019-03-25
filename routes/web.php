<?php

use App\Core\Utils\Tokenizer;

$router->get('/', 'HomeController@index');
$router->get('/register', 'HomeController@register');
$router->post('/auth/register', 'AuthController@register');
$router->get('/forgot-password', 'HomeController@forgotPassword');
$router->post('/auth/forgot-password', 'AuthController@requestPasswordReset');
$router->get('/reset-password', 'HomeController@resetPassword');
$router->post('/auth/reset-password', 'AuthController@resetPassword');
$router->post('/auth/login', 'AuthController@login');
// $router->get('/dashboard', 'HomeController@dashboard');
$router->get('/dashboard', 'CountryController@index');
$router->get('/dashboard/users', 'UsersController@index');
$router->get('/dashboard/users/(\d+)', 'UsersController@edit');
$router->post('/dashboard/users/(\d+)/edit', 'UsersController@update');
$router->get('/api/v1/countries', 'CountryController@index');