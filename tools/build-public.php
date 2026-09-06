<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require dirname(__DIR__) . '/includes/config.php';
$files = require __DIR__ . '/public-files.php';
$destination = $argv[1] ?? '';
$prepare = ($argv[2] ?? '') === '--prepare';
if (!$prepare && (SITE_URL === '' || parse_url(SITE_URL, PHP_URL_SCHEME) !== 'https')) {
    fwrite(STDERR, "Set FLEETIQ_SITE_URL to the confirmed HTTPS base URL before building.\n");
    exit(1);
}
// Accept a new external directory or a new directory beneath the dedicated build root.
$parent = realpath(dirname($destination));
$source = dirname((string) realpath(__FILE__), 2);
$normalise = static fn (string $path): string => strtolower(str_replace('\\', '/', $path));
$insideSource = $parent && str_starts_with($normalise($parent) . '/', $normalise($source) . '/');
$insideBuild = $parent && str_starts_with($normalise($parent) . '/', $normalise($source) . '/build/');
if ($destination === '' || !$parent || in_array(basename($destination), ['', '.', '..'], true) || file_exists($destination) || ($insideSource && !$insideBuild)) {
    fwrite(STDERR, "Choose a new directory outside the source or beneath build, with an existing parent.\n");
    exit(1);
}
$destination = $parent . DIRECTORY_SEPARATOR . basename($destination);
foreach ($files as $file) {
    if (!is_file($source . '/' . $file)) { throw new RuntimeException('Missing allowlisted file: ' . $file); }
}
if (!mkdir($destination, 0700)) { throw new RuntimeException('Cannot create deployment directory.'); }
foreach ($files as $file) {
    $target = $destination . '/' . $file;
    if (!is_dir(dirname($target)) && !mkdir(dirname($target), 0755, true)) { throw new RuntimeException('Cannot create deployment subdirectory.'); }
    if (!copy($source . '/' . $file, $target)) { throw new RuntimeException('Cannot copy deployment file.'); }
}
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
foreach ($files as $file) {
    if ($prepare || str_contains($file, '/') || $file === '404.php') { continue; }
    $url = SITE_URL . '/' . ($file === 'index.php' ? '' : $file);
    $xml .= '  <url><loc>' . htmlspecialchars($url, ENT_XML1, 'UTF-8') . "</loc></url>\n";
}
$xml .= "</urlset>\n";
$generated = [
    'sitemap.xml' => $xml,
    'robots.txt' => $prepare ? "# Preparation package: rebuild with the confirmed public URL before upload.\nUser-agent: *\nDisallow: /\n" : "User-agent: *\nAllow: /\n\nSitemap: " . SITE_URL . "/sitemap.xml\n",
    // Apache 2.4 only. Other servers need equivalent rules documented in README.
    '.htaccess' => "Options -Indexes\nErrorDocument 404 " . site_base_path() . "404.php\n<FilesMatch \"^\\.\">\n    Require all denied\n</FilesMatch>\n",
    'includes/.htaccess' => "Require all denied\n",
    'components/.htaccess' => "Require all denied\n",
    '.user.ini' => "display_errors=Off\ndisplay_startup_errors=Off\nlog_errors=On\nexpose_php=Off\nsession.use_strict_mode=1\nsession.use_only_cookies=1\nsession.cookie_httponly=1\nsession.cookie_samesite=Lax\n",
];
foreach ($generated as $file => $contents) {
    if (file_put_contents($destination . '/' . $file, $contents) === false) { throw new RuntimeException('Cannot write deployment file.'); }
}
echo "Public package created: " . $destination . "\nConfigure the SAME FLEETIQ_SITE_URL and authorised mail sender on the host.\nVerify host access rules, PHP settings, HTTPS and delivery before inviting visitors.\n";
if ($prepare) { echo "PREPARATION ONLY: empty sitemap and crawl-disallowed robots. Rebuild without --prepare after the domain is confirmed.\n"; }
