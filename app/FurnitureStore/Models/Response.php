<?php

namespace FurnitureStore\Models;

/**
 * Class Response
 *
 *
 */
class Response {

    public $success;
    public $message;
    public $data;
    public $exception;

    public function __construct() {
        $this->success = true;
    }

    public function handleException(\Exception $e) {
        $this->success = false;
        $this->message = $e->getMessage();
        $this->exception = $e;
    }

    public function json()
    {
        return json_encode($this->data);
    }
}