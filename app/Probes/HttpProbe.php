<?php

namespace App\Probes;

use App\Exceptions\UnexpectedHttpStatusCodeException;
use App\Interfaces\Probe;
use GuzzleHttp\Client;

class HttpProbe implements Probe
{
    public function __construct($url, int $code)
    {
        $this->url = $url;
        $this->code = $code;
    }

    public function execute()
    {
        $client = new Client();
        $res = $client->request(
            'GET',
            $this->url,
            ['allow_redirects' => false, 'timeout' => 1]
        );
        if ($res->getStatusCode() !== $this->code) {
            throw new UnexpectedHttpStatusCodeException($this->url, $this->code, $res->getStatusCode());
        }
    }

    public function describe()
    {
        return "Access $this->url";
    }
}
