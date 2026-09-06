<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/components/icons.php';
$commercialPage = $legalPage = true;
$pagePath = 'terms.php';
$pageTitle = 'Website Terms of Use | FleetIQ';
$pageDescription = 'Terms for using the FleetIQ website, including informational content, conceptual product visuals, acceptable use, intellectual property and external links.';
require __DIR__ . '/components/header.php';
?>
<main id="main" class="commercial-page" tabindex="-1">
    <section class="commercial-hero dark-section"><div class="container"><p class="eyebrow">USING THIS WEBSITE</p><h1>Website terms of use</h1><p class="commercial-lead">Information about using the FleetIQ website and its content.</p><p class="legal-updated">Last updated: 6 September 2026</p></div></section>
    <section class="section"><div class="container legal-copy">
        <h2>About these terms</h2>
        <p>These terms cover use of the FleetIQ website. They do not form a software licence, subscription agreement, service level agreement or customer contract. Requesting a demo does not create a subscription or payment obligation. Questions about the website can be sent to <a href="mailto:<?= escape(SITE_CONTACT_EMAIL) ?>"><?= escape(SITE_CONTACT_EMAIL) ?></a>.</p>
        <h2>Website information</h2>
        <p>The website provides general information about FleetIQ. Please discuss your requirements with us and confirm relevant functionality before relying on it for a purchasing or operational decision. Conceptual product views use illustrative data and are not live application screenshots.</p>
        <p>Fleet and compliance information is general information, not legal or regulatory advice. Requirements vary by operation. References to published guidance do not imply approval or endorsement by a regulator, or guarantee compliance.</p>
        <h2>Content and intellectual property</h2>
        <p>The FleetIQ name, branding and website content are protected by applicable intellectual property rights belonging to their respective owners. You may view the site and retain reasonable extracts for personal or internal business reference, keeping any attribution and accuracy notices. Do not misrepresent the content or suggest an endorsement or association without permission. Other uses may require the relevant rights holder's consent.</p>
        <h2>Acceptable use</h2>
        <p>Use the website lawfully. Do not attempt unauthorised access, introduce malicious code, disrupt the service or send spam or misleading enquiries. Do not submit personal information you are not entitled to share. The enquiry form is intended for FleetIQ enquiries, not for uploading sensitive operational records.</p>
        <h2>Availability and external links</h2>
        <p>We aim to keep the site useful and available, but it may change or be unavailable for maintenance or other reasons. We cannot promise uninterrupted or error-free access. Links to other websites are provided for information; those sites have their own content, terms and privacy arrangements.</p>
        <h2>Responsibility</h2>
        <p>We take reasonable care with website information, but it may not cover every circumstance or remain current. Take appropriate advice where a decision depends on legal, regulatory or operational requirements. Nothing in these terms excludes or limits liability where doing so would be unlawful, including liability for fraud or for death or personal injury caused by negligence, or removes rights that the law protects.</p>
        <h2>Privacy and changes</h2>
        <p>Our <a href="privacy.php">privacy policy</a> explains how website enquiries and necessary technical information are handled. We may update the website and these terms; the date above identifies this version.</p>
    </div></section>
</main>
<?php require __DIR__ . '/components/footer.php'; ?>
