<?php

namespace CSTruter\Service\Results;

/**
 * Json Result Class
 *
 * This class outputs whatever gets passed to it as JSON, along with its 
 * appropriate headers.
 *
 * @package CSTruter\Service\Results
 * @author Christoff Truter <christoff@cstruter.com>
 * @copyright 2005-2015 CS Truter
 * @version 0.1.0
*/
class JsonResult implements IHttpResult
{
	private $body;
	
	public function __construct($body) 
	{
		$this->body = $body;
	}
	
	public function render()
	{
		header('Content-Type: application/json');
		echo json_encode($this->body);
	}
}

?>