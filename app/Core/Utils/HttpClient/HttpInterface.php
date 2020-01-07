<?php
namespace  App\Core\Utils\HttpClient;

/**
* Interface for Http client
*/
interface HttpInterface
{
	
	public function request($method, $uri, array $parameters = array());
	public function set_base_url($uri);
}