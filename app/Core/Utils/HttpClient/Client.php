<?php

namespace App\Core\Utils\HttpClient;
use Exception;
use App\Core\Utils\HttpClient\HttpException;
use App\Core\Utils\HttpClient\HttpInterface;
/**
* Http Client for registrars
*/
class Client implements HttpInterface
{
    /**
     * @var array
     */
    protected $content_types =
        array(
           'form_params' => 'application/x-www-form-urlencoded',
           'json' => 'application/json',
           'multipart' => 'multipart/form-data',
    );

	protected $base_url;

    /**
     * @var array
     */
    protected $request =
        array(
            'method' => 'get',
            'body' => null,
            'headers' => array(),
            'uri' => '',
     );
    public $status_code = 0;
    public $response_info = array();

    public static $http_methods = array(
        'POST',
        'PUT',
        'GET',
        'DELETE',
        'CONNECT',
        'PATCH',
    );

    /**
     * @var array
     */
    protected $response = array();
	
	function __construct(array $options = array())
	{
		if (array_key_exists('base_url', $options)){
			$this->set_base_url($options['base_url']);
		}
	}

    /**
     * @param $method
     * @param $uri
     * @param array $parameters
     *
     * @return string
     *
     * @throws HttpException
     */
	public function request($method, $uri, array $parameters = array())
	{
        $defaults = array(
            'body' => array(),
            'headers' => array(),
        );
        $parameters = array_replace($defaults, $parameters);
		$this->set_body($parameters['body']);
		$this->setHeaders($parameters['headers']);
		$this->set_method($method);
		$this->request['uri'] = $this->get_uri($uri);
        $response = $this->execute($this->request);
        // @todo remove log
//		die(var_dump( "Request\n", $this->request, "\n Radix Response\n", $response));
		$this->response['content'] = $response;

        return $response;
	}

    /**
     * Retrieves the full uri for request
     *
     * @param $uri
     *
     * @return string
     */
	private function get_uri($uri)
	{
		if(strpos($uri, 'http') === false){

			return $this->get_base_uri().$this->sanitize($uri);
		}
		return trim($uri);
	}

    /**
     * Retrieves the base uri
     *
     * @return mixed
     */
	public function get_base_uri()
	{
		return $this->base_url;
	}

    /**
     * Prefixes the uri endpoint with slash
     *
     * @param $uri
     * @return string
     */
	private function sanitize($uri)
	{
		if($uri[0] == '/'){
			return $uri;
		}
		return '/'.$uri;
	}

    /**
     * Sets request body
     *
     * @param $parameters
     * @return string
     */
    private function set_body($parameters)
    {
        if (array_key_exists('form_params', $parameters)){
            $this->request['body'] = http_build_query($parameters['form_params']);
            $content_type = 'form_params';
            $this->request['headers']['Content-Type'] = $this->content_types[$content_type];
        }
        else if(array_key_exists('json', $parameters)){
            $this->request['body'] = json_encode($parameters['json']);
            $content_type = 'json';
            $this->request['headers']['Content-Type'] = $this->content_types[$content_type];
        }else if(array_key_exists('multipart', $parameters)){
            $this->request['headers']['Content-Type'] = $this->content_types['multipart'];
            $this->request['body'] = ($parameters['multipart']);
        }
    }

    public function execute($request)
    {

    	try{
			$connection = curl_init();

			$out = fopen(dirname(__FILE__).'/errorlog.txt', 'w');


			$options =array(
                CURLOPT_RETURNTRANSFER  => 1,
                CURLOPT_URL             => $this->get_uri($request['uri']),
                CURLOPT_VERBOSE         => true,
                CURLOPT_STDERR          => $out,
                CURLINFO_HEADER_OUT     => true,
			);
			if (isset($request['headers']) && !empty($request['headers'])){
				$headers = array();
				foreach ($request['headers'] as $key => $value) {
					$headers[] = sprintf("%s: %s", $key, $value);
				}
                if(!empty($headers)){
                    $options[CURLOPT_HTTPHEADER] = $headers;
                }
			}
			if (in_array(strtoupper($request['method']), static::$http_methods)){
				$options[CURLOPT_CUSTOMREQUEST] = strtoupper($request['method']);

			}
            if(isset($request['body']) && !empty($request['body'])){

                $options[CURLOPT_POSTFIELDS] = $request['body'];
            }
			curl_setopt_array($connection, $options);
            $response = curl_exec($connection);
            $this->response_info = curl_getinfo($connection);
            if($response === false){
                error_log('Error: "' . curl_error($connection) . '" - Code: ' . curl_errno($connection));
            }
            fclose($out);
			curl_close($connection);

			return $response;
		}catch(\Exception $e){
            error_log($e);
		}
    }

    /**
     * Sets request headers
     *
     * @param $headers
     * @return mixed
     */
    private function setHeaders($headers)
    {
        $headers = array_merge($this->request['headers'], $headers);
        $this->request['headers'] = $headers;
        return $headers;
    }

    public function get_request()
    {
        return $this->request;
    }

    public function set_method($method)
    {
        $this->request['method'] = $method;
    }

    public function set_base_url($uri)
    {
        $this->base_url = $uri;
    }

    function __call($name, $arguments)
    {
        if (in_array(strtolower($name), array('get', 'post', 'patch','delete'))){
            array_unshift($arguments, $name );
            return call_user_func_array (array($this, 'request'), $arguments);
        }
    }
}