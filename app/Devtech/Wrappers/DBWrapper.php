<?php
/**
 * Created by PhpStorm.
 * User: nikola.zivkovic
 * Date: 06-Nov-17
 * Time: 11:52
 */

namespace Devtech\Wrappers;

/**
 * Class DBWrapper
 *
 * Database wrapper class that wraps the actual database classes.
 */
class DBWrapper
{
    private $database;

    public function __construct($database)
    {
        $class = $database . "Database";
        $this->database = new $class();
    }

    public function find($query)
    {
        $this->database->find($query);
    }

    public function write($query)
    {
        $this->database->write($query);
    }

    public function delete($message)
    {
        $this->database->delete($message);
    }
}