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
                padding: 8px;
            }

            nav {
                position: sticky;
                background-color: #3F51B5;
                line-height: 18px;
                top: 0px;
                margin: -16px -16px 16px -16px;
                padding: 20px;
                padding-left: 32px;
                color: white;
                background-color: #3F51B5;
                box-shadow: 0 2px 4px rgba(0,0,0,.5);
                font-size: 18px;
            }

            main {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

            .card {
                display: inline-block;
                border-radius: 2px;
                background-color: white;
                box-shadow: 0 1px 1px 0 rgba(60,64,67,.08),0 1px 3px 1px rgba(60,64,67,.16);
                padding: 16px;
                margin: 16px;
            }

            .titlebar {
                display: flex;
                justify-content: space-between;
                align-items: flex-end;
            }

            .status {
                font-size: 14px;
            }

            .status.up {
                color: #0d0;
            }

            .status.down {
                color: #f00;
            }

            .status.unknown {
                color: #888;
            }

            .uptime-view {
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
                column-gap: 3px;
                row-gap: 3px;
                grid-template-rows: repeat(6, 1fr);
                grid-auto-flow: column;
                margin: 4px 0;
            }

            .uptime-item {
                width: 8px;
                height: 8px;
            }

            .uptime-item.up {
                background: #0f0;
                border-radius: 50%;
            }

            .uptime-item.down {
                width: 0;
                height: 0;
                border-left: 4px solid transparent;
                border-right: 4px solid transparent;
                border-bottom: 8px solid #f00;
            }

            .uptime-item.unknown {
                background: #ccc;
            }

            @media (prefers-color-scheme: dark) {
                body {
                    background: black;
                    color: white;
                }

                .card {
                    background: #202124;
                }

                .uptime-item.unknown {
                    background: #666;
                }
            }
        </style>
    </head>
    <body>
        <nav>{{ config('app.name') }}</nav>
        <main>
            @foreach ($data as $instance)
                <div class="card">
                    <div class="titlebar">
                        <span class="title">{{ $instance['title'] }}</span>
                        @if (!$instance['logs'][count($instance['logs']) - 1]['known'])
                            <span class="status unknown">Unknown</span>
                        @elseif ($instance['logs'][count($instance['logs']) - 1]['up'])
                            <span class="status up">Operational</span>
                        @else
                            <span class="status down">Malfunctioning</span>
                        @endif
                    </div>
                    <div class="uptime-view">
                        <div class="uptime-from">{{ $instance['logs'][0]['from'] }}</div>
                        <div class="uptime-grid">
                            @foreach ($instance['logs'] as $log)
                                <div class="uptime-item {{ $log['known'] ? $log['up'] ? 'up' : 'down' : 'unknown' }}"
                                    title="{{ "{$log['from']} ~ {$log['to']}: {$log['info']}" }}">
                                </div>
                            @endforeach
                        </div>
                        <div class="uptime-to">{{ $instance['logs'][count($instance['logs']) - 1]['to'] }}</div>
                    </div>
                </div>
            @endforeach
        </main>
    </body>
</html>
