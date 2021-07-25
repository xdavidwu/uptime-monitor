<?php

namespace App\Exceptions;

use Exception;

class StreamSocketException extends Exception
{
    public function __construct($url, $errno, $errstr)
    {
        if (!$errstr) {
            if (!$errno) {
                $this->message = "Connection to $url failed: Unknown error";
            } else {
                $this->message = "Connection to $url failed: $errno";
            }
        } else {
            $this->message = "Connection to $url failed: $errstr";
        }
    }
}
