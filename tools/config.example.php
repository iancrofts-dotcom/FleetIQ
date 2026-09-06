<?php
// Copy OUTSIDE your public directory as fleetiq-config.php; edit only the private copy.
// Do not upload this example as a public file. Environment variables take priority.
return [
    'FLEETIQ_SITE_URL' => '', // Confirmed HTTPS URL, including subdirectory if applicable.
    'FLEETIQ_DEMO_RECIPIENT' => 'iancrofts@live.co.uk',
    'FLEETIQ_DEMO_FROM' => '', // Fixed sender authorised by the actual mail provider.
    'FLEETIQ_DEMO_TRANSPORT' => 'mail', // Or disabled until delivery is configured.
];
