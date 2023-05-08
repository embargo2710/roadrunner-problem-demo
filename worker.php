<?php

declare(strict_types=1);

use Spiral\RoadRunner\Jobs\Consumer;

require __DIR__ . '/vendor/autoload.php';

$consumer = new Consumer();

while (($task = $consumer->waitTask())) {
    $random = random_int(50, 1000);

    usleep($random * 1000);

    $task->complete();
}
