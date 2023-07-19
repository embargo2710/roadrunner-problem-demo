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