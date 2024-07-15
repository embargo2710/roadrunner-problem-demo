<?php

declare(strict_types=1);

use Spiral\Goridge\RPC\RPC;
use Spiral\RoadRunner\Jobs\Consumer;
use Spiral\RoadRunner\Jobs\Jobs;

require __DIR__ . '/vendor/autoload.php';

$jobs = new Jobs(RPC::create(Spiral\RoadRunner\Environment::fromGlobals()->getRPCAddress()));

$consumer = new Consumer();

$queue = $jobs->connect('messages');

while (($task = $consumer->waitTask())) {
    if ($task->getPipeline() === 'amqp_message_accumulator') {
        $queue->dispatch($queue->create('messages', '123'));
    } else {
        fwrite(STDERR, print_r($task, true));
    }

    $task->complete();
}
