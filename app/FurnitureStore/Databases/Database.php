<?php

namespace FurnitureStore\Databases;

use FurnitureStore\Enums\NamespacePaths;

/**
 * Class Database
 *
 * Factory class for database classes.
 *
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

    public static function connect()
    {
        self::$database->connect();
    }

    public function close()
    {
        self::$database->close();
    }

    public function getAll($itemType)
    {
        self::$database->getAll($itemType);
    }

    public function getOne($itemType, $id)
    {
        self::$database->getOne($itemType, $id);
    }
}