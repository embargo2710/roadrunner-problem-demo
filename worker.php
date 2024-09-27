<?php

declare(strict_types=1);

use Spiral\RoadRunner\Jobs\Consumer;

require __DIR__ . '/vendor/autoload.php';

$consumer = new Consumer();

throw new Error();

sleep(10);

while (($task = $consumer->waitTask())) {
    sleep(10);

    $task->complete();
}
