<footer class="site-footer"><div class="container footer-main"><div><a href="./" class="brand-link" aria-label="FleetIQ home"><?php brand(); ?></a><p>Smarter Fleet Management</p></div><nav aria-label="Footer navigation"><a href="features.php">Product</a><a href="features.php">Features</a><a href="./#about">About</a><a href="./#contact">Contact</a></nav><span class="footer-location">Built around UK fleet operations.</span></div><div class="container footer-bottom"><span>© <?= date('Y') ?> FleetIQ. All rights reserved.</span><div><a href="#privacy" data-dialog="privacy">Privacy</a><a href="#terms" data-dialog="terms">Terms</a></div></div></footer>
<section class="notice-panel" id="demo" aria-labelledby="demo-title"><button class="dialog-close" type="button" aria-label="Close dialog">×</button><p class="eyebrow">FLEETIQ DEMO</p><h2 id="demo-title">Let’s talk about your fleet.</h2>
<?php if (DEMO_EMAIL !== ''): ?>
<p>Tell us about your fleet and what you would like to see. We’ll help arrange a demonstration.</p><a class="button" href="mailto:<?= escape(DEMO_EMAIL) ?>?subject=FleetIQ%20demo%20enquiry">Email a demo enquiry <?php icon('arrow'); ?></a>
<?php else: ?>
<p>Demo booking will be available here soon. This website is in development; no enquiry has been submitted.</p>
<?php endif; ?></section>
<section class="notice-panel" id="privacy" aria-labelledby="privacy-title"><button class="dialog-close" type="button" aria-label="Close dialog">×</button><h2 id="privacy-title">Privacy notice</h2><p>The full privacy notice will be added before launch, once operator and hosting details are confirmed. This preview has no enquiry form, analytics or advertising cookies.</p></section>
<section class="notice-panel" id="terms" aria-labelledby="terms-title"><button class="dialog-close" type="button" aria-label="Close dialog">×</button><h2 id="terms-title">Website terms</h2><p>Website terms will be published before launch. Product visuals on this preview are conceptual and use illustrative data; they are not application screenshots.</p></section>

</body>
</html>
