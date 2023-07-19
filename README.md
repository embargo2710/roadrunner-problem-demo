## What is it?

on_init + declare metrics makes me cry

## How to reproduce

`docker-compose build`

`docker-compose up -d php`

## Output

```
2023-07-19T10:47:02+0000        DEBUG   rpc             plugin was started      {"address": "tcp://0.0.0.0:6001", "list of the plugins with RPC methods:": ["app", "metrics", "informer", "resetter", "lock"]}
2023-07-19T10:47:02+0000        DEBUG   metrics         declaring new metric    {"name": "test", "type": "counter", "namespace": ""}
2023-07-19T10:47:02+0000        DEBUG   metrics         metric successfully added       {"name": "test", "type": "counter", "namespace": ""}
2023-07-19T10:47:02+0000        DEBUG   metrics         adding metric   {"name": "test", "value": 1, "labels": []}
2023-07-19T10:47:02+0000        DEBUG   metrics         metric successfully added       {"name": "test", "labels": [], "value": 1}
2023-07-19T10:47:02+0000        INFO    server          ON INIT
handle_serve_command: Function call error:
        got initial serve error from the Vertex *metrics.Plugin, stopping execution, error: duplicate metrics collector registration attempted
```

But if you run `php metric.php` only after RR started (without `on_init` section) no error occurred:

```
/var/www/html # php metric.php
ON INIT/var/www/html #
```

```
2023-07-19T10:52:50+0000        DEBUG   rpc             plugin was started      {"address": "tcp://0.0.0.0:6001", "list of the plugins with RPC methods:": ["resetter", "app", "metrics", "lock", "informer"]}
[INFO] RoadRunner server started; version: 2023.2.0, buildtime: 2023-07-06T19:02:05+0000
2023-07-19T10:53:00+0000        DEBUG   metrics         declaring new metric    {"name": "test", "type": "counter", "namespace": ""}
2023-07-19T10:53:00+0000        DEBUG   metrics         metric successfully added       {"name": "test", "type": "counter", "namespace": ""}
2023-07-19T10:53:00+0000        DEBUG   metrics         adding metric   {"name": "test", "value": 1, "labels": []}
2023-07-19T10:53:00+0000        DEBUG   metrics         metric successfully added       {"name": "test", "labels": [], "value": 1}
```