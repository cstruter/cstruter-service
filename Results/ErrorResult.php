<?php

namespace CSTruter\Service\Results;

/**
 * Error Result Class
 *
 * This class is used for outputting error messages along with their
 * appropriate HTTP error codes.
 *
 * @package CSTruter\Service\Results
 * @author Christoff Truter <christoff@cstruter.com>
 * @copyright 2005-2015 CS Truter
 * @version 0.1.0
*/
class ErrorResult implements IHttpResult
{
	private $statusCode;
	private $message;
	
	public function __construct($message, $statusCode = NULL) {
		$this->statusCode = $statusCode;
		$this->message = $message;
	}
	
	public function render()
	{
		switch ($this->statusCode) {
			case 400:
				header('HTTP/1.1 400 Bad Request');
			break;
			case 401:
				header('HTTP/1.0 401 Unauthorized');
			break;
			case 404:
				header("HTTP/1.0 404 Not Found");
			break;
			case 405:
				header("HTTP/1.0 405 Method Not Allowed");
			break;			
			default:
				header("HTTP/1.0 500 Internal Server Error");
			break;
		}
		die($this->message);
	}
}

?>