<?php

namespace App\Console\Commands;

use App\ProbeInstance;
use App\ProbeLog;
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
            try {
                $probe->execute();
                $log = new ProbeLog();
                $log->success = true;
                $probe_instance->logs()->save($log);
            } catch (Exception $e) {
                $this->error($probe->describe() . ' failed');
                $this->info($e->getMessage());
                $log = new ProbeLog();
                $log->success = false;
                $log->outputs = $e->getMessage();
                $probe_instance->logs()->save($log);
            }
        }
    }
}
