<?php

namespace CSTruter\Service;

use CSTruter\Service\Results\IHttpResult,
	CSTruter\Service\Results\ErrorResult,
	CSTruter\Service\Exceptions\ServiceException;

	/**
 * Base Class for creating services
 *
 * This is the base class for creating new services, it manages a list of service
 * methods.
 *
 * @package CSTruter\Service
 * @author Christoff Truter <christoff@cstruter.com>
 * @copyright 2005-2015 CS Truter
 * @version 0.1.0
*/
abstract class ServiceBase
{
	protected $methods = [];
	protected $json;
	
	protected abstract function registerMethods();	
	
	public function __construct()
	{
		$this->registerMethods();
		try {
			$serviceMethod = $this->getServiceMethod();	
			$params = $serviceMethod->getParams($this);
			$result = call_user_func_array(array($this, $serviceMethod->getMethod()), $params);
			if (isset($result) && ($result instanceof IHttpResult)) {
				$result->render();
			}
		} 
		catch(\Exception $ex) {
			$result = new ErrorResult($ex->getMessage(), $ex->getCode());
			$result->render();
		}
	}

	public function getJson() {
		return $this->json;
	}
	
	protected function registerMethod($request_method, $method) {
		return $this->methods[$method] = new ServiceMethod($request_method, $method);
	}	
	
	private function getServiceMethod()
	{
		$json = file_get_contents("php://input");
		$this->json = json_decode($json, true);
		if (isset($_GET['method'])) {
			$method = $_GET['method'];
		} else if (isset($_POST['method'])) {
			$method = $_POST['method'];
		} else if ((isset($this->json)) && (isset($this->json['method']))) {
			$method = $this->json['method'];
		} else {
			throw new ServiceException('Method not specified', 400);
		}
		if (!isset($this->methods[$method]))
			throw new ServiceException('Method '.$method.' not found', 404);
		return $this->methods[$method];
	}	
}

?>