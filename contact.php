<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/contact-request.php';
require __DIR__ . '/components/icons.php';
$commercialPage = true;
$pagePath = 'contact.php';
$pageTitle = 'Book a FleetIQ Demo | Contact FleetIQ';
$pageDescription = 'Tell us about your fleet and request a FleetIQ demo. Discuss vehicle records, drivers, compliance, documents and workshop tasks relevant to your operation.';
require __DIR__ . '/components/header.php';
?>
<main id="main" class="commercial-page" tabindex="-1">
    <section class="commercial-hero contact-hero dark-section"><div class="container">
        <p class="eyebrow">LET'S TALK FLEET</p><h1>See how FleetIQ could work<br> for your operation.</h1>
        <p class="commercial-lead">Tell us a little about your fleet and what you currently need to manage. We can then arrange a conversation and show you around FleetIQ.</p>
    </div></section>
    <section class="section commercial-light"><div class="container contact-layout">
        <div class="enquiry-panel" id="enquiry">
        <?php if ($success): ?>
            <div class="form-feedback form-success" role="status" tabindex="-1"><?php icon('check'); ?><h2>Thanks for getting in touch.</h2><p>Your FleetIQ enquiry has been sent. We'll review the information you've provided and get back to you.</p></div>
            <a class="button" href="features.php">Explore FleetIQ <?php icon('arrow'); ?></a>
        <?php else: ?>
            <h2>Request a FleetIQ demo</h2><p class="form-introduction">Tell us about your operation. Fields marked <span aria-hidden="true">*</span> are required.</p>
            <?php if (!demo_delivery_configured() && !$errors): ?><p class="form-availability" role="status">Online enquiries are temporarily unavailable. Please try again later.</p><?php endif; ?>
            <?php if ($errors): ?>
            <div class="form-feedback form-errors" role="alert" tabindex="-1"><h3>Please check your enquiry</h3><ul>
                <?php foreach ($errors as $field => $error): ?><li><?php if ($field !== '_form'): ?><a href="#<?= escape($field) ?>"><?= escape($error) ?></a><?php else: ?><?= escape($error) ?><?php endif; ?></li><?php endforeach; ?>
            </ul></div>
            <?php endif; ?>
            <form action="contact.php#enquiry" method="post" class="enquiry-form">
                <input type="hidden" name="csrf" value="<?= escape($csrf) ?>">
                <div hidden aria-hidden="true"><label for="website">Leave this field empty</label><input id="website" name="website" type="text" value="" tabindex="-1" autocomplete="off"></div>
                <div class="form-grid">
                <?php foreach (['name' => ['Name', 'text', 'name'], 'company' => ['Company', 'text', 'organization'], 'email' => ['Email', 'email', 'email'], 'phone' => ['Phone', 'tel', 'tel']] as $field => [$label, $type, $autocomplete]): ?>
                    <div class="form-field"><label for="<?= escape($field) ?>"><?= escape($label) ?> <span aria-hidden="true">*</span></label><input id="<?= escape($field) ?>" name="<?= escape($field) ?>" type="<?= escape($type) ?>" autocomplete="<?= escape($autocomplete) ?>" maxlength="<?= DEMO_FIELD_LIMITS[$field] ?>" value="<?= escape($values[$field]) ?>" required<?= isset($errors[$field]) ? ' aria-invalid="true" aria-describedby="' . $field . '-error"' : '' ?>><?php if (isset($errors[$field])): ?><p class="field-error" id="<?= escape($field) ?>-error"><?= escape($errors[$field]) ?></p><?php endif; ?></div>
                <?php endforeach; ?>
                <?php foreach (['fleet_size' => ['Fleet size', DEMO_FLEET_SIZES], 'industry' => ['Industry / fleet type', DEMO_INDUSTRIES]] as $field => [$label, $options]): ?>
                    <div class="form-field"><label for="<?= escape($field) ?>"><?= escape($label) ?> <?= $field === 'fleet_size' ? '<span aria-hidden="true">*</span>' : '<span class="optional">(optional)</span>' ?></label><select id="<?= escape($field) ?>" name="<?= escape($field) ?>"<?= $field === 'fleet_size' ? ' required' : '' ?><?= isset($errors[$field]) ? ' aria-invalid="true" aria-describedby="' . $field . '-error"' : '' ?>><option value="">Please select</option><?php foreach ($options as $option): ?><option value="<?= escape($option) ?>"<?= $values[$field] === $option ? ' selected' : '' ?>><?= escape($option) ?></option><?php endforeach; ?></select><?php if (isset($errors[$field])): ?><p class="field-error" id="<?= escape($field) ?>-error"><?= escape($errors[$field]) ?></p><?php endif; ?></div>
                <?php endforeach; ?>
                <div class="form-field form-field-wide"><label for="message">What would you like help managing? <span class="optional">(optional)</span></label><textarea id="message" name="message" rows="5" maxlength="4000" aria-describedby="message-hint<?= isset($errors['message']) ? ' message-error' : '' ?>"<?= isset($errors['message']) ? ' aria-invalid="true"' : '' ?>><?= escape($values['message']) ?></textarea><p class="field-hint" id="message-hint">Up to 4,000 characters. Please do not include sensitive driver or vehicle documents.</p><?php if (isset($errors['message'])): ?><p class="field-error" id="message-error"><?= escape($errors['message']) ?></p><?php endif; ?></div>
                </div>
                <p class="form-privacy">Your details will only be used to respond to your FleetIQ enquiry. <a href="privacy.php">Privacy notice</a> </p>
                <button class="button" type="submit">Request a FleetIQ Demo <?php icon('arrow'); ?></button>
            </form>
        <?php endif; ?>
        </div>
        <aside class="contact-support" aria-label="Your FleetIQ conversation">
            <div><p class="eyebrow">FOCUSED ON YOUR OPERATION</p><h2>What we can show you</h2><ul class="demo-topics"><?php foreach (['Vehicle management', 'Driver records', 'Compliance visibility', 'Documents and reminders', 'Digital inspections', 'Defects and repairs', 'Workshop management', 'Fleet reporting', 'Windows / Web / Android'] as $topic): ?><li><?php icon('check'); ?><span><?= escape($topic) ?></span></li><?php endforeach; ?></ul></div>
            <div class="next-steps"><p class="eyebrow">WHAT HAPPENS NEXT</p><h2>A conversation about your fleet.</h2><ol><li>Send us your FleetIQ enquiry.</li><li>We review what you need to manage.</li><li>We arrange a suitable conversation/demo.</li><li>We show the areas of FleetIQ most relevant to your operation.</li></ol></div>
        </aside>
    </div></section>
</main>
<?php require __DIR__ . '/components/footer.php'; ?>
