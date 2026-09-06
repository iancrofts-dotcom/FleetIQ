<?php
// Copy OUTSIDE your public directory as fleetiq-config.php; edit only the private copy.
// Do not upload this example as a public file. Environment variables take priority.
return [
    // Omit FLEETIQ_SITE_URL to use the central temporary test default in includes/config.php.
    // Add it here to override that default when SSL or the production URL is confirmed.
    'FLEETIQ_DEMO_RECIPIENT' => 'iancrofts@live.co.uk',
    'FLEETIQ_DEMO_FROM' => '', // Fixed sender authorised by the actual mail provider.
    'FLEETIQ_DEMO_TRANSPORT' => 'mail', // Or disabled until delivery is configured.
];
