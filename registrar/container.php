<?php

use App\Core\Database\MysqlConnector;
use App\Core\Utils\Fluent;

$app->set('database', function($container){
    $config = $container->get('config');
    $defaultDriver = $config['database']['default'];
    $data = $config['database']['drivers'][$defaultDriver];
    $username = $data['username'];
    $host = $data['host'];
    $password = $data['password'];
    $port = $data['port'];
    $database = $data['database'];
    $options = $data['options'];
    $connector = MysqlConnector::getInstance($username, $password,$database, $host, $port, $options);
    $connector->getConnection()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connector;
});
// $app->set('session', function($container){
//     return new Fluent($_SESSION);
// });

$app->set('view_path', BASE_PATH. 'views' );