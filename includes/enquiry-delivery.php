<?php
declare(strict_types=1);

function demo_mailbox_valid(string $address): bool
{
    return strlen($address) <= 254 && !preg_match('/[\x00-\x20\x7F]/', $address) && filter_var($address, FILTER_VALIDATE_EMAIL) !== false;
}

function demo_delivery_configured(): bool
{
    return DEMO_MAIL_TRANSPORT === 'mail' && function_exists('mail') && demo_mailbox_valid(DEMO_EMAIL) && demo_mailbox_valid(DEMO_FROM_EMAIL);
}

/** Plain-text message construction is independent of the transport. */
function build_demo_message(array $values): array
{
    $labels = ['name' => 'Name', 'company' => 'Company', 'email' => 'Email', 'phone' => 'Phone', 'fleet_size' => 'Fleet size', 'industry' => 'Industry / fleet type', 'message' => 'What they would like help managing'];
    $lines = ['FleetIQ demo enquiry', 'Submitted: ' . gmdate('Y-m-d H:i:s') . ' UTC', ''];
    foreach ($labels as $key => $label) {
        $lines[] = $label . ':';
        $lines[] = $values[$key] !== '' ? $values[$key] : 'Not provided';
        $lines[] = '';
    }
    // RFC 2047 encoded words prevent visitor-controlled text becoming header syntax.
    // Short chunks stay within the encoded-word length limit, even for Unicode names.
    $parts = [];
    $part = '';
    $bytes = 0;
    foreach (preg_split('//u', 'FleetIQ Demo Enquiry - ' . $values['company'], -1, PREG_SPLIT_NO_EMPTY) as $character) {
        if ($bytes + strlen($character) > 240) {
            break; // The complete company name is always retained in the body.
        }
        if (strlen($part) + strlen($character) > 42) {
            $parts[] = $part;
            $part = '';
        }
        $part .= $character;
        $bytes += strlen($character);
    }
    $parts[] = $part;
    $subject = implode(' ', array_map(static fn(string $part): string => '=?UTF-8?B?' . base64_encode($part) . '?=', $parts));
    $headers = [
        'From' => DEMO_FROM_EMAIL,
        'Reply-To' => $values['email'],
        'MIME-Version' => '1.0',
        'Content-Type' => 'text/plain; charset=UTF-8',
        'Content-Transfer-Encoding' => 'base64',
    ];
    $body = chunk_split(base64_encode(implode("\r\n", $lines)), 76, "\r\n");
    return ['to' => DEMO_EMAIL, 'subject' => $subject, 'body' => $body, 'headers' => $headers];
}

/** Replace this adapter with authenticated SMTP when the hosting environment requires it. */
function deliver_demo_enquiry(array $values): bool
{
    if (!demo_delivery_configured() || !demo_mailbox_valid($values['email'])) {
        return false;
    }
    $message = build_demo_message($values);
    try {
        // true means accepted by the configured mail transport, not inbox receipt.
        return @mail($message['to'], $message['subject'], $message['body'], $message['headers']);
    } catch (Throwable $error) {
        return false;
    }
}
