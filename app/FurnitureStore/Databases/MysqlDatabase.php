<?php

namespace FurnitureStore\Databases;

use FurnitureStore\Models\Response;

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
        $response = new Response();

        try{
            $db = new \mysqli($this->host, $this->username, $this->password, $this->dbName, $this->port);
            if ($db->connect_errno) {
                die($db->connect_error);
            }
            $this->database = $db;
        } catch (\Exception $e) {
            $response->handleException($e);
        }
    }

    /**
     * Queries a MySQL database for all items of a given type
     *
     * @param $itemType
     * @return Response
     */
    public function getAll($itemType)
    {
        $response = new Response();

        try{
            $query = "SELECT * FROM " . $itemType;
            $rows = $this->database->query($query);
            $result = [];
            while($row = $rows->fetch_assoc()) {
                $result[] = $row;
            }
            $response->data = $result;
        } catch (\Exception $e) {
            $response->handleException($e);
        }

        return $response;
    }

    /**
     * Queries a MySQL database for an item of a given type that matches a given id
     *
     * @param $itemType
     * @param $id
     * @return Response
     */
    public function getOne($itemType, $id)
    {
        $response = new Response();

        try{
            $query = "SELECT * FROM " . $itemType . " WHERE id" . $itemType . " = " . $id;
            $result = $this->database->query($query)->fetch_assoc();
            $response->data = $result;
        } catch (\Exception $e) {
            $response->handleException($e);
        }

        return $response;
    }

}