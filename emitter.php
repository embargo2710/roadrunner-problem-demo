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

$queues = [
    $jobs->connect('queue-1'),
    $jobs->connect('queue-2'),
    $jobs->connect('queue-3'),
    $jobs->connect('queue-4'),
    $jobs->connect('queue-5'),
];

$len = count($queues);

for ($i = 0; $i < getenv('NUM_WORKERS'); $i++) {
    $q = random_int(0, $len - 1);

    $job = $queues[$q]->create('test-1', '{"site": "https://example.com"}');
    $queues[$q]->dispatch($job);
}
