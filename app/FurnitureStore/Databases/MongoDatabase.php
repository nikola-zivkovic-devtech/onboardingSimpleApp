<?php

namespace FurnitureStore\Databases;

use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;

/**
 * Class MongoDatabase
 *
 * MongoDB wrapper class
 */
class MongoDatabase
{
    private $manager;

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
        $manager = new Manager("mongodb://$this->host:$this->port");
        $this->manager = $manager;
    }

    public function getAll($itemType)
    {
        $query = new Query([]);
        $result = $this->manager->executeQuery('furniture.' . $itemType, $query);
        $result = $this->extractDataToArray($result);

        var_dump($result);
    }

    public function getOne($itemType, $id)
    {
        $query = new Query(['id' . $itemType => $id]);
        $result = $this->manager->executeQuery('furniture.' . $itemType, $query);
        $result = $this->extractDataToArray($result);

        var_dump($result);
    }


    private function extractDataToArray($rows)
    {
        $result = [];
        foreach ($rows as $row) {
            $result[] = $row;
        }
        return $result;
    }

}