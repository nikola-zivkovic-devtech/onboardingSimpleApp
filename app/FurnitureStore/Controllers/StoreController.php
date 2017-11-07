<?php

namespace FurnitureStore\Controllers;


class StoreController
{
    private $itemType;

    public function __construct($itemType)
    {
        $this->itemType = $itemType;
    }

    public function getAll()
    {
        //database query for all
        echo 'get all ' . $this->itemType . '.';
    }

    public function getOne($id)
    {
        //
        echo 'get one ' . $this->itemType . ' with id: ' . $id . '.';
    }

}