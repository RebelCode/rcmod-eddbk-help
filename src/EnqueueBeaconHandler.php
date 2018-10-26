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
     * The URL to the Beacon JS file.
     *
     * @since [*next-version*]
     *
     * @var string|Stringable
     */
    protected $beaconJsUrl;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable $beaconJsUrl The URL to the Beacon JS file.
     */
    public function __construct($beaconJsUrl)
    {
        $this->beaconJsUrl = $beaconJsUrl;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function __invoke()
    {
        if (!$this->_wpIsAdmin()) {
            return;
        }

        $screen = $this->_wpGetCurrentScreen();

        if ($screen === null) {
            return;
        }

        // Get screen base and split by underscore
        $base  = $screen->base;
        $parts = explode('_', $base);

        // If no parts or the first part is incorrect, stop
        if (count($parts) === 0 || ($parts[0] !== 'toplevel' && $parts[0] !== 'bookings')) {
            return;
        }

        // Get the last part
        $pageId = end($parts);

        // Check if it starts with the "eddbk-" prefix
        if (strpos($pageId, 'eddbk-') === 0) {
            // Enqueue beacon scripts
            wp_enqueue_script('eddbk_beacon_js', $this->beaconJsUrl);
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

    /**
     * Retrieves whether the current screen is a WP Admin screen
     *
     * @since [*next-version*]
     *
     * @return bool True if the current screen is a WP Admin screen, false if not.
     */
    protected function _wpIsAdmin()
    {
        return \is_admin();
    }
}
