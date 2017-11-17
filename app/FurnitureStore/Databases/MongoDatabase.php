<?php

namespace FurnitureStore\Databases;

use FurnitureStore\Models\Response;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;

/**
 * Class MongoDatabase
 * MongoDB wrapper class
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
        $response = new Response();

        try {
            $manager = new Manager("mongodb://$this->host:$this->port");
            $this->manager = $manager;
        } catch (\Exception $e) {
            $response->handleException($e);
        }
    }

    /**
     * Queries a Mongo database for all items of a given type
     *
     * @param $itemType
     * @return Response
     */
    public function getAll($itemType)
    {
        $response = new Response();

        try{
            $query = new Query([]);
            $result = $this->manager->executeQuery($this->dbName . '.' . $itemType, $query);
            $response->data = $this->extractDataToArray($result);
        } catch (Exception $e) {
            $response->handleException($e);
        }

        return $response;
    }

    /**
     * Queries a Mongo database for an item of a given type that matches a given id
     *
     * @param $itemType
     * @param $id
     * @return Response
     */
    public function getOne($itemType, $id)
    {
        $response = new Response();

        try {
            $query = new Query(['id' => $id]);
            $result = $this->manager->executeQuery($this->dbName . '.' . $itemType, $query);
            $response->data = $this->extractDataToArray($result);
        } catch (Exception $e) {
            $response->handleException($e);
        }

        return $response;
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