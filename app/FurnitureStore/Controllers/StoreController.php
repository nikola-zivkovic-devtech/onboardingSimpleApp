<?php

namespace FurnitureStore\Controllers;

use FurnitureStore\Databases\Database;

/**
 * class StoreController
 *
 * Controller class that contains list of actions for store items.
 */
class StoreController
{
    private $itemType;
    private $database;

    public function __construct($itemType, Database $database)
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