<?php
namespace App;

use App\Core\Http\HttpStatusCode;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Http\Router;


class Application implements \ArrayAccess
{
    static $app = null;

    protected $container = [];
    /**
     * base path for app
     *
     * @var string
     */
    protected $basePath;

    function __construct($basePath)
    {
        $this->basePath = $basePath;
        $this->setUpRoutes();
        $this->setupConfig();
        $this->startSession();
    }
    public function setupConfig()
    {
        $config = [];
        foreach (glob(BASE_PATH ."/config/*.php") as $filename) {
            $name = pathinfo($filename, PATHINFO_FILENAME);
            $config[$name] = require $filename;
        }
        $this->set('config', $config);
    }
    public function startSession()
    {
        if ( ! session_id() ) @ session_start();
    }

    /**
     * Processes Request
     *
     * @return void
     */
    public function run(Request $request)
    {
        // echo \urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $response = new Response();
        $this->container['request'] = $request;
        $this->container['response'] = $response;
        /** @var \App\Core\Http\Route */
        $route = $this->get('router')->match($request);

        if (!is_null($route)){

            $args =[$request, $response];
            $controller  = $this->resolveController($route->controller);
            if ($route->parameters){
                array_push($args,...$route->parameters);
            }
            \call_user_func_array($controller, $args);
        }else{
            $response->render('404.php');
        }
        session_write_close();
        return $response;
        
    }

    public static function initialize($basePath)
    {
        if (is_null(static::$app)){
            static::$app = new static($basePath);
        }
        return static::$app;
    }

    public function setUpRoutes()
    {
        $router = new Router();
        $this->container['router'] = $router;
        foreach (glob(BASE_PATH ."/routes/*.php") as $filename) {
            require $filename;
        }
    }

    /**
     * Get an item from the container
     *
     * @param string $key
     * 
     * @return mixed
     */
    public function get($key)
    {
        if ($this->hasKey($key) &&  !is_null($this->container[$key])){
            if (is_callable($this->container[$key])){
                $this->container[$key] = $this->container[$key]($this);
                return $this->container[$key];
            }
            return $this->container[$key];
        }
        if (class_exists($key)){
            return $this->resolveClass($key);
        }
        throw new \Exception("Unable to find {$key} in Container");
    }

    /**
     * Set item into the container
     * 
     * @return void
     */
    public function set($key, $value)
    {
        $this->container[$key] = $value;
    }
    public function hasKey($key)
    {
        return array_key_exists($key, $this->container);
    }

    public function resolveClass($class)
    {
        return new $class;
    }
    
    /**
     * Resolve the controller and returns a callable
     *
     * @param string $controller
     * @return callable
     */
    public function resolveController($controller)
    {
        $controllerNamespace = '\App\Controllers\\';
        if(is_string($controller)){
            $controllerParts = explode('@', $controller);
            $class = $controllerNamespace.$controllerParts[0];
            if (class_exists($class)){

                return  [new $class($this), $controllerParts[1]];
            }
        }
        if(is_callable($controller)){
            return $controller;
        }
        throw new \InvalidArgumentException("the controller {$controller} does not exist");
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    static public function getInstance(){

        return static::$app;
    }
}