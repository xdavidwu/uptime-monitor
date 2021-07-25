<?php

namespace App\Probes;

use App\Exceptions\TcpException;
use App\Interfaces\Probe;

class TcpProbe implements Probe
{
    public function __construct($address, $port)
    {
        $this->address = $address;
        $this->port = $port;
    }

    public function execute()
    {
        $socket = socket_create(
            (strpos($this->address, ':') === false) ? AF_INET : AF_INET6,
            SOCK_STREAM,
            SOL_TCP
        );
        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, ['sec' => 1, 'usec' => 0]);
        socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, ['sec' => 1, 'usec' => 0]);
        $res = false;
        try {
            $res = socket_connect($socket, $this->address, $this->port);
        } catch (\ErrorException $e) {
            $res = false;
        }
        if ($res === false) {
            $errno = socket_last_error($socket);
            socket_close($socket);
            throw new TcpException($this->address, $this->port, $errno);
        }
        socket_close($socket);
    }

    public function describe()
    {
        return "Establish TCP connection with $this->address:$this->port";
    }
}
