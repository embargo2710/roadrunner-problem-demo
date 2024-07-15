<?php

declare(strict_types=1);

use Spiral\Goridge\RPC\RPC;
use Spiral\RoadRunner\Jobs\Consumer;
use Spiral\RoadRunner\Jobs\Jobs;

require __DIR__ . '/vendor/autoload.php';

$jobs = new Jobs(RPC::create(Spiral\RoadRunner\Environment::fromGlobals()->getRPCAddress()));

$consumer = new Consumer();

while (($task = $consumer->waitTask())) {
    sleep(1);

    $task->complete();
}
