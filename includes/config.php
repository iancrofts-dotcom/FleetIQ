<?php
declare(strict_types=1);

// Set the public origin when deploying, e.g. https://your-domain.example.
const SITE_URL = '';
// Add a monitored address to enable demo enquiries.
const DEMO_EMAIL = '';

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
