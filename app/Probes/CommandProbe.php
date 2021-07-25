<?php

namespace App\Probes;

use App\Interfaces\Probe;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CommandProbe implements Probe
{
    public function __construct($command)
    {
        $this->command = $command;
    }

    public function execute()
    {
        $process = new Process($this->command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        } else {
            return true;
        }
    }

    public function describe()
    {
        return "Execute command $this->command";
    }
}
