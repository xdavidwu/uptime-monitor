<?php

namespace App\Probes;

class TlsProbe extends StreamSocketProbe
{
    public function __construct($address, $port, $fingerprint = null)
    {
        $this->address = $address;
        $this->port = $port;
        $this->fingerprint = $fingerprint;
    }

    public function execute()
    {
        $this->url = "tls://$this->address:$this->port";
        $context = null;
        if ($this->fingerprint) {
            $context = stream_context_create();
            // When we know the expected fingerprint, ignore self-signed
            // This allows usage like in Gemini protocol
            stream_context_set_option($context, 'ssl', 'allow_self_signed', true);
            stream_context_set_option($context, 'ssl', 'peer_fingerprint', $this->fingerprint);
        }
        $this->connect($context);
    }

    public function describe()
    {
        return "Establish TLS connection with $this->address:$this->port";
    }
}
