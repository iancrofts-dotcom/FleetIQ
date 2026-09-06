<!doctype html>
<html lang="en-GB">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= escape($pageTitle ?? 'FleetIQ | Fleet Management Software UK') ?></title>
    <?php require __DIR__ . '/../includes/seo.php'; ?>
    <link rel="icon" href="assets/icons/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="assets/css/site.css">
    <script src="assets/js/site.js" defer></script>
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header">
    <div class="container header-inner">
        <a href="./" class="brand-link" aria-label="FleetIQ home"><?php brand(); ?></a>
        <?php require __DIR__ . '/navigation.php'; ?>
    </div>
</header>
