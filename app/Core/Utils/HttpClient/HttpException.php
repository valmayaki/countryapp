<?php

namespace App\Utils\HttpClients;

use Exception;

/**
* Http Exception
* 
*/
class HttpException extends Exception
{
	public $status_code;

	public $headers;
	
	public $body;

	function __construct($message, $status_code, $body = '', $headers = array() )
	{
		parent::construct($message);
		$this->status_code = $status_code;
		$this->body = $body;
		$this->headers = $headers;
	}
}