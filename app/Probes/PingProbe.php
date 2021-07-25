<?php

namespace App\Probes;

class PingProbe extends CommandProbe
{
    public function __construct($host)
    {
        $this->host = $host;
        parent::__construct([
            'ping',
            '-c1',
            '-W1',
            $host
        ]);
    }

    public function describe()
    {
        return "Ping $this->host";
    }
}
