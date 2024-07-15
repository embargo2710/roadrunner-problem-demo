<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Spiral\Goridge\Relay;
use Spiral\Goridge\RPC\RPC;
use Spiral\RoadRunner\Jobs\Jobs;

$jobs = new Jobs(
    new RPC(
        Relay::create('tcp://127.0.0.1:6001')
    )
);

$queue = $jobs->connect('boltdb');

for ($i = 0; $i < 1000; $i++) {
    $job = $queue->create('test', '{"site": "https://example.com"}');
    $queue->dispatch($job);
}
