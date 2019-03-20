<?php
namespace App\Core\Http;

use App\Core\Http\Route;
use App\Core\Http\Request;

class Router
{
    protected $methods = [
        'POST',
        'GET',
        'DELETE',
        'PUT',
        'PATCH',
        'OPTIONS'
    ];
    protected $routes = [];
    
    function __construct()
    {
        
    }
    public function register(Route $route)
    {
        $this->routes[] = $route;
    }

    function __call($method, $arguments)
    {
        if (in_array(strtoupper($method), $this->methods)){
            return $this->register(new Route($method, ...$arguments));
        }
        throw new \BadFunctionCallException("Method {$method} doesn't exist in class ". __CLASS__);
    }

    public function match(Request$request)
    {
        foreach($this->routes as $route){
            if ($route->match($request)){
                return $route;
            }
        }
        return null;
    }
}
