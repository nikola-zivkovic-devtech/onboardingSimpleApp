<?php

namespace FurnitureStore\Controllers;

use FurnitureStore\Databases\Database;
use FurnitureStore\Databases\IDatabaseHandler;
use FurnitureStore\Enums\Messages;
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
            $response = $this->database->getAll($this->itemType);

            if (!$response->success) {
                throw new \Exception($response->message);
            } elseif (empty($response->data)) {
                $response->message = Messages::EMPTY_DATA;
                echo $response->message;
            } else {
                echo $response->json();
            }
        } catch (\Exception $e) {
            ErrorOutput::say($e);
        }
    }

    public function getOne($id)
    {
        try {
            $response = $this->database->getOne($this->itemType, $id);

            if (!$response->success) {
                throw new \Exception($response->message);
            } elseif (empty($response->data)) {
                $response->message = Messages::EMPTY_DATA;
                echo $response->message;
            } else {
                echo $response->json();
            }
        } catch (\Exception $e) {
            ErrorOutput::say($e);
        }
    }

    public function create()
    {
        $newItem = (json_decode(file_get_contents('php://input')));

        try {
            $response = $this->database->create($this->itemType, $newItem);

            if (!$response->success) {
                throw new \Exception($response->message);
            } else {
                echo $response->json();
            }
        } catch (\Exception $e) {
            ErrorOutput::say($e);
        }
    }

    public function delete($id)
    {
        try {
            $response = $this->database->delete($this->itemType, $id);

            if (!$response->success) {
                throw new \Exception($response->message);
            } else {
                echo $response->json();
            }
        } catch (\Exception $e) {
            ErrorOutput::say($e);
        }
    }

    public function update($id)
    {
        $updatedItem = json_decode(file_get_contents('php://input'));

        try {
            $response = $this->database->update($this->itemType, $id, $updatedItem);

            if (!$response->success) {
                throw new \Exception($response->message);
            } elseif (empty($response->data)) {
                $response->message = Messages::EMPTY_DATA;
                echo $response->message;
            } else {
                echo $response->json();
            }
        } catch (\Exception $e) {
            ErrorOutput::say($e);
        }
    }

}