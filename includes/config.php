<?php
declare(strict_types=1);

// Set the public origin when deploying, e.g. https://your-domain.example.
const SITE_URL = '';
// Confirmed enquiry recipient. Override only through deployment configuration.
define('DEMO_EMAIL', getenv('FLEETIQ_DEMO_RECIPIENT') ?: 'iancrofts@live.co.uk');
// Set a fixed sender authorised by your host; never use a visitor's address here.
define('DEMO_FROM_EMAIL', getenv('FLEETIQ_DEMO_FROM') ?: '');
// PHP mail requires working host mail configuration. Use "disabled" to suspend delivery.
define('DEMO_MAIL_TRANSPORT', getenv('FLEETIQ_DEMO_TRANSPORT') ?: 'mail');

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
