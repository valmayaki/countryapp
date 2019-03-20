<?php

class Route
{
    public $path;
    public $method;
    public $controller;
    
    function __construct($method, $path, $controller)
    {
        $this->method = $method;
        $this->path = $path;
        $this->controller = $controller;
    }
}
