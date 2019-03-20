<?php

use App\Application;
/**
 * Autoloads classes base on their namespace
 *
 * @param string $class
 * @return void
 */
function autoload($class) {
    $class = str_replace('\\', '/', $class);
    if(substr($class, 0 , strlen('App')) == 'App'){

        include __DIR__.'/../'. str_replace('App/', 'app/', $class). '.php';
    }
}

spl_autoload_register('autoload');

define('BASE_PATH', __DIR__.'/../');
define('VIEW_PATH', __DIR__.'/../views');
define('APP_PATH', __DIR__.'/../app');

function parseEnvIniFile($file){
    $config = parse_ini_file($file);
    foreach($config as $key => $value){
        if (getenv($key) === false){
            putenv(sprintf('%s=%s', $key, $value));
        }
    }
}

$envFile = BASE_PATH.'.env.ini';

if (file_exists($envFile)){

    parseEnvIniFile($envFile);
}
$app = Application::initialize(__DIR__.'/../');

return $app;