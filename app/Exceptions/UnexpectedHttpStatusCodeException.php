<?php

namespace App\Exceptions;

use Exception;

class UnexpectedHttpStatusCodeException extends Exception
{
    public function __construct($url, $expected_code, $result_code)
    {
        $this->message = "Unexpected status code at $url, expected: $expected_code, got: $result_code";
    }
}
