<?php
namespace App\Core\Http;

class Router
{
    protected $route = [];
    
    function __construct()
    {
        
    }
    public function register(Route $route)
    {
        $this->routes[] = $route;
    }
}
