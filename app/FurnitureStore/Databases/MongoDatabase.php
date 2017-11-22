<?php

namespace FurnitureStore\Databases;

use FurnitureStore\Logger\ILogger;
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
    private $logger;
    private $host;
    private $dbName;
    private $username;
    private $password;
    private $port;
    private $type;

    public function __construct($dbData, ILogger $logger)
    {
        $this->host = $dbData['host'];
        $this->dbName = $dbData['dbname'];
        $this->username = $dbData['username'];
        $this->password = $dbData['password'];
        $this->port = $dbData['port'];
        $this->type = $dbData['type'];

        $this->logger = $logger;
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
            $this->logger->info("Connected to MongoDB database.");
        } catch (\Exception $e) {
            $response->handleException($e);
            $this->logger->error("Connection to MongoDB database failed.");
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
            $this->logger->info("MongoDB - retrieved all $itemType" . "s.");
        } catch (Exception $e) {
            $response->handleException($e);
            $this->logger->error("MongoDB - retrieving of all $itemType" . "s failed.");
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
            $this->logger->info("MongoDB - Retrieved a $itemType with id $id.");
        } catch (Exception $e) {
            $response->handleException($e);
            $this->logger->error("MongoDB - Retrieving of a $itemType with id $id failed.");
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
            $response->message = ucfirst($itemType) . " $newItem->name successfully created.";
            $this->logger->info("MongoDB - $response->message");
        } catch (Exception $e) {
            $response->handleException($e);
            $this->logger->error("MongoDB - $itemType could not be created.");
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
            $this->logger->info("MongoDB - $response->message");
            $response->message = ucfirst($itemType) . " " . $item['name'] . "successfully deleted.";
        } catch (Exception $e) {
            $response->handleException($e);
            $this->logger->error("MongoDB - $itemType could not be deleted.");
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
            $response->message = ucfirst($itemType) . " " . $item['name'] . "successfully updated.";
            $this->logger->info("MySQL - $response->message");
        } catch (Exception $e) {
            $response->handleException($e);
            $this->logger->error("MongoDB - $itemType could not be updated.");
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