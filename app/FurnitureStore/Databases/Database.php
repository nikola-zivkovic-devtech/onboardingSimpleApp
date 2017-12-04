<?php

namespace FurnitureStore\Databases;

use FurnitureStore\Enums\NamespacePaths;

/**
 * Class Database
 * Factory class for database classes.
 *
 * @property $database
 */
class Database implements IDatabaseHandler
{
    private static $database;

    public function __construct()
    {
        $config = parse_ini_file('../config/config.ini');

        $class = NamespacePaths::DATABASES_PATH . $config['type'] . "Database";
        self::$database = new $class($config);
    }

    public function connect()
    {
        self::$database->connect();
    }

    public function close()
    {
        self::$database->close();
    }

    public function getAll($itemType)
    {
        return self::$database->getAll($itemType);
    }

    public function getOne($itemType, $id)
    {
        return self::$database->getOne($itemType, $id);
    }

    public function create($itemType, $newItem)
    {
        return self::$database->create($itemType, $newItem);
    }

    public function delete($itemType, $id)
    {
        return self::$database->delete($itemType, $id);
    }

    public function update($itemType, $id, $updatedItem)
    {
        return self::$database->update($itemType, $id, $updatedItem);
    }
}