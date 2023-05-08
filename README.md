## What is it?

RR + simple PHP-worker with a random sleep function (from 50 to 1000 ms).

There is a hypothesis that workers cannot get enough jobs.

There we have 64 workers and 128 pollers.

## How to run

`docker-compose build`

`docker-compose up -d rabbitmq` and wait a little

`docker-compose up -d php`

## How to reproduce

`docker-compose exec php sh -c "php emitter.php"` - run as many times as you want

`docker-compose exec php sh -c "php monitor.php"` - run, wait and stop CTRL+C

## Output

```
string(26) "rr_jobs_workers_working 50"
string(26) "rr_jobs_workers_working 50"
string(26) "rr_jobs_workers_working 50"
string(26) "rr_jobs_workers_working 50"
string(26) "rr_jobs_workers_working 50"
string(26) "rr_jobs_workers_working 50"
string(26) "rr_jobs_workers_working 50"
string(26) "rr_jobs_workers_working 50"
string(26) "rr_jobs_workers_working 50"
string(26) "rr_jobs_workers_working 36"
string(26) "rr_jobs_workers_working 25"
string(26) "rr_jobs_workers_working 16"
string(26) "rr_jobs_workers_working 10"
string(26) "rr_jobs_workers_working 10"
string(26) "rr_jobs_workers_working 10"
string(26) "rr_jobs_workers_working 10"
string(26) "rr_jobs_workers_working 10"
string(25) "rr_jobs_workers_working 7"
string(25) "rr_jobs_workers_working 0"
string(25) "rr_jobs_workers_working 0"
string(25) "rr_jobs_workers_working 0"
string(25) "rr_jobs_workers_working 0"
string(25) "rr_jobs_workers_working 0"
string(25) "rr_jobs_workers_working 0"
```

## Playground

Change environment vars `NUM_POLLERS` and `NUM_WORKERS` in `docker-compose.yml`

`docker-compose up -d php`

Then go to "How to reproduce"
