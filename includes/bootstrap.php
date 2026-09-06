<?php
declare(strict_types=1);

// Hosts must also disable display_errors in PHP configuration: startup/entry-point
// parse errors happen before this file can run. Detailed logs belong outside webroot.
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

if (PHP_SAPI !== 'cli') {
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('X-Frame-Options: SAMEORIGIN');
    header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:; font-src 'self'; connect-src 'self'; object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'self'");
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
    header_remove('X-Powered-By');
    $fleetBufferLevel = ob_get_level();
    ob_start();
    $fleetErrorResponse = static function () use ($fleetBufferLevel): void {
        while (ob_get_level() > $fleetBufferLevel) {
            ob_end_clean();
        }
        http_response_code(500);
        header('Content-Type: text/html; charset=UTF-8');
        header('Cache-Control: no-store');
        echo '<!doctype html><html lang="en-GB"><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>FleetIQ | Temporarily unavailable</title><main><h1>Temporarily unavailable</h1><p>We could not load this page. Please try again later.</p></main></html>';
    };
    set_error_handler(static function (int $severity, string $message, string $file, int $line): bool {
        if (!(error_reporting() & $severity)) {
            return false; // Respect intentional suppression at checked failure boundaries.
        }
        throw new ErrorException($message, 0, $severity, $file, $line);
    });
    set_exception_handler(static function (Throwable $error) use ($fleetErrorResponse): void {
        // Do not log exception messages or stack arguments, which may contain input/secrets.
        error_log('FleetIQ request failed: ' . get_class($error) . ' in ' . $error->getFile() . ':' . $error->getLine());
        $fleetErrorResponse();
    });
    register_shutdown_function(static function () use ($fleetErrorResponse): void {
        $error = error_get_last();
        if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
            error_log('FleetIQ fatal error in ' . $error['file'] . ':' . $error['line']);
            $fleetErrorResponse();
        }
    });
}
