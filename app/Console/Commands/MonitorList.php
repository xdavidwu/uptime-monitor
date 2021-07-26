<?php

namespace App\Console\Commands;

use App\ProbeInstance;
use Illuminate\Console\Command;

class MonitorList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List registerd probes and monitored objects';

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
        $headers = ['ID', 'Title', 'Description'];
        $rows = [];
        foreach (ProbeInstance::all() as $probe_instance) {
            $probe = unserialize($probe_instance->probe);
            $rows[] = [$probe_instance->id, $probe_instance->title, $probe->describe()];
        }
        $this->table($headers, $rows);
    }
}
