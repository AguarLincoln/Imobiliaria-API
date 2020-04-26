<?php

namespace App\Messagens;

class ApiMessages
{
    private $messages = [];

    public function __construct($message, array $data = [])
    {
        $this->messages['message'] = $message;
        $this->messages['errors'] = $data;
    }

    public function getMessage()
    {
        return $this->messages;
    }
}