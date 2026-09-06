<?php
// Local PHP development server only. Excluded from the deployment package.
if (PHP_SAPI !== 'cli-server') { http_response_code(404); exit; }
$entry = realpath((getenv('FLEETIQ_DOCUMENT_ROOT') ?: dirname(__DIR__)) . '/index.php');
$root = $entry ? dirname($entry) : false;
$path = rawurldecode((string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$base = rtrim(getenv('FLEETIQ_LOCAL_BASE_PATH') ?: '', '/');
if ($base !== '' && str_starts_with($path, $base . '/')) { $path = substr($path, strlen($base)); }
$file = $path === '/' ? 'index.php' : ltrim($path, '/');
$files = require __DIR__ . '/public-files.php';
$public = array_filter($files, static fn (string $name): bool => !str_starts_with($name, 'includes/') && !str_starts_with($name, 'components/'));
$public = array_merge($public, ['sitemap.xml', 'robots.txt']);
if (!$root) { http_response_code(500); exit('Temporarily unavailable.'); }
if (in_array($file, $public, true) && is_file($root . '/' . $file)) {
    if (str_ends_with($file, '.php')) { require $root . '/' . $file; }
    else {
        $types = ['css' => 'text/css', 'js' => 'text/javascript', 'svg' => 'image/svg+xml', 'xml' => 'application/xml', 'txt' => 'text/plain'];
        header('Content-Type: ' . $types[pathinfo($file, PATHINFO_EXTENSION)] . '; charset=UTF-8');
        header('X-Content-Type-Options: nosniff');
        readfile($root . '/' . $file);
    }
    return true;
}
require $root . '/404.php';
return true;
