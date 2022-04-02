<?php

namespace App\Console\Commands;

use App\Models\ProbeInstance;
use App\Models\ProbeLog;
use Exception;
use Illuminate\Console\Command;

class MonitorProbe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:probe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform probes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (ProbeInstance::all() as $probe_instance) {
            $probe = unserialize($probe_instance->probe);
            $success = false;
            $lastlog = '';
            for ($i = env('MONITOR_PROBE_MAX_TRIES', 1); $i > 0; $i--) {
                try {
                    $probe->execute();
                    $success = true;
                    break;
                } catch (Exception $e) {
                    $left = $i - 1;
                    $this->error("{$probe->describe()} failed, {$left} tries left");
                    $this->info($e->getMessage());
                    $lastlog = $e->getMessage();
                }
            }
            $log = new ProbeLog();
            $log->success = $success;
            $log->outputs = $lastlog;
            $probe_instance->logs()->save($log);
        }
    }
}
