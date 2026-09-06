<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/components/icons.php';
$commercialPage = true;
$pagePath = 'about.php';
$pageTitle = 'About FleetIQ | Practical UK Fleet Management Software';
$pageDescription = 'FleetIQ is designed around practical UK fleet operations, bringing vehicle, driver, compliance, document and workshop information together.';
require __DIR__ . '/components/header.php';
?>
<main id="main" class="commercial-page" tabindex="-1">
    <section class="commercial-hero dark-section"><div class="container about-intro">
        <p class="eyebrow">BUILT AROUND FLEET OPERATIONS</p>
        <h1>Fleet management<br> <span class="gradient-text">should be clearer.</span></h1>
        <p class="commercial-lead">FleetIQ is designed to bring vehicle, driver, compliance, document and workshop information together in one practical system.</p>
        <div class="hero-actions"><a class="button" href="contact.php">Book a Demo <?php icon('arrow'); ?></a><a class="button button-outline" href="features.php">Explore FleetIQ <?php icon('arrow'); ?></a></div>
    </div></section>
    <section class="section"><div class="container editorial-layout">
        <div><p class="eyebrow">WHY FLEETIQ</p><h2>Fleet work is connected.<br>The information should be too.</h2></div>
        <div><p>Important dates can sit in separate calendars. Vehicle records can be kept apart from workshop activity, while driver documents need another spreadsheet. A completed inspection may leave a repair to be followed up somewhere else.</p><p>That separation makes it harder to see what needs attention. FleetIQ is designed around these practical requirements: a connected operational workspace where related records and work stay together.</p></div>
    </div></section>
    <section class="section commercial-light"><div class="container">
        <div class="section-heading"><div><p class="eyebrow">BUILT FOR REAL FLEET WORK</p><h2>Responsibilities overlap.<br>Keep the context.</h2></div><p>In small-to-medium UK fleet operations, the same people often look after vehicles, drivers, documents and repairs. FleetIQ brings those areas into view together.</p></div>
        <div class="operations-grid">
        <?php foreach ([['vehicle', 'Vehicles', 'fleet-vehicles.php'], ['users', 'Drivers', 'drivers-compliance.php'], ['shield', 'Compliance', 'drivers-compliance.php'], ['document', 'Documents', 'documents-reminders.php'], ['inspection', 'Inspections', 'workshop.php'], ['tool', 'Workshop', 'workshop.php'], ['check', 'Repairs', 'workshop.php'], ['chart', 'Reporting', 'reports.php']] as [$symbol, $label, $href]): ?>
            <a href="<?= escape($href) ?>"><?php icon($symbol); ?><span><?= escape($label) ?></span><?php icon('arrow'); ?></a>
        <?php endforeach; ?>
        </div>
    </div></section>
    <section class="section"><div class="container editorial-layout">
        <div><p class="eyebrow">UK FLEET OPERATIONS</p><h2>Designed with the work in mind.</h2></div>
        <div><p>FleetIQ is designed with UK fleet operations in mind: transport and haulage, construction and engineering, service and courier fleets, taxi/private hire, coach/minibus, and commercial and plant fleets.</p><p>Requirements differ by organisation, role and fleet type. A conversation about your operation helps establish which parts of FleetIQ are relevant to the work you need to manage.</p><a class="commercial-link" href="contact.php">Talk about your fleet <?php icon('arrow'); ?></a></div>
    </div></section>
    <section class="section commercial-light"><div class="container">
        <div class="section-heading"><div><p class="eyebrow">PRODUCT PRINCIPLES</p><h2>A practical system, with a clear purpose.</h2></div></div>
        <div class="principles-grid">
        <?php foreach ([['grid', 'Clear', 'See what needs attention.'], ['document', 'Connected', 'Keep related fleet information together.'], ['tool', 'Practical', 'Designed around everyday fleet tasks.'], ['globe', 'Accessible', 'Use FleetIQ across Windows, Web and Android.'], ['lock', 'Controlled', 'User permissions help control access to the system.']] as [$symbol, $title, $copy]): ?>
            <article class="principle-card"><div class="icon-box"><?php icon($symbol); ?></div><h3><?= escape($title) ?></h3><p><?= escape($copy) ?></p></article>
        <?php endforeach; ?>
        </div>
    </div></section>
    <section class="section dark-section"><div class="container editorial-layout">
        <div><p class="eyebrow">ONE CONNECTED FLEET</p><h2>One fleet.<br>One system.<br><span class="gradient-text">One source of truth.</span></h2></div>
        <div><p>Keep the vehicle, the driver, the important date and the work connected to the same operational picture.</p><div class="device-platforms"><span><?php icon('desktop'); ?> Windows</span><span><?php icon('globe'); ?> Web</span><span><?php icon('phone'); ?> Android</span></div><a class="text-link" href="mobile.php">Explore FleetIQ across devices <?php icon('arrow'); ?></a></div>
    </div></section>
    <?php require __DIR__ . '/components/demo-cta.php'; ?>
</main>
<?php require __DIR__ . '/components/footer.php'; ?>
