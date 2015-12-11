<?php

namespace CSTruter\Service;

use CSTruter\Service\Interfaces\ISecureService,
	CSTruter\Service\Exceptions\ServiceException;

/**
 * Service Method Class
 *
 * This class contains the definitions for retrieving the required arguments
 * to execute a service method.
 *
 * @package CSTruter\Service
 * @author Christoff Truter <christoff@cstruter.com>
 * @copyright 2005-2015 CS Truter
 * @version 0.1.0
*/
class ServiceMethod
{
	protected $verb;
	protected $method;
	protected $args = NULL;
	protected $requireValidation = false;
	protected $requireJson = false;
	
	public function __construct($verb, $method)
	{
		$this->verb = $verb;
		$this->method = $method;
	}
	
	public function requiredArguments() {
		$this->args = func_get_args();
		return $this;
	}
	
	public function requireValidation() {
		$this->requireValidation = true;
		return $this;
	}
	
	public function requireJson() {
		$this->requireJson = true;
		return $this;
	}
	
	public function getMethod() {
		return $this->method;
	}
	
	public function getParams(ServiceBase $service)
	{
		$this->validate($service);
		$params = [];
		if (isset($this->args)) {
			foreach($this->args as $arg) {
				if (isset($_GET[$arg])) {
					$params[] = $_GET[$arg];
				} else if (isset($_POST[$arg])) {
					$params[] = $_POST[$arg];
				} else {
					throw new ServiceException('Missing '.$arg.' parameter', 400);
				}
			}
		}
		if (!empty($service->getJson())) {
			$params[] = $service->getJson();
		}
		return $params;
	}
	
	private function validate($service)
	{
		if ($this->requireValidation) {
			if (!($service instanceof ISecureService)) {
				throw new ServiceException('ISecureService not implemented, but required for '.$this->method);
			}
			if (!$service->isValidated()) {
				throw new ServiceException('Access denied', 401);
			}
		}
		if ($this->requireJson) {
			if (empty($service->getJson())) {
				throw new ServiceException('Json request expected', 400);
			}
		}
		if ($_SERVER['REQUEST_METHOD'] != $this->verb) {
			throw new ServiceException('Invalid Verb '.$this->verb.' expected', 405);
		}
	}
}

?>