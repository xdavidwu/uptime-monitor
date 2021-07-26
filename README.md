# uptime-monitor

A simple server status monitoring tool, built on top of Laravel framework.

## setup

Set up like all other Laravel (6.x) apps. A php environment and database is needed, all other Laravel functions like mailing is not used. For database, only sqlite has been tested.

Some probes are implemented by external commands, and those command will likely compatible with Linux environments only.

## usage

After setting up the environment and running database migrations, interacts the application with artisan `monitor:*` subcommands (see them with `php artisan list`). Currently all administrative usage is in CLI. See `--help` of those subcommands for more information. Register your probes with `monitor:register`.

`monitor:probe` should be run once every hour. Set up a cron job for it.

The served web page will list the status for all probes, under user-facing string descibing the monitored service specified by you instead of detailed description. Currently 7 days of historical data will be visualized.

## notes

I built this project for my own usage on a restrictive environment that is hard to change. If features that requires environment that cannot be statisfied by mine is desired, it will be maintianed in a new branch. I will still mainly focus on maintaining the old branch that is compatible with my environment.
