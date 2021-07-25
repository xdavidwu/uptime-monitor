<?php

namespace App\Console\Commands;

use App\ProbeInstance;
use Illuminate\Console\Command;

class MonitorRegister extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitor:register
                            {class : Class of the probe}
                            {args?* : Extra arguments of <class> constructor}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register a probe';

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
        $class = $this->argument('class');
        $args = $this->argument('args');
        $probe = new $class(...$args);
        // test round
        $probe->execute();

        $record = new ProbeInstance();
        $record->probe = serialize($probe);
        $record->save();
    }
}
