<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/components/icons.php';
$commercialPage = $legalPage = true;
$pagePath = 'privacy.php';
$pageTitle = 'Privacy Policy | FleetIQ Website Enquiries';
$pageDescription = 'How FleetIQ handles website enquiries, necessary session cookies and technical information, with information about your privacy rights and how to contact us.';
require __DIR__ . '/components/header.php';
?>
<main id="main" class="commercial-page" tabindex="-1">
    <section class="commercial-hero dark-section"><div class="container"><p class="eyebrow">YOUR INFORMATION</p><h1>Privacy policy</h1><p class="commercial-lead">How we handle information when you visit this website or contact FleetIQ.</p><p class="legal-updated">Last updated: 6 September 2026</p></div></section>
    <section class="section"><div class="container legal-copy">
        <h2>Who to contact</h2>
        <p>The FleetIQ website operator is responsible for the personal information handled through this website. For privacy questions or to exercise your rights, email <a href="mailto:<?= escape(SITE_CONTACT_EMAIL) ?>"><?= escape(SITE_CONTACT_EMAIL) ?></a>. This notice covers the website and its enquiry form, rather than data held within a customer's fleet management system.</p>
        <h2>Information we handle</h2>
        <p>When you send an enquiry, we receive your name, company, email address, phone number and fleet size, plus any industry or fleet type and message you choose to provide. Please do not send sensitive driver records or vehicle documents through this form.</p>
        <p>The web server necessarily processes technical information to deliver and protect the site. Hosting logs may include IP addresses, browser information, requested pages, dates, times and errors. We do not add analytics, advertising trackers or a newsletter subscription.</p>
        <h2>Why we use it</h2>
        <p>We use enquiry information to respond, understand the fleet requirements you describe and arrange a relevant conversation or demo. Our lawful basis is our legitimate interest in responding to business enquiries. We also have a legitimate interest in keeping the website secure and investigating faults or misuse. Where a legal obligation requires information to be retained or disclosed, we use it for that purpose.</p>
        <p>Sending an enquiry does not sign you up for marketing. We do not automatically add your details to a mailing list or use this form for automated decision-making or profiling.</p>
        <h2>Necessary session cookie</h2>
        <p>The contact page uses a necessary cookie named <strong>fleetiq_enquiry</strong> to protect the form against forged submissions and show the result after submission. It contains a session identifier, not the text of your enquiry. It is intended to last for your browser session; browser restore settings may retain session cookies.</p>
        <p>After an unsuccessful submission, safe form values are held in the server session so you can retry. They are removed from that stored result when the next page displays them; unused results expire from use after 30 minutes. Physical session cleanup also depends on the hosting configuration. No analytics or advertising cookies are set by the website.</p>
        <h2>Service providers and sharing</h2>
        <p>Hosting and email services process information needed to operate the website and deliver and store enquiries. Access should be limited to those who need it to provide those services or respond to your request. We do not sell enquiry information. Information may also be disclosed where the law requires it.</p>
        <p>Processing locations depend on the hosting and email services used. Contact us for details of the providers, any processing outside the UK and the protections applicable to your enquiry.</p>
        <h2>Retention and security</h2>
        <p>We keep enquiry correspondence only as long as reasonably needed to respond and complete relevant follow-up, taking account of any continuing discussion, legal obligations or dispute. Technical and security records should be kept only for the period needed to operate and protect the service. Contact us if you would like information about retention of a particular enquiry.</p>
        <p>We use form validation and access controls to help protect information. Hosting, mailbox access and retention arrangements also matter; no internet transmission or storage system can be guaranteed completely secure.</p>
        <h2>Your rights</h2>
        <p>Depending on the circumstances, you can ask to access or correct your personal information, request deletion or restrict its use. You can also object to processing based on legitimate interests. These rights are subject to the conditions and exceptions in data protection law.</p>
        <p>Contact us using the email above so we can consider your request. We may need proportionate information to confirm your identity. You can read more about your rights from the <a href="https://ico.org.uk/for-the-public/">Information Commissioner's Office</a> and <a href="https://ico.org.uk/make-a-complaint/">raise a concern with the ICO</a>.</p>
        <h2>Changes to this notice</h2>
        <p>We will update this notice if the website's handling of personal information changes. The date above identifies the current version.</p>
    </div></section>
</main>
<?php require __DIR__ . '/components/footer.php'; ?>
