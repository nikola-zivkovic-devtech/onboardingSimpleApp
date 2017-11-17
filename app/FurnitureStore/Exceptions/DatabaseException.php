<?php

namespace FurnitureStore\Exceptions;

/**
 * Class DatabaseException
 *
 * Exception class
 * Thrown when there is an issue with communicating with a database.
 */
class DatabaseException extends \Exception
{
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}