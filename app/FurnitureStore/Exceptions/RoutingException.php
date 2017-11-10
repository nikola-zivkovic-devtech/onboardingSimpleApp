<?php
/**
 * Created by PhpStorm.
 * User: nikola.zivkovic
 * Date: 10-Nov-17
 * Time: 14:13
 */

namespace FurnitureStore\Exceptions;

/**
 * Class RoutingException
 *
 * Exception class
 * Thrown when there is a routing related issue
 */
class RoutingException extends \Exception
{
    public function __construct($message) {
        parent::__construct($message);
    }
}