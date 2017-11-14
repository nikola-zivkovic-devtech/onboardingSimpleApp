<?php

namespace FurnitureStore\Databases;

use FurnitureStore\Exceptions\DatabaseException;
use FurnitureStore\Exceptions\EmptyDataException;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;

/**
 * Class MongoDatabase
 * MongoDB wrapper class
 *
 * @property $database   Database instance.
 * @property $host, $dbName, $username, $password, $port, $type   Database data
 */
class MongoDatabase implements IDatabaseHandler
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


    /**
     * Connects to a Mongo database
     */
    public function connect()
    {
        $manager = new Manager("mongodb://$this->host:$this->port");
        $this->manager = $manager;
    }

    /**
     * Queries a Mongo database for all items of a given type
     *
     * @param $itemType
     * @throws DatabaseException
     * @throws EmptyDataException
     */
    public function getAll($itemType)
    {
        try{
            $query = new Query([]);
            $result = $this->manager->executeQuery('furniture.' . $itemType, $query);
            $result = $this->extractDataToArray($result);

            if (!$result) {
                throw new EmptyDataException('No ' . $itemType . 's found.');
            }

            var_dump($result);
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Queries a Mongo database for an item of a given type that matches a given id
     *
     * @param $itemType
     * @param $id
     * @throws DatabaseException
     * @throws EmptyDataException
     */
    public function getOne($itemType, $id)
    {
        try {
            $query = new Query(['id' . $itemType => $id]);
            $result = $this->manager->executeQuery('furniture.' . $itemType, $query);
            $result = $this->extractDataToArray($result);

            if (!$result) {
                throw new EmptyDataException('No ' . $itemType . ' with id ' . $id . '.');
            }

            var_dump($result);
        } catch (Exception $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode());
        }
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