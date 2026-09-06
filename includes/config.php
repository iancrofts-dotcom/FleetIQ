<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

// Optional shared-host fallback lives OUTSIDE the document root. Environment wins.
$fleetConfigPath = getenv('FLEETIQ_CONFIG_FILE') ?: dirname(__DIR__, 2) . '/fleetiq-config.php';
$fleetPrivateConfig = [];
if (is_file($fleetConfigPath)) {
    $fleetResolvedConfig = realpath($fleetConfigPath);
    $fleetPublicRoot = str_replace('\\', '/', dirname((string) realpath(__FILE__), 2)) . '/';
    if (!$fleetResolvedConfig || str_starts_with(strtolower(str_replace('\\', '/', $fleetResolvedConfig)), strtolower($fleetPublicRoot))) {
        throw new RuntimeException('Private configuration must be outside the document root.');
    }
    $fleetPrivateConfig = require $fleetResolvedConfig;
    if (!is_array($fleetPrivateConfig)) {
        throw new RuntimeException('Invalid private configuration.');
    }
}
$fleetSetting = static function (string $name, string $default = '') use ($fleetPrivateConfig): string {
    $value = getenv($name);
    $value = $value !== false ? $value : ($fleetPrivateConfig[$name] ?? $default);
    if (!is_string($value)) {
        throw new RuntimeException('Invalid configuration value.');
    }
    return $value;
};
// TEMPORARY public test domain, not the production domain. Override centrally when
// SSL/production is confirmed. An explicitly empty setting supports local-only SEO.
$fleetUrl = rtrim($fleetSetting('FLEETIQ_SITE_URL', 'http://fleetiq.fwh.is/'), '/');
if ($fleetUrl !== '' && (!filter_var($fleetUrl, FILTER_VALIDATE_URL) || !in_array(parse_url($fleetUrl, PHP_URL_SCHEME), ['http', 'https'], true) || preg_match('/[\x00-\x20\x7f]/', $fleetUrl) || parse_url($fleetUrl, PHP_URL_USER) !== null || parse_url($fleetUrl, PHP_URL_PASS) !== null || parse_url($fleetUrl, PHP_URL_QUERY) !== null || parse_url($fleetUrl, PHP_URL_FRAGMENT) !== null)) {
    throw new RuntimeException('Invalid site URL.');
}
define('SITE_URL', $fleetUrl);
// Also used for legal/privacy correspondence; no unconfirmed company identity.
const SITE_CONTACT_EMAIL = 'iancrofts@live.co.uk';
// Confirmed enquiry recipient. Override only through deployment configuration.
define('DEMO_EMAIL', $fleetSetting('FLEETIQ_DEMO_RECIPIENT', SITE_CONTACT_EMAIL));
// Set a fixed sender authorised by your host; never use a visitor's address here.
define('DEMO_FROM_EMAIL', $fleetSetting('FLEETIQ_DEMO_FROM'));
// PHP mail requires working host mail configuration. Use "disabled" to suspend delivery.
define('DEMO_MAIL_TRANSPORT', $fleetSetting('FLEETIQ_DEMO_TRANSPORT', 'mail'));
unset($fleetPrivateConfig, $fleetSetting, $fleetConfigPath, $fleetResolvedConfig, $fleetPublicRoot, $fleetUrl);

function site_base_path(): string
{
    return rtrim((string) parse_url(SITE_URL, PHP_URL_PATH), '/') . '/';
}

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
