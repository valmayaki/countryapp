<?php
namespace App\Core\Http;
class Route
{
    public $path;
    public $method;
    public $controller;
    
    function __construct($method, $path, $controller)
    {
        $this->method = strtoupper($method);
        $this->path = $path;
        $this->controller = $controller;
    }
    public function match(Request $request)
    {
        // $pattern = str_replace('/', '//', $request->getPath());
        $pattern = '~^'.$this->path;
        // print_r($pattern);
        if($this->path[strlen($this->path) - 1] !== '/'){
            $pattern .= '/';
        }
        $pattern .= '?$~';
        return preg_match($pattern, $request->getPath()) &&  $this->method == $request->getMethod();
    }
}
