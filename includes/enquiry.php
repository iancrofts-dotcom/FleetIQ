<?php
declare(strict_types=1);

const DEMO_FLEET_SIZES = ['1–10 vehicles', '11–25 vehicles', '26–50 vehicles', '51–100 vehicles', '101–250 vehicles', '251+ vehicles'];
const DEMO_INDUSTRIES = ['Transport / Haulage', 'Construction', 'Engineering', 'Service Fleet', 'Taxi / Private Hire', 'Courier', 'Coach / Minibus', 'Plant / Commercial', 'Other'];
const DEMO_FIELD_LIMITS = ['name' => 100, 'company' => 160, 'email' => 254, 'phone' => 40, 'fleet_size' => 40, 'industry' => 60, 'message' => 4000];

/** Validate independently of the delivery transport. Never store raw POST data. */
function validate_demo_enquiry(array $post, string $csrf): array
{
    $values = array_fill_keys(array_keys(DEMO_FIELD_LIMITS), '');
    $errors = [];
    $allowed = [...array_keys(DEMO_FIELD_LIMITS), 'csrf', 'website'];
    if (array_diff(array_keys($post), $allowed)) {
        $errors['_form'] = 'We could not process this form. Please check your details and try again.';
    }
    if (!isset($post['csrf']) || !is_string($post['csrf']) || strlen($post['csrf']) !== 64 || !hash_equals($csrf, $post['csrf'])) {
        $errors['_form'] = 'Your form session could not be verified. Please try again using this form.';
    }
    if (!isset($post['website']) || !is_string($post['website']) || $post['website'] !== '') {
        $errors['_form'] = 'We could not process this form. Please try again.';
    }
    foreach (DEMO_FIELD_LIMITS as $field => $limit) {
        $input = $post[$field] ?? '';
        if (!is_string($input) || strlen($input) > $limit * 4 || !preg_match('//u', $input)) {
            $errors[$field] = 'Please enter a valid value within the field limit.';
            continue;
        }
        // Reject control characters before trimming, including header injection attempts.
        $controls = $field === 'message' ? '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/' : '/[\x00-\x1F\x7F]/';
        if (preg_match($controls, $input)) {
            $errors[$field] = 'Please remove unsupported characters from this field.';
            continue;
        }
        $input = trim($input);
        if (preg_match_all('/./us', $input) > $limit) {
            $errors[$field] = 'Please use no more than ' . $limit . ' characters.';
            continue;
        }
        $values[$field] = $input;
    }
    foreach (['name' => 'your name', 'company' => 'your company', 'email' => 'your email address', 'phone' => 'your phone number', 'fleet_size' => 'your fleet size'] as $field => $label) {
        if ($values[$field] === '' && !isset($errors[$field])) {
            $errors[$field] = 'Please enter ' . $label . '.';
        }
    }
    if ($values['email'] !== '' && !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address, such as name@company.co.uk.';
    }
    if ($values['phone'] !== '' && (!preg_match('/^\+?[0-9 ().-]+$/D', $values['phone']) || strlen(preg_replace('/\D/', '', $values['phone'])) < 7 || strlen(preg_replace('/\D/', '', $values['phone'])) > 15)) {
        $errors['phone'] = 'Please enter 7–15 digits, using spaces, +, brackets or hyphens if needed.';
    }
    if ($values['fleet_size'] !== '' && !in_array($values['fleet_size'], DEMO_FLEET_SIZES, true)) {
        $errors['fleet_size'] = 'Please choose one of the fleet size ranges.';
        $values['fleet_size'] = '';
    }
    if ($values['industry'] !== '' && !in_array($values['industry'], DEMO_INDUSTRIES, true)) {
        $errors['industry'] = 'Please choose one of the fleet types, or leave this blank.';
        $values['industry'] = '';
    }
    return ['values' => $values, 'errors' => $errors];
}

/** Callable boundary keeps validation testable without sending email. */
function process_demo_enquiry(array $post, string $csrf, callable $deliver): array
{
    $result = validate_demo_enquiry($post, $csrf);
    $result['sent'] = false;
    if ($result['errors']) {
        return $result;
    }
    try {
        $result['sent'] = $deliver($result['values']) === true;
    } catch (Throwable $error) {
        // Do not leak mail configuration, server details or visitor data.
        $result['sent'] = false;
    }
    if (!$result['sent']) {
        $result['errors']['_form'] = 'We could not send your enquiry just now. Your details are still below so you can try again later.';
    }
    return $result;
}
