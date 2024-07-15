## What is it?

## How to run

`docker-compose build`

`docker-compose up -d` and wait a little

## How to reproduce

1. From first terminal:
`docker-compose exec php sh`

`rr serve`

2. From second terminal:

`docker-compose exec php sh`

`php emitter.php` (emit 1000 tasks to pipeline)

3. Then immediately go to first terminal and stop RR by CTRL + C.

Start RR again: `rr serve`

Check workers: `rr workers`

Now let's see at `ACTIVE` column - it could contain negative number (for example -1). All tasks are lost.
If we restart RR again then we got `ACTIVE` = -2 or -3. 

## Output

```
/var/www/html # rr workers
Workers of [jobs]:
+---------+-----------+---------+---------+---------+--------------------+
|   PID   |  STATUS   |  EXECS  | MEMORY  |  CPU%   |      CREATED       |
+---------+-----------+---------+---------+---------+--------------------+
|    1226 | ready     |       0 | 16 MB   |    0.15 | 11 seconds ago     |
|    1227 | ready     |       1 | 17 MB   |    0.15 | 11 seconds ago     |
|    1228 | ready     |       1 | 16 MB   |    0.15 | 11 seconds ago     |
|    1229 | ready     |       1 | 17 MB   |    0.08 | 11 seconds ago     |
+---------+-----------+---------+---------+---------+--------------------+
Jobs of [jobs]:
+--------+----------+--------+-------+--------+---------+----------+
| STATUS | PIPELINE | DRIVER | QUEUE | ACTIVE | DELAYED | RESERVED |
+--------+----------+--------+-------+--------+---------+----------+
| READY  | boltdb   | boltdb | push  | -3     | 0       | 0        |
+--------+----------+--------+-------+--------+---------+----------+

```

After three RR restart we got output:

```
/var/www/html # rr serve
2024-07-15T06:54:34+0000        DEBUG   rpc             plugin was started      {"address": "tcp://127.0.0.1:6001", "list of the plugins with RPC methods:": ["jobs", "lock", "metrics", "informer", "app", "resetter"]}
2024-07-15T06:54:34+0000        DEBUG   jobs            initializing driver     {"pipeline": "boltdb", "driver": "boltdb"}
2024-07-15T06:54:34+0000        DEBUG   jobs            driver ready    {"pipeline": "boltdb", "driver": "boltdb", "start": "2024-07-15T06:54:34+0000", "elapsed": 5}
2024-07-15T06:54:34+0000        DEBUG   boltdb          pipeline was started    {"driver": "boltdb", "pipeline": "boltdb", "start": "2024-07-15T06:54:34+0000", "elapsed": 0}       
2024-07-15T06:54:34+0000        DEBUG   server          worker is allocated     {"pid": 1315, "max_execs": 540, "internal_event_name": "EventWorkerConstruct"}
2024-07-15T06:54:34+0000        DEBUG   server          worker is allocated     {"pid": 1317, "max_execs": 550, "internal_event_name": "EventWorkerConstruct"}
2024-07-15T06:54:34+0000        DEBUG   server          worker is allocated     {"pid": 1316, "max_execs": 565, "internal_event_name": "EventWorkerConstruct"}
2024-07-15T06:54:34+0000        DEBUG   server          worker is allocated     {"pid": 1314, "max_execs": 535, "internal_event_name": "EventWorkerConstruct"}
2024-07-15T06:54:34+0000        DEBUG   jobs            exited from jobs pipeline processor
2024-07-15T06:54:34+0000        DEBUG   jobs            exited from jobs pipeline processor
2024-07-15T06:54:34+0000        DEBUG   jobs            exited from jobs pipeline processor
2024-07-15T06:54:34+0000        DEBUG   jobs            exited from jobs pipeline processor
2024-07-15T06:54:34+0000        DEBUG   jobs            exited from jobs pipeline processor
2024-07-15T06:54:34+0000        DEBUG   jobs            exited from jobs pipeline processor
2024-07-15T06:54:34+0000        DEBUG   jobs            exited from jobs pipeline processor
2024-07-15T06:54:34+0000        DEBUG   jobs            exited from jobs pipeline processor
2024-07-15T06:54:34+0000        DEBUG   jobs            exited from jobs pipeline processor
2024-07-15T06:54:34+0000        DEBUG   jobs            exited from jobs pipeline processor
[INFO] RoadRunner server started; version: 2024.1.2, buildtime: 2024-05-16T19:48:53+0000
[INFO] sdnotify: not notified
2024-07-15T06:54:35+0000        DEBUG   jobs            job processing was started      {"ID": "025274ee-51d0-471e-a7b1-6a152f8239ad", "start": "2024-07-15T06:54:34+0000", "elapsed": 491}
2024-07-15T06:54:35+0000        DEBUG   jobs            job processing was started      {"ID": "049d8474-d93f-4bfd-8792-f4997029f5da", "start": "2024-07-15T06:54:34+0000", "elapsed": 992}
2024-07-15T06:54:36+0000        DEBUG   jobs            job processing was started      {"ID": "04c1e81e-ac20-429e-8559-3d26ec931ba6", "start": "2024-07-15T06:54:34+0000", "elapsed": 1491}
2024-07-15T06:54:36+0000        DEBUG   server          req-resp mode   {"pid": 1315}
2024-07-15T06:54:36+0000        DEBUG   jobs            job was processed successfully  {"ID": "025274ee-51d0-471e-a7b1-6a152f8239ad", "start": "2024-07-15T06:54:34+0000", "elapsed": 1499}
2024-07-15T06:54:36+0000        DEBUG   server          req-resp mode   {"pid": 1316}
2024-07-15T06:54:36+0000        DEBUG   jobs            job was processed successfully  {"ID": "049d8474-d93f-4bfd-8792-f4997029f5da", "start": "2024-07-15T06:54:34+0000", "elapsed": 1999}
2024-07-15T06:54:37+0000        DEBUG   server          req-resp mode   {"pid": 1317}
2024-07-15T06:54:37+0000        DEBUG   jobs            job was processed successfully  {"ID": "04c1e81e-ac20-429e-8559-3d26ec931ba6", "start": "2024-07-15T06:54:34+0000", "elapsed": 2499}
```

Three stuck tasks processed every time and never get ack.
