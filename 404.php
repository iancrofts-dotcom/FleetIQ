<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/components/icons.php';
http_response_code(404);
$commercialPage = $notFoundPage = true;
$pageTitle = 'Page Not Found | FleetIQ';
$pageDescription = 'This FleetIQ page could not be found. Return to the homepage or explore FleetIQ fleet management features.';
require __DIR__ . '/components/header.php';
?>
<main id="main" class="commercial-page" tabindex="-1">
    <section class="commercial-hero dark-section"><div class="container"><p class="eyebrow">404</p><h1>Page not found.</h1><p class="commercial-lead">The page you're looking for may have moved or no longer exists.</p><div class="hero-actions"><a class="button" href="./">Return Home <?php icon('arrow'); ?></a><a class="button button-outline" href="features.php">Explore FleetIQ <?php icon('arrow'); ?></a></div></div></section>
</main>
<?php require __DIR__ . '/components/footer.php'; ?>
