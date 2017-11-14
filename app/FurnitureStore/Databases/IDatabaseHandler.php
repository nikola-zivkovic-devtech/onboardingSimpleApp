<?php

namespace FurnitureStore\Databases;


interface IDatabaseHandler
{
    public function connect();

    public function getAll($itemType);

    public function getOne($itemType, $id);
}