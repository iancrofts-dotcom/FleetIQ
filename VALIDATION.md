# Homepage refinement validation

## Scope and environment

Reviewed index.php, every component and include, CSS, JavaScript, the favicon, robots.txt, sitemap.xml and existing documentation. Git status reports that this folder is not a Git repository, so Git diff/check is unavailable. PHP is unavailable; PHP lint has not passed or been run. No new website pages, dependencies, commits or pushes were added.

## Changes reviewed

- Desktop hero: copy beside a dominant dashboard, with an Android inspection view. Removed the decorative hero aside and its unused styling.
- Compact 80 px desktop header; native Product disclosure links to existing homepage sections. Header remains non-sticky.
- Dashboard: explicit On the road / In workshop labels, clearer heading and higher-contrast supporting text. All figures remain illustrative.
- Intelligence showcase: added open defects and an explicit compliance-status summary.
- Multi-device showcase: added a labelled browser record alongside Windows and Android. Small-screen device views use normal flow and larger type.
- Feature grid retains two complete rows of five at desktop and five complete rows of two on mobile. Tablet feature copy is larger; benefit headings wrap more consistently.
- Notice sections progressively enhance into native dialogs; no-JavaScript links now lead to visible content. Keyboard menu selection moves focus to its destination, and closing a dialog returns focus to a visible trigger.
- Footer links have a minimum 44 px height. Darkened primary button blue and muted text; added forced-colours handling. Reduced-motion support remains.
- Formatted added CSS for editing, removed unused decorative rules and avoided external resources or libraries.

## Validation actually performed

### Static checks

Passed: unique literal IDs, matching internal anchor targets, all PHP include targets, local CSS/JS/SVG paths, XML parsing of favicon and sitemap, one H1, and absence of prohibited former branding or DVSA approval / real-time-sync claims. Reviewed metadata: homepage title, description, Open Graph type/title/description/locale, and conditional canonical/OG URL output are present. The unconfigured origin emits no invented public URL.

Reviewed grid collapse, fixed dimensions, absolute device positioning, navigation wrapping, CTA wrapping, footer layout and minimum-width handling. No 100vw layout or oversized page minimum width was introduced.

### Chrome preview checks

PHP could not render the site. A temporary HTML fixture was expanded from the literal PHP template content for the current empty-domain/empty-demo-email configuration. It uses the actual local CSS, JavaScript and favicon. This is a front-end fixture, not PHP output or a new website page.

In headless Chrome, the fixture was checked at iframe viewport widths of **1440, 1200, 1101, 1024, 769, 768, 601, 600, 481, 480, 390 and 320 px**. Vertical scrollbars reduce content width normally.

Passed at every width:

- Document scroll width equals client width; no visible elements detected beyond horizontal page bounds.
- One H1, no duplicate IDs, and no missing anchor targets.
- Real stylesheet applied and real site JavaScript parsed/executed successfully.
- Menu ARIA state changes, Product disclosure opens, Escape closes Product then mobile navigation, and selecting a section link closes navigation.
- Demo dialog opens and closes through its close button; focus returns to the trigger after the asynchronous close event.

Reviewed a full desktop screenshot, desktop hero screenshot and a 390 px iframe mobile screenshot. The first narrow standalone Chrome screenshot used Chrome's minimum window layout width, so mobile conclusions use the explicitly sized iframe instead.

A separate fixture without site JavaScript passed: navigation visible, native Product disclosure opens, all three notice sections visible and no horizontal overflow at 390 px.

Selected contrast calculations passed 4.5:1: white CTA text on blue 5.27:1; muted text on white 5.64:1; muted text on light grey 5.25:1; hero secondary text on navy 7.73:1; dark-section body text on navy 9.04:1. These are sampled foreground/background pairs, not a complete WCAG audit of every gradient, icon or mockup label.

Temporary harnesses and screenshots are outside the project in the current user's temporary directory under `fleetiq-refinement-qa`.

## Remaining verification and launch inputs

- Run PHP lint and serve the actual application; the fixture cannot validate PHP syntax, include execution or runtime-generated output.
- Test the configured SITE_URL and DEMO_EMAIL branches on PHP hosting.
- Complete manual keyboard, native dialog Escape/backdrop, screen-reader, zoom/reflow and real-device touch testing. The scripted Escape test covered custom navigation behaviour; it did not simulate a trusted native dialog Escape keypress.
- Test current Firefox, Safari and Android browsers. Headless Chrome fixture checks are not cross-browser certification.
- All dashboard, inspection, attention, Windows/Web/Android visuals remain conceptual; no real screenshots were supplied.
- Supply demo email, operator/legal copy and production origin, then populate the sitemap and robots sitemap URL before launch. The sitemap is an XML-valid deployment template, not ready for submission.

On a PHP-enabled machine:

```powershell
Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
php -S 127.0.0.1:8080
```

## Files changed in this refinement

- index.php
- components/dashboard.php
- components/navigation.php
- components/footer.php
- assets/css/site.css
- assets/js/site.js
- README.md
- VALIDATION.md
