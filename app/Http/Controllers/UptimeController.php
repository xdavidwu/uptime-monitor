<?php

namespace App\Http\Controllers;

use App\Models\ProbeInstance;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;

class UptimeController extends Controller
{
    public function show()
    {
        Carbon::setToStringFormat(function ($carbon) {
            return $carbon->toIso8601ZuluString();
        });
        $to = Carbon::now();
        $from = Carbon::now()->subDays(7);
        $timeslot = CarbonInterval::minutes(60);
        $instances = ProbeInstance::all();
        $data = [];
        foreach ($instances as $instance) {
            $raw_logs = $instance->logs()->where('created_at', '>=', $from)->orderBy('created_at')->get();
            $raw_index = 0;
            $raw_length = count($raw_logs);
            $logs = [];
            for ($i = $from->copy(); $i < $to; $i->add($timeslot)) {
                $localto = $i->copy()->add($timeslot);

                $known = false;
                $up = true;
                while ($raw_index < $raw_length &&
                        $raw_logs[$raw_index]->created_at < $localto) {
                    $known = true;
                    if ($raw_logs[$raw_index]->success == false) {
                        $up = false;
                    }
                    $raw_index++;
                }

                $logs[] = [
                    'from' => $i->copy(),
                    'to' => $localto,
                    'state' => $known ? $up ? 'up' : 'down' : 'unknown',
                    'info' => $known ? $up ? 'Operational' : 'Malfunctioning' : 'Unknown',
                ];
            }

            $data[] = [
                'title' => $instance->title ?? unserialize($instance->probe)->describe(),
                'logs' => $logs,
            ];
        }
        return view('uptime', [ 'data' => $data ]);
    }
}
