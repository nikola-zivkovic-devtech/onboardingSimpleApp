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
    /*public function __construct($errorObject)
    {
        $exceptionClassName = $this->getExceptionClassName($errorObject);
        echo $exceptionClassName, ": ", $errorObject->getMessage(), "<br>";
        //echo "In file: ", $errorObject->getFile(), ", line: ", $errorObject->getLine(), "<br>";
    }

    private function getExceptionClassName($errorObject)
    {
        $classFullName = get_class($errorObject);
        $array = array_reverse(explode('\\', $classFullName));
        return $array[0];
    }*/

    public static function say(\Exception $e) {
        echo $e->getMessage();
    }
}