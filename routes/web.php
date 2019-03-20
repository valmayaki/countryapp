<?php

$router->get('/', 'HomeController@index');
$router->post('/auth/login', 'AuthController@login');
$router->get('/dashboard', 'HomeController@dashboard');