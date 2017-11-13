<?php

namespace FurnitureStore\Databases;


interface IDatabaseHandler
{
    public static function connect();

    public function getAll($itemType);

    public function getOne($itemType, $id);
}