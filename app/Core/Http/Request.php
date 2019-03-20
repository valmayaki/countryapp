<?php

namespace App\Core\Http;

class Request
{
    protected $method;
    protected $body;
    protected $headers = [];
    protected $path;
    protected $query;
    protected $url;

    function __construct($method = 'GET', $path = '/', $body = '', $headers = [])
    {
        $this->method = $method;
        $this->body = $body;
        $this->headers = $headers;
        $this->path = $path;
    }
    
    static function capture()
    {
        $path = \urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $headers = [];
        foreach($_SERVER as $key => $value){
            if(strpos($key, 'HTTP_') === 0){
                $headers[strtolower(str_replace('HTTP_', '', $key))] = $value;
            }
        }
        $method = $headers['method'];
        $body = file_get_contents('php://input');
        return new static($method, $path, $body, $headers);
    }

    public function getHeader($name)
    {
        if (array_key_exists($name, $this->headers)){
            return $this->headers[$name];
        }
        return null;
    }
}