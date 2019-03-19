<?php
namespace App;

class Application
{
    function __construct()
    {
        
    }
    public function run(){
        // echo $_SERVER['REQUEST_URI'].PHP_EOL;
        // echo \urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        echo phpinfo();
    }
}