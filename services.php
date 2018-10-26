<?php

use Psr\Container\ContainerInterface;
use RebelCode\EddBookings\Help\EnqueueBeaconHandler;

return [
    'eddbk_enqueue_beacon_handler' => function (ContainerInterface $c) {
        $moduleDir  = $c->get('eddbk_help/module_dir');
        $jsFile     = $c->get('eddbk_help/beacon/js/file');
        $jsPath     = sprintf('modules/%s/%s', $moduleDir, $jsFile);
        $pluginPath = $c->get('eddbk/file_path');

        return new EnqueueBeaconHandler(
            plugins_url($jsPath, $pluginPath)
        );
    },
];
