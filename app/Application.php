<?php
namespace App;

use App\Core\Http\HttpStatusCode;
use App\Core\Http\Request;
use App\Core\Http\Response;


class Application
{
    static $app = null;
    /**
     * base path for app
     *
     * @var string
     */
    protected $basePath;

    function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * Processes Request
     *
     * @return void
     */
    public function run(Request $request)
    {
        // echo $_SERVER['REQUEST_URI'].PHP_EOL;
        // echo \urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $response = new Response();
        print_r(\getenv());
        return $response;
        
    }

    public static function initialize($basePath)
    {
        if (is_null(static::$app)){
            static::$app = new static($basePath);
        }
        return static::$app;
    }
}