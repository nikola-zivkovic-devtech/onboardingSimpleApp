<?php

namespace FurnitureStore\Controllers;

use FurnitureStore\Databases\Database;
use FurnitureStore\Databases\IDatabaseHandler;
use FurnitureStore\Exceptions\ErrorOutput;

/**
 * class StoreController
 * Controller class that directs database requests to the database classes.
 *
 * @property string $itemType
 * @property Database $database
 */
class StoreController
{
    private $itemType;
    private $database;

    public function __construct($itemType, IDatabaseHandler $database)
    {
        $this->itemType = $itemType;
        $this->database = $database;
    }

    public function getAll()
    {
        try {
            $this->database->getAll($this->itemType);
        } catch (\Exception $e) {
            new ErrorOutput($e);
        }
    }

    public function getOne($id)
    {
        try {
            $this->database->getOne($this->itemType, $id);
        } catch (\Exception $e) {
            new ErrorOutput($e);
        }
    }

}