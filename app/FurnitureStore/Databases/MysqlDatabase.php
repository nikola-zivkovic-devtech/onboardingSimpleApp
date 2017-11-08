<?php

namespace FurnitureStore\Databases;

/**
 * Class MysqlDatabase
 *
 * MySQL wrapper class
 */
class MysqlDatabase
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

    public function getAll($query)
    {
        $result = $this->database->query($query);
        $rows = [];
        while($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        var_dump($rows);
    }

    public function getOne($query)
    {
        $result = $this->database->query($query)->fetch_assoc();
        var_dump($result);
    }

}