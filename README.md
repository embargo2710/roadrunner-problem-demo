## What is it?

Error SIGSEGV occurs while workers did not start, but someone call `metric` plugin too early.

No need to call Redis or something.

## How to reproduce

`docker-compose build`

`docker-compose up -d rabbitmq` and wait a little

`docker-compose up -d monitor` and see many `string(25) "1686655710 RESPONSE FAILED"` in loop

`docker-compose up -d php` and see errors

## 

`docker-compose exec php sh -c "php emitter.php"` - run as many times as you want

`docker-compose exec php sh -c "php monitor.php"` - run, wait and stop CTRL+C

## Output

```
[INFO] RoadRunner server started; version: 2023.1.5, buildtime: 2023-06-08T14:45:04+0000   
2023-06-13T11:34:59+0000        INFO    server      
Fatal error: Uncaught Error in /var/www/html/worker.php:11
Stack trace:
#0 {main}
  thrown in /var/www/html/worker.php on line 11   

... MANY SIMILAR ERRORS ...

2023-06-13T11:34:59+0000        INFO    server      
Fatal error: Uncaught Error in /var/www/html/worker.php:11
Stack trace:
#0 {main}
  thrown in /var/www/html/worker.php on line 11
{"time":"2023-06-13T11:15:34.168980018Z","level":"ERROR","msg":"plugin returned an error from the Serve","!BADKEY":"static_pool_allocate_workers: WorkerAllocate: EOF","id":"*jobs.Plugin"}
panic: runtime error: invalid memory address or nil pointer dereference
[signal SIGSEGV: segmentation violation code=0x1 addr=0x28 pc=0xc65db4]
goroutine 659 [running]:
github.com/roadrunner-server/sdk/v4/pool/static_pool.(*Pool).Workers(0x52?)
        github.com/roadrunner-server/sdk/v4@v4.2.6/pool/static_pool/static_pool.go:119 +0x14
github.com/roadrunner-server/jobs/v4.(*Plugin).Workers(0xc0001f1200)
        github.com/roadrunner-server/jobs/v4@v4.3.11/plugin.go:286 +0xbb
github.com/roadrunner-server/sdk/v4/metrics.(*StatsExporter).Collect(0xc000b80a50, 0xc000d64000?)
        github.com/roadrunner-server/sdk/v4@v4.2.6/metrics/metrics.go:42 +0x4a
github.com/roadrunner-server/jobs/v4.(*statsExporter).Collect(0xc0000c4480, 0xc000ebef60?)
        github.com/roadrunner-server/jobs/v4@v4.3.11/metrics.go:86 +0x31
github.com/prometheus/client_golang/prometheus.(*Registry).Gather.func1()
        github.com/prometheus/client_golang@v1.15.1/prometheus/registry.go:455 +0x10d
created by github.com/prometheus/client_golang/prometheus.(*Registry).Gather
        github.com/prometheus/client_golang@v1.15.1/prometheus/registry.go:547 +0xc09
```
