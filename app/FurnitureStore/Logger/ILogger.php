<?php

namespace FurnitureStore\Logger;


interface ILogger
{
    public function info($message);
    public function error($message);
}