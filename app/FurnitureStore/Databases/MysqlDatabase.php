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
            $query = "SELECT * FROM " . $itemType . " WHERE id = " . $id;
            $result = $this->database->query($query)->fetch_assoc();
            $response->data = $result;
        } catch (\Exception $e) {
            $response->handleException($e);
        }

        return $response;
    }

    /**
     * Creates an item in mysql database
     *
     * @param $itemType
     * @param $newItem
     * @return Response
     */
    public function create($itemType, $newItem)
    {
        $response = new Response();

        try{
            $query = "INSERT INTO " . $itemType . " (name, price, colour, material, size) VALUES ('" . $newItem->name . "', " . $newItem->price . ", '" . $newItem->colour . "', '" . $newItem->material . "', '" . $newItem->size . "');";
            $result = $this->database->query($query);
            if ($result) {
                $response->data = $newItem;
                $response->message = ucfirst($itemType) . " successfully created.";
            } else {
                throw new \Exception("The $itemType could not be created.");
            }
        } catch (\Exception $e) {
            $response->handleException($e);
        }

        return $response;
    }

    /**
     * Deletes an item from mysql database
     *
     * @param $itemType
     * @param $id
     * @return Response
     */
    public function delete($itemType, $id)
    {
        $response = new Response();

        try{
            $item = $this->getItemById($id, $itemType);

            $query = "DELETE FROM " . $itemType . " WHERE id = " . $item['id'];
            $result = $this->database->query($query);

            if ($result) {
                $response->message = ucfirst($itemType) . " successfully deleted.";
            } else {
                throw new \Exception("The $itemType could not be deleted.");
            }
        } catch (\Exception $e) {
            $response->handleException($e);
        }

        return $response;
    }

    /**
     * Updates an item in mysql database
     *
     * @param $itemType
     * @param $id
     * @param $updatedItem
     * @return Response
     */
    public function update($itemType, $id, $updatedItem)
    {
        $response = new Response();

        try{
            $item = $this->getItemById($id, $itemType);


            $query = "UPDATE $itemType SET name = '" . $updatedItem->name . "', price = " . $updatedItem->price. ", colour = '" . $updatedItem->colour . "', material = '" . $updatedItem->material . "', size = '" . $updatedItem->size . "' WHERE id = " . $item['id'] . ";";
            $result = $this->database->query($query);
            if ($result) {
                $response->data = $updatedItem;
                $response->message = ucfirst($itemType) . " successfully updated.";
            } else {
                throw new \Exception("The $itemType could not be updated.");
            }
        } catch (\Exception $e) {
            $response->handleException($e);
        }

        return $response;
    }

    private function getItemById($id, $itemType)
    {
        $query = "SELECT * FROM " . $itemType . " WHERE id = " . $id;
        $result = $this->database->query($query)->fetch_assoc();
        if (sizeof($result) < 1) {
            throw new \Exception("There are no items with id $id.");
        }
        return $result;
    }

}