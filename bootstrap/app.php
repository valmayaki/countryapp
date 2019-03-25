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
    if(file_exists($file)) {

        $config = parse_ini_file($file);
        foreach($config as $key => $value){
            if (getenv($key) === false){
                putenv(sprintf('%s=%s', $key, $value));
            }
        }

    }else {
        throw new InvalidArgumentException("{$file} does not exists");
    }
}

parseEnvIniFile(BASE_PATH.'.env.ini');

$app = Application::initialize(__DIR__.'/../');
function include_view($string){
    include app()->get('view_path'). '/' . $string;
}
function app(){
    return Application::getInstance();
}
require_once BASE_PATH.'/registrar/container.php';

return $app;