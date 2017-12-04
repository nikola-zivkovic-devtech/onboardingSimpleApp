<?php
/**
 * Created by PhpStorm.
 * User: nikola.zivkovic
 * Date: 10-Nov-17
 * Time: 11:01
 */

namespace FurnitureStore\Exceptions;

/**
 * Class ErrorOutput
 *
 * Outputs the error message.
 */
class ErrorOutput
{
    public static function say(\Exception $e) {
        echo $e->getMessage();
    }
}