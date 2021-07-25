<?php

namespace App\Probes;

use App\Exceptions\StreamSocketException;
use App\Interfaces\Probe;

class StreamSocketProbe implements Probe
{
    public function __construct($url)
    {
        $this->url = $url;
    }

    protected function connect($context = null)
    {
        $fp = false;
        try {
            $fp = stream_socket_client($this->url, $errno, $errstr, 1, STREAM_CLIENT_CONNECT, $context);
        } catch (\ErrorException $e) {
            if (!$errstr && $errno === 0) {
                // Message from exceptions may be more useful
                $errstr = $e->getMessage();
            }
            $fp = false;
        }
        if ($fp === false) {
            throw new StreamSocketException($this->url, $errno, $errstr);
        }
        fclose($fp);
    }

    public function execute()
    {
        $this->connect();
    }

    public function describe()
    {
        return "Connect to $this->url";
    }
}
