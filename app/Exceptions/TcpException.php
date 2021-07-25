<?php

namespace App\Exceptions;

use Exception;

class TcpException extends Exception
{
    public function __construct($address, $port, $socket_errno)
    {
        $this->message = "TCP connection to $address:$port failed: " . socket_strerror($socket_errno);
    }
}
