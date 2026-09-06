<?php
require __DIR__ . '/../includes/config.php';
require __DIR__ . '/icons.php';
$productPages = json_decode(file_get_contents(__DIR__ . '/../includes/product-pages.json'), true, 512, JSON_THROW_ON_ERROR);
$page = $productPages[$productPage];
$pageTitle = $page['title'];
$pageDescription = $page['description'];
$pagePath = $productPage . '.php';
require __DIR__ . '/header.php';
?>
<main id="main" class="product-page" tabindex="-1">
    <section class="product-hero dark-section">
        <div class="container product-hero-layout">
            <div class="product-intro">
                <p class="eyebrow"><?= escape($page['eyebrow']) ?></p>
                <h1><?= escape($page['heading']) ?></h1>
                <p class="product-lead"><?= escape($page['intro']) ?></p>
                <div class="hero-actions">
                    <a class="button" href="#demo" data-dialog="demo">Book a Demo <?php icon('arrow'); ?></a>
                    <a class="button button-outline" href="#capabilities"><?= $productPage === 'features' ? 'Explore the features' : 'Explore the capabilities' ?> <?php icon('arrow'); ?></a>
                </div>
                <div class="hero-platforms"><span><?php icon('desktop'); ?> Windows</span><span><?php icon('globe'); ?> Web</span><span><?php icon('phone'); ?> Android</span></div>
            </div>
            <?php require __DIR__ . '/product-visual.php'; ?>
        </div>
    </section>
    <section class="section product-capabilities" id="capabilities">
        <div class="container">
            <div class="section-heading"><div><p class="eyebrow">PRACTICAL FLEET MANAGEMENT</p><h2><?= escape($page['section']) ?></h2></div><p><?= escape($page['sectionIntro']) ?></p></div>
            <div class="product-card-grid <?= $productPage === 'features' ? 'product-overview-grid' : '' ?>">
                <?php foreach ($productPage === 'features' ? array_slice($page['cards'], 0, 10) : $page['cards'] as $card): ?>
                <article class="benefit-card"><div class="icon-box"><?php icon($card[0]); ?></div><h3><?= escape($card[1]) ?></h3><p><?= escape($card[2]) ?></p>
                    <?php if (!empty($card[3])): ?><a class="product-card-link" href="<?= escape($card[3]) ?>">Explore <?= escape($card[1]) ?> <?php icon('arrow'); ?></a><?php endif; ?>
                </article>
                <?php endforeach; ?>
            </div>
            <?php if ($productPage === 'features'): ?>
            <div class="product-platform-overview"><h2>Windows. Web. Android.</h2><p>FleetIQ where your fleet work happens.</p><div class="product-card-grid">
                <?php foreach (array_slice($page['cards'], 10) as $card): ?>
                <article class="benefit-card"><div class="icon-box"><?php icon($card[0]); ?></div><h3><?= escape($card[1]) ?></h3><p><?= escape($card[2]) ?></p><a class="product-card-link" href="mobile.php">Explore <?= escape($card[1]) ?> <?php icon('arrow'); ?></a></article>
                <?php endforeach; ?>
            </div></div>
            <?php endif; ?>
        </div>
    </section>
    <section class="section product-workflow">
        <div class="container">
            <div class="center-heading"><p class="eyebrow">IN EVERYDAY USE</p><h2><?= escape($page['workflowTitle']) ?></h2><p><?= escape($page['workflowIntro']) ?></p></div>
            <ol class="workflow product-steps <?= count($page['steps']) === 5 ? 'product-steps-five' : '' ?>">
                <?php foreach ($page['steps'] as $index => $step): ?>
                <li><div class="workflow-icon"><?php icon($step[0]); ?><span><?= $index + 1 ?></span></div><h3><?= escape($step[1]) ?></h3><p><?= escape($step[2]) ?></p></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>
    <section class="section product-related">
        <div class="container"><div class="section-heading"><div><p class="eyebrow">CONNECTED CAPABILITIES</p><h2>Keep the wider fleet in view.</h2></div><p>Explore the records and workflows that connect to <?= escape($page['nav']) ?>.</p></div>
            <div class="product-card-grid">
            <?php foreach ($page['related'] as $key): $related = $productPages[$key]; ?>
                <a class="product-related-card" href="<?= escape($key) ?>.php"><?php icon($related['icon']); ?><h3><?= escape($related['nav']) ?></h3><p><?= escape($related['heading']) ?></p><span>Explore <?php icon('arrow'); ?></span></a>
            <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php require __DIR__ . '/demo-cta.php'; ?>
</main>
<?php require __DIR__ . '/footer.php'; ?>
