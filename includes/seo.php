<?php
$pageTitle = $pageTitle ?? 'FleetIQ | Fleet Management Software UK';
$pageDescription = $pageDescription ?? 'Fleet management software for UK businesses. Bring vehicles, drivers, compliance, documents and workshop tasks together with FleetIQ on Windows, Web and Android.';
?>
<meta name="description" content="<?= escape($pageDescription) ?>">
<meta name="theme-color" content="#0b1e32">
<meta property="og:title" content="<?= escape($pageTitle) ?>">
<meta property="og:description" content="<?= escape($pageDescription) ?>">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_GB">
<?php if (!empty($notFoundPage)): ?><meta name="robots" content="noindex, follow"><?php endif; ?>
<?php if (SITE_URL !== '' && empty($notFoundPage)): ?>
<link rel="canonical" href="<?= escape(rtrim(SITE_URL, '/') . '/' . ($pagePath ?? '')) ?>">
<meta property="og:url" content="<?= escape(rtrim(SITE_URL, '/') . '/' . ($pagePath ?? '')) ?>">
<?php endif; ?>
