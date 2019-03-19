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

$app = new Application();

return $app;