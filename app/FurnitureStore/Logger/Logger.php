<?php

namespace FurnitureStore\Logger;

use Analog\Analog;
use Analog\Handler\File;

class Logger implements ILogger
{
    public function __construct()
    {
        $log_file = '../public/logs/log.txt';
        Analog::handler (File::init ($log_file));
    }

    public function info($message)
    {
        Analog::info($message);
    }

    public function error($message)
    {
        Analog::error($message);
    }
}