<?php

use Psr\Container\ContainerInterface;
use RebelCode\EddBookings\Help\EnqueueBeaconHandler;

return [
    'eddbk_enqueue_beacon_handler' => function (ContainerInterface $c) {
        return new EnqueueBeaconHandler(
            $c->get('eddbk_help/beacon/file')
        );
    },
];
