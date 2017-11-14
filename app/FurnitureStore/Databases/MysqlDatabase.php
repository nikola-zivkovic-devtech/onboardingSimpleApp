<?php

namespace FurnitureStore\Databases;

/**
 * Class MysqlDatabase
 *
 * MySQL wrapper class
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


    public function connect()
    {
        $db = new \mysqli($this->host, $this->username, $this->password, $this->dbName, $this->port);
        //var_dump($db);
        if ($db->connect_errno) {
            die($db->connect_error);
        }

        $this->database = $db;
    }

    public function getAll($itemType)
    {
        $query = "SELECT * FROM " . $itemType;
        $rows = $this->database->query($query);
        $result = [];
        while($row = $rows->fetch_assoc()) {
            $result[] = $row;
        }
        var_dump($result);
    }

    public function getOne($itemType, $id)
    {
        $query = "SELECT * FROM " . $itemType . " WHERE id" . $itemType . " = " . $id;
        $result = $this->database->query($query)->fetch_assoc();
        var_dump($result);
    }

}