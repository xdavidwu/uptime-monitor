<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        <style>
            body {
                background-color: #fafafa;
                font-family: sans-serif;
            }

            .card {
                display: inline-block;
                border-radius: 2px;
                background-color: white;
                box-shadow: 0 1px 1px 0 rgba(60,64,67,.08),0 1px 3px 1px rgba(60,64,67,.16);
                padding: 16px;
                margin: 16px;
                //overflow: auto;
            }

            .uptime-view {
                width: 320px;
                margin-top: 8px;
            }

            .uptime-from, .uptime-to {
                font-size: 10px;
                color: #aaa;
            }

            .uptime-to {
                text-align: right;
            }

            .uptime-grid {
                display: grid;
                column-gap: 1%;
                row-gap: 2px;
                grid-template-rows: repeat(4, 1fr);
                grid-auto-flow: column;
                margin: 4px 0;
            }

            .uptime-item {
                width: 8px;
                height: 8px;
            }

            .up {
                background: #0f0;
            }

            .down {
                background: #f00;
            }

            .unknown {
                background: #ccc;
            }
        </style>
    </head>
    <body>
        @foreach ($data as $instance)
            <div class="card">
                {{ $instance['description'] }}
                <div class="uptime-view">
                    <div class="uptime-from">{{ $instance['logs'][0]['from'] }}</div>
                    <div class="uptime-grid">
                        @foreach ($instance['logs'] as $log)
                            <div class="uptime-item {{ $log['known'] ? $log['up'] ? 'up' : 'down' : 'unknown'}}"
                                title="{{ "{$log['from']} to {$log['to']}" }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="uptime-to">{{ $instance['logs'][count($instance['logs']) - 1]['to'] }}</div>
                </div>
            </div>
        @endforeach
    </body>
</html>
