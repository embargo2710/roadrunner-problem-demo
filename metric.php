<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Spiral\Goridge\Relay;
use Spiral\Goridge\RPC\RPC;

$rpc = new RPC(
    Relay::create('tcp://0.0.0.0:6001')
);

$rpc = $rpc->withServicePrefix('metrics');

$rpc->call('Declare', [
    'name'      => 'test',
    'collector' => [
        'namespace' => '',
        'subsystem' => '',
        'type'      => 'counter',
        'help'      => '',
        'labels'    => [],
        'buckets'   => [],
    ],
]);

$rpc->call('Add', [
    'name'   => 'test',
    'value'  => 1.0,
    'labels' => [],
]);

echo "ON INIT";
