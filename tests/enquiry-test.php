<?php
declare(strict_types=1);
// CLI-only tests. Fake transport callbacks never deliver email.
if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}
require __DIR__ . '/../includes/config.php';
require __DIR__ . '/../includes/enquiry.php';
require __DIR__ . '/../includes/enquiry-delivery.php';
$checks = 0;
function check(bool $condition, string $label): void
{
    global $checks;
    if (!$condition) {
        throw new RuntimeException($label);
    }
    $checks++;
}
$csrf = str_repeat('a', 64);
$valid = ['csrf' => $csrf, 'website' => '', 'name' => '  Example Person  ', 'company' => 'Example Fleet Ltd', 'email' => 'visitor@example.invalid', 'phone' => '+44 (0)20 1234 5678', 'fleet_size' => DEMO_FLEET_SIZES[1], 'industry' => DEMO_INDUSTRIES[0], 'message' => "Vehicle records\nAnd workshop activity"];
$calls = 0;
$accept = static function (array $values) use (&$calls): bool { $calls++; return true; };
$result = process_demo_enquiry($valid, $csrf, $accept);
check($result['sent'] && !$result['errors'] && $calls === 1 && $result['values']['name'] === 'Example Person', 'Valid submission and trimming');
foreach (['name', 'company', 'email', 'phone', 'fleet_size'] as $field) {
    $post = $valid;
    unset($post[$field]);
    $result = process_demo_enquiry($post, $csrf, $accept);
    check(isset($result['errors'][$field]) && !$result['sent'], 'Required ' . $field);
}
foreach ([['email', 'bad@'], ['email', "visitor@example.invalid\r\nBcc: attacker@example.invalid"], ['name', "Name\0"], ['company', "Company\nBcc: anything"], ['phone', '123'], ['phone', 'not a number'], ['fleet_size', 'unlisted'], ['industry', 'unlisted'], ['website', 'spam'], ['csrf', 'bad'], ['csrf', []], ['email', []], ['name', str_repeat('x', 101)], ['message', str_repeat('x', 4001)], ['message', "\xFF"], ['message', "bad\0value"]] as [$field, $value]) {
    $post = $valid;
    $post[$field] = $value;
    $result = process_demo_enquiry($post, $csrf, $accept);
    check(!$result['sent'] && (bool) $result['errors'], 'Reject invalid ' . $field);
}
$post = $valid;
$post['unexpected'] = 'value';
check((bool) process_demo_enquiry($post, $csrf, $accept)['errors'], 'Unknown field rejected');
check($calls === 1, 'Invalid submissions never call transport');
foreach ([static fn(array $values): bool => false, static function (array $values): bool { throw new RuntimeException('private server path'); }] as $failure) {
    $result = process_demo_enquiry($valid, $csrf, $failure);
    check(!$result['sent'] && isset($result['errors']['_form']) && $result['values']['company'] === $valid['company'], 'Delivery failure preserves safe values');
    check(!str_contains($result['errors']['_form'], 'private'), 'No exception details exposed');
}
$post = $valid;
$post['message'] = '<script>alert("test")</script>';
$result = validate_demo_enquiry($post, $csrf);
check(!$result['errors'] && !str_contains(escape($result['values']['message']), '<script>'), 'Message output escaped');
$post['industry'] = '';
$post['message'] = '';
check(!validate_demo_enquiry($post, $csrf)['errors'], 'Optional fields may be empty');
check(!demo_mailbox_valid("visitor@example.invalid\r\nBcc: other@example.invalid"), 'Unsafe mailbox rejected');
$values = validate_demo_enquiry($valid, $csrf)['values'];
$values['company'] = str_repeat('車', 160);
$message = build_demo_message($values);
check($message['to'] === DEMO_EMAIL, 'Recipient from config');
check($message['headers']['Reply-To'] === $values['email'] && $message['headers']['From'] === DEMO_FROM_EMAIL, 'Controlled sender and validated Reply-To');
check(!preg_match('/[\r\n]/', $message['subject']) && strlen($message['subject']) < 998, 'Safe bounded subject');
foreach (explode(' ', $message['subject']) as $word) {
    check(strlen($word) <= 75, 'Encoded word length');
    $decoded = base64_decode(substr($word, 10, -2), true);
    check(is_string($decoded) && (bool) preg_match('//u', $decoded), 'Encoded words preserve UTF-8');
}
$body = base64_decode($message['body'], true);
check(is_string($body) && str_contains($body, $values['company']) && str_contains($body, 'Submitted: ') && str_contains($body, ' UTC'), 'Complete body and UTC submission time');
check(str_contains($body, $values['phone']) && str_contains($body, $values['message']), 'Enquiry fields retained');
echo "Passed {$checks} checks; no emails sent.\n";
