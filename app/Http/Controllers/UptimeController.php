<?php

namespace App\Http\Controllers;

use App\ProbeInstance;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class UptimeController extends Controller
{
    public function show()
    {
        $to = Carbon::now();
        $from = Carbon::now()->subDays(7);
        $timeslot = CarbonInterval::minutes(90);
        $instances = ProbeInstance::all();
        $data = [];
        foreach ($instances as $instance) {
            $probe = unserialize($instance->probe);

            $raw_logs = $instance->logs()->where('created_at', '>=', $from)->orderBy('created_at')->get();
            $raw_index = 0;
            $raw_length = count($raw_logs);
            $logs = [];
            for ($i = $from->copy(); $i < $to; $i->add($timeslot)) {
                $localto = $i->copy()->add($timeslot);

                $known = false;
                $up = true;
                $info = 'Succeeded';
                while ($raw_index < $raw_length &&
                        $raw_logs[$raw_index]->created_at < $localto) {
                    $known = true;
                    if ($raw_logs[$raw_index]->success == false) {
                        $up = false;
                        $info = 'Failed';
                    }
                    $raw_index++;
                }

                $logs[] = [
                    'from' => $i->copy(),
                    'to' => $localto,
                    'known' => $known,
                    'up' => $up,
                    'info' =>'',
                ];
            }

            $data[] = [
                'description' => $probe->describe(),
                'logs' => $logs,
            ];
        }
        return view('uptime', [ 'data' => $data, 'from' => $from, 'to' => $to ]);
    }
}
