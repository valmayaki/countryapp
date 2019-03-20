<?php

namespace App\Core\Http;

class Request
{
    protected $method;
    protected $body;
    protected $headers = [];
    protected $path;
    protected $query;
    protected $queryString;
    protected $url;
    protected $host;
    protected $schema = 'http';
    protected $fragments;


    function __construct($method = 'GET', $uri = 'http://localhost/', $body = '', $headers = [], $options = [])
    {
        $uriParts = parse_url($uri);
        $this->method = $method;
        $this->body = $body;
        $this->headers = $headers;
        $this->path = isset($uriParts['path']) ? $uriParts['path']: '/';
        $this->queryString = isset($uriParts['query'])? $uriParts['query']: '';
        $this->host = isset($options['host'])? : isset($uriParts['host']) ? $uriParts['host']: '';
        $this->fragments = isset($options['fragment'])? : isset($uriParts['fragment']) ? $uriParts['fragment']: '';
    }

    static function capture()
    {
        $path = \urldecode($_SERVER['REQUEST_URI']);
        $headers = [];
        foreach($_SERVER as $key => $value){
            if(strpos($key, 'HTTP_') === 0){
                $headers[strtolower(str_replace('HTTP_', '', $key))] = $value;
            }
        }
        $method = $_SERVER['REQUEST_METHOD'];
        if (array_key_exists('x-http-method-override', $headers)){
            $method = $headers['x-http-method-override'];
        }
        $body = file_get_contents('php://input');
        $request  = new static($method, $path, $body, $headers);
        return $request;
    }

    public function getHeader($name)
    {
        if (array_key_exists($name, $this->headers)){
            return $this->headers[$name];
        }
        return null;
    }
    public function getPath()
    {
        return $this->path;
    }
    public function getQuerys()
    {
        parse_str($this->queryString, $querys);
        return $querys;
    }
    public function getQuery($key)
    {
       return isset($this->getQuerys()[$key]) ? $this->getQuerys()[$key]: null;
    }
    
    public function getMethod()
    {
        return $this->method;
    }
}