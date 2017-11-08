<?php

namespace FurnitureStore\Controllers;

/**
 * class StoreController
 *
 * Controller class that .
 */
class StoreController
{
    private $itemType;
    private $database;

    public function __construct($itemType, $database)
    {
        $this->itemType = $itemType;
        $this->database = $database;
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->itemType;
        $this->database->getAll($query);
    }

    public function getOne($id)
    {
        $query = "SELECT * FROM " . $this->itemType . " WHERE id" . $this->itemType. "=" . $id;
        $this->database->getOne($query);
    }

}