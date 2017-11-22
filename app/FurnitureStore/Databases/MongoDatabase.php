<?php

namespace FurnitureStore\Databases;

use FurnitureStore\Models\Response;
use MongoDB\Driver\BulkWrite;
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

    /**
     * Creates an item in mongo database
     *
     * @param $itemType
     * @param $newItem
     * @return string
     */
    public function create($itemType, $newItem)
    {
        $response = new Response();

        try {
            $request = new BulkWrite();

            $item = [
                'id' => $this->getIncrementedIdForCollection($this->dbName . '.' . $itemType),
                'name' => $newItem->name,
                'price' => $newItem->price,
                'colour' => $newItem->colour,
                'material' => $newItem->material,
                'size' => $newItem->size];

            $request->insert($item);
            $this->manager->executeBulkWrite($this->dbName . '.' . $itemType, $request);
            $response->message = ucfirst($itemType) . " successfully created.";
        } catch (Exception $e) {
            $response->handleException($e);
        }

        return $response;
    }

    /**
     * Delete an item from mongo database
     *
     * @param $itemType
     * @param $id
     * @return Response
     */
    public function delete($itemType, $id)
    {
        $response = new Response();

        try {
            $item = $this->getItemById($id, $this->dbName . '.' . $itemType);

            $request = new BulkWrite();
            $request->delete(['_id' => $item[0]->_id]);
            $response->data = $this->manager->executeBulkWrite($this->dbName . '.' . $itemType, $request);
            $response->message = ucfirst($itemType) . " successfully deleted.";
        } catch (Exception $e) {
            $response->handleException($e);
        }

        return $response;
    }

    /**
     * Updates an item in mongo database
     *
     * @param $itemType
     * @param $id
     * @param $updatedItem
     * @return string
     */
    public function update($itemType, $id, $updatedItem)
    {
        $response = new Response();

        try {
            $item = $this->getItemById($id, $this->dbName . '.' . $itemType);

            $request = new BulkWrite();

            $filter = ['_id' => $item[0]->_id];
            $object = ['$set' => [
                'name' => $updatedItem->name,
                'price' => $updatedItem->price,
                'colour' => $updatedItem->colour,
                'material' => $updatedItem->material,
                'size' => $updatedItem->size
            ]];

            $request->update($filter, $object, ['upsert' => false]);
            $this->manager->executeBulkWrite($this->dbName . '.' . $itemType, $request);
            $response->data = $updatedItem;
            $response->message = ucfirst($itemType) . " successfully updated.";
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

    /**
     * Gets the last id value from table and returns it incremented by 1
     *
     * @param $collection string
     */
    private function getIncrementedIdForCollection($collection)
    {
        $query = new Query([], ['sort' => ['id' => -1], 'limit' => 1]);
        $result = $this->manager->executeQuery($collection, $query);
        $result = $this->extractDataToArray($result);
        $item = $result[0];
        $last = $item->id;
        return $last + 1;
    }

    private function getItemById($id, $collection)
    {
        $query = new Query(['id' => $id]);
        $result = $this->manager->executeQuery($collection, $query);
        $result = $this->extractDataToArray($result);
        if (sizeof($result) < 1) {
            throw new \Exception("There are no items with id $id.");
        } else {
            return $result;
        }
    }

}