<?php

namespace FurnitureStore\Controllers;

use FurnitureStore\Databases\Database;
use FurnitureStore\Databases\IDatabaseHandler;
use FurnitureStore\Enums\ErrorMessages;
use FurnitureStore\Exceptions\ErrorOutput;
use FurnitureStore\Models\Response;

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
            $response = $this->database->getAll($this->itemType);
            $this->handleResponse($response);
        } catch (\Exception $e) {
            ErrorOutput::say($e);
        }
    }

    public function getOne($id)
    {
        try {
            $response = $this->database->getOne($this->itemType, $id);
            $this->handleResponse($response);
        } catch (\Exception $e) {
            ErrorOutput::say($e);
        }
    }


    private function handleResponse(Response $response)
    {
        if (!$response->success) {
            throw new \Exception($response->message);
        } elseif (empty($response->data)) {
            $response->message = ErrorMessages::EMPTY_DATA;
            echo $response->message;
        } else {
            echo $response->json();
        }
    }

}