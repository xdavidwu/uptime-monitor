# uptime-monitor

A simple server status monitoring tool, built on top of Lumen framework.

## setup

Set up like all other Laravel/Lumen apps. A php environment and database is needed, all other Laravel functions like mailing is not used. For database, only sqlite has been tested.

Some probes are implemented by external commands, and those command will likely compatible with Linux environments only.

## usage

After setting up the environment and running database migrations, interacts the application with artisan `monitor:*` subcommands (see them with `php artisan list`). Currently all administrative usage is in CLI. See `--help` of those subcommands for more information. Register your probes with `monitor:register`.

Set `MONITOR_PROBE_MAX_TRIES` (defaults to 1) in `.env` if you want probes to retry when failed.

`monitor:probe` should be run once every hour. Set up a cron job for it.

The served web page will list the status for all probes, under user-facing string descibing the monitored service specified by you instead of detailed description. Currently 7 days of historical data will be visualized.

## SSG

This contains only a single, self-containing page, and can be used as SSG via executing `public/index.php`.
