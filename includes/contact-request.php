<?php
declare(strict_types=1);

require __DIR__ . '/enquiry.php';
require __DIR__ . '/enquiry-delivery.php';

// Session cookie is necessary only on this form route: CSRF and one-time PRG state.
ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.gc_maxlifetime', '1800');
session_name('fleetiq_enquiry');
session_set_cookie_params(['lifetime' => 0, 'path' => '/', 'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off', 'httponly' => true, 'samesite' => 'Lax']);
if (!@session_start()) {
    http_response_code(503);
    exit('Enquiries are temporarily unavailable. Please try again later.');
}
header('Cache-Control: no-store, private');
header('Referrer-Policy: same-origin');
if (!isset($_SESSION['demo_csrf'])) {
    $_SESSION['demo_csrf'] = bin2hex(random_bytes(32));
}
$values = array_fill_keys(array_keys(DEMO_FIELD_LIMITS), '');
$errors = [];
$success = false;
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method === 'POST') {
    if ((int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 20000 || !str_starts_with(strtolower($_SERVER['CONTENT_TYPE'] ?? ''), 'application/x-www-form-urlencoded')) {
        $result = ['values' => $values, 'errors' => ['_form' => 'We could not process this form. Please keep your enquiry within the field limits and try again.'], 'sent' => false];
    } else {
        $result = process_demo_enquiry($_POST, $_SESSION['demo_csrf'], 'deliver_demo_enquiry');
    }
    if ($result['sent']) {
        $_SESSION['demo_csrf'] = bin2hex(random_bytes(32));
    }
    $_SESSION['demo_result'] = ['values' => $result['sent'] ? $values : $result['values'], 'errors' => $result['errors'], 'sent' => $result['sent'], 'created' => time()];
    session_write_close();
    header('Location: contact.php#enquiry', true, 303);
    exit;
}
if ($method !== 'GET') {
    header('Allow: GET, POST');
    http_response_code(405);
    $errors['_form'] = 'Please use the enquiry form below.';
} elseif (isset($_SESSION['demo_result'])) {
    $result = $_SESSION['demo_result'];
    unset($_SESSION['demo_result']);
    if (time() - $result['created'] <= 1800) {
        $values = $result['values'];
        $errors = $result['errors'];
        $success = $result['sent'];
    }
}
$csrf = $_SESSION['demo_csrf'];
session_write_close();
