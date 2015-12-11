<?php

namespace CSTruter\Service\Interfaces;

/**
 * Secure Service Interface
 *
 * This interface defines which methods a service class needs to implement
 * in order to be used as part of a secure/authenticated system.
 *
 * @package CSTruter\Service\Interfaces
 * @author Christoff Truter <christoff@cstruter.com>
 * @copyright 2005-2015 CS Truter
 * @version 0.1.0
*/
interface ISecureService
{
	function validate();
	function isValidated();
}

?>