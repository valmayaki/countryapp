<?php
namespace App\Core\Http;
class Route
{
    public $path;
    public $method;
    public $controller;
    public $parameters = null;
    
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
        if (preg_match($pattern, $request->getPath(), $matches) &&  $this->method == $request->getMethod()){
            array_shift($matches);
            $this->setParameters($matches);
            return true;
        }else{
            return false;
        }
    }
    public function setParameters($matches)
    {
        $this->parameters = $matches;
    }
}
