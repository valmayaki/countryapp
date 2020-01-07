<?php
namespace App\Core\Utils\HttpClient;

/**
* Response Object for Http
* 
*/
class Response
{
	protected $status_code;
	protected $headers;

	protected $body = null;
	
	function __construct($body, $headers = array())
	{
		# code...
	}
	public function toArray()
	{
		return json_decode($this->body);
	}
}