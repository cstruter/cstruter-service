<?php

namespace CSTruter\Service\Exceptions;

/**
 * Service Exception
 *
 * The exception that must be thrown whenever service related exceptions occur.
 *
 * @package CSTruter\Service\Exceptions
 * @author Christoff Truter <christoff@cstruter.com>
 * @copyright 2005-2015 CS Truter
 * @version 0.1.0
*/
class ServiceException extends \Exception
{
    public function __construct($message, $code = 500, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}

?>