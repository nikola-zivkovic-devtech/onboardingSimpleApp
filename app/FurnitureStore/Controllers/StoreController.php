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
        $this->database->getAll($this->itemType);
    }

    public function getOne($id)
    {
        $this->database->getOne($this->itemType, $id);
    }

}