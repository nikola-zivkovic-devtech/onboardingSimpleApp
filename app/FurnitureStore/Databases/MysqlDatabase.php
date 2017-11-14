<?php

namespace FurnitureStore\Databases;

use FurnitureStore\Exceptions\DatabaseException;
use FurnitureStore\Exceptions\EmptyDataException;
use MongoDB\Driver\Exception\Exception;

/**
 * Class MysqlDatabase
 * MySQL wrapper class
 *
 * @property $database   Database instance.
 * @property $host, $dbName, $username, $password, $port, $type   Database data
 */
class MysqlDatabase implements IDatabaseHandler
{
    private $database;

    private $host;
    private $dbName;
    private $username;
    private $password;
    private $port;
    private $type;

    public function __construct($dbData)
    {
        $this->host = $dbData['host'];
        $this->dbName = $dbData['dbname'];
        $this->username = $dbData['username'];
        $this->password = $dbData['password'];
        $this->port = $dbData['port'];
        $this->type = $dbData['type'];
    }


    /**
     * Connects to a MySQL database
     */
    public function connect()
    {
        $db = new \mysqli($this->host, $this->username, $this->password, $this->dbName, $this->port);
        if ($db->connect_errno) {
            die($db->connect_error);
        }
        $this->database = $db;
    }

    /**
     * Queries a MySQL database for all items of a given type
     *
     * @param $itemType
     * @throws DatabaseException
     * @throws EmptyDataException
     */
    public function getAll($itemType)
    {
        try{
            $query = "SELECT * FROM " . $itemType;
            $rows = $this->database->query($query);
            $result = [];
            while($row = $rows->fetch_assoc()) {
                $result[] = $row;
            }

            if (!$result) {
                throw new EmptyDataException('No ' . $itemType . 's found.');
            }

            var_dump($result);
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Queries a MySQL database for an item of a given type that matches a given id
     *
     * @param $itemType
     * @param $id
     * @throws DatabaseException
     * @throws EmptyDataException
     */
    public function getOne($itemType, $id)
    {
        try{
            $query = "SELECT * FROM " . $itemType . " WHERE id" . $itemType . " = " . $id;
            $result = $this->database->query($query)->fetch_assoc();

            if (!$result) {
                throw new EmptyDataException('No ' . $itemType . ' with id ' . $id . '.');
            }

            var_dump($result);
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode());
        }
    }

}