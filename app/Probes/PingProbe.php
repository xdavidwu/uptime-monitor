<?php

namespace App\Probes;

class PingProbe extends CommandProbe
{
    public function __construct($host)
    {
        $this->host = $host;
        if (strpos($host, ':') === false) {
            parent::__construct([
                'ping',
                '-c1',
                '-W1',
                $host
            ]);
        } else {
            parent::__construct([
                'ping',
                '-6',
                '-c1',
                '-W1',
                $host
            ]);
        }
    }

    public function describe()
    {
        return "Ping $this->host";
    }
}
