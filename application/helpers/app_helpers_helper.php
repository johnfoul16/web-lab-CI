<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Returns the Bootstrap badge class based on the given status.
 *
 * @param string $status The order shipping status (e.g., 'Processing', 'Delivered', 'Cancelled').
 * @return string The Bootstrap class string for the badge.
 */
function get_status_badge_class($status) {
    switch (ucfirst(strtolower($status))) { // Normalize status for consistency
        case 'Processing':
            return 'bg-secondary';
        case 'Ready To Ship': // Consider this as a status
            return 'bg-info';
        case 'In Transit':
            return 'bg-primary';
        case 'Out For Delivery':
            return 'bg-warning text-dark'; // Use text-dark for better contrast on yellow
        case 'Delivered':
            return 'bg-success';
        case 'Cancelled':
            return 'bg-danger';
        default:
            return 'bg-secondary'; // Default for unknown status
    }
}
