<?php

namespace App\Http\Response;

class ApiResponse
{
    public $status;
    public $message;
    public $data;

    public function __construct($status, $message = '', $data = null)
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }
}
