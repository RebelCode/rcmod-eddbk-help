<?php

namespace RebelCode\EddBookings\Help;

use Dhii\Invocation\InvocableInterface;
use Dhii\Util\String\StringableInterface as Stringable;

/**
 * The handler that enqueues the Beacon JS files.
 *
 * @since [*next-version*]
 */
class EnqueueBeaconHandler implements InvocableInterface
{
    /**
     * The path to the Beacon JS file.
     *
     * @since [*next-version*]
     *
     * @var string|Stringable
     */
    protected $beaconJsFile;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable $beaconJsFile The path to the Beacon JS file.
     */
    public function __construct($beaconJsFile)
    {
        $this->beaconJsFile = $beaconJsFile;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function __invoke()
    {
        $screen = $this->_wpGetCurrentScreen();

        if ($screen === null) {
            return;
        }

        // Get screen base and split by underscore
        $base  = $screen->base;
        $parts = explode('_', $base);

        // If no parts or the first part is incorrect, stop
        if (count($parts) === 0 || $parts[0] !== 'toplevel' || $parts[0] !== 'bookings') {
            return;
        }

        // Get the last part
        $pageId = end($parts);

        // Check if it starts with the "eddbk-" prefix
        if (strpos($pageId, 'eddbk-') === 0) {
            // Enqueue beacon scripts
            wp_enqueue_script('eddbk_beacon_js', $this->beaconJsFile);
        }
    }

    /**
     * Retrieves the current WordPress screen.
     *
     * @since [*next-version*]
     *
     * @return \WP_Screen|null The screen object or null if not applicable.
     */
    protected function _wpGetCurrentScreen()
    {
        return \get_current_screen();
    }
}
