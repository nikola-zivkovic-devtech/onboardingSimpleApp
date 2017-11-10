<?php

namespace FurnitureStore\Exceptions;

/**
 * Class EmptyDataException
 *
 * Exception class
 * Thrown when no data is returned.
 */
class EmptyDataException extends \Exception
{
    public function __construct($message) {
        parent::__construct($message);
    }
}