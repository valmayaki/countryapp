<?php

use App\Application;


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

$app = new Application(__DIR__.'/../');
function include_view($string){
    include app()->get('view_path'). '/' . $string;
}
function app(){
    return Application::getInstance();
}
require_once BASE_PATH.'/registrar/container.php';

return $app;