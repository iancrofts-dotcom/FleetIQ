# Homepage refinement validation

## Final restrained polish — 6 September 2026

- This pass changes only `assets/css/site.css` and this record, preserving the earlier uncommitted refinement. No markup, copy, JavaScript, pages, dependencies, commits or pushes changed.
- Benefits now use an understated `#f8fafb` background with white cards and existing borders. Benefits and Workshop bottom padding use `clamp(40px,5vw,64px)`: 90→64px on large desktops, 72→51.2px at 1024px, 60→40px at 768px, and 52→40px at 390px. Top padding and workflow content remain unchanged.
- Desktop footer uses two columns: branding/tagline on the left; navigation above the UK statement on the right. Main padding is 44→28px; legal-row padding is 22→12px with vertical centring. Removed the old 140px statement width constraint. Existing mobile stacking remains, with main padding 32→24px, navigation margin 26→16px, statement margin 18→12px and legal padding 20→12px. Link targets remain at least 44px tall. Large-desktop footer height is approximately 249→197px; at 390px it is 331→283px.
- Re-ran Chrome layout checks at 1920, 1680, 1440, 1366, 1201, 1200, 1199, 1101, 1100, 1099, 1024, 769, 768, 767, 601, 600, 599, 481, 480, 479, 390 and 320px. All 22 have no horizontal overflow or elements escaping page bounds. Hero dashboard remains unclipped and Android remains contained. Compared hero position/dimensions, workflow height and multi-device visual height with the start-of-pass CSS: unchanged. Benefits retain three columns on desktop and one through 600px. Final CTA height remains 52px, or 50px at narrow mobile widths.
- Inspected Chrome screenshots of desktop Benefits, Workshop-to-devices transition and CTA/footer, plus the 390px CTA/footer stack. Other section spacing was left alone.
- CSS application, duplicate-ID checks, internal anchor targets, Menu state, Product disclosure, custom Escape handling, section-link closing and Book a Demo open/close passed at all 22 widths. Dialog focus restoration remains inconclusive in the virtual-time fixture at 390px; normal-browser keyboard testing remains necessary. `git diff --check` passed.
- PHP is still unavailable on PATH; PHP lint was not run. These are front-end checks of the existing temporary HTML fixture with repository CSS/JS, not PHP execution. Cross-browser and real-device touch checks remain unperformed. Temporary evidence is under `%TEMP%/fleetiq-refinement-qa/polish-*`.

## Targeted spacing refinement — 6 September 2026

This section records the current pass; the sections below describe earlier work and its environment.

- Changed `assets/css/site.css` and this validation record only. No pages, dependencies, commits or pushes added.
- At 1101px and wider: hero top padding reduced from 40px to 28px; copy top padding from 28px to 12px; standalone FleetIQ bottom margin from 12px to 8px. The dashboard moves up 12px, copy content up 28px, and the main headline up 32px. The existing approximately 40/60 grid, top alignment and dashboard dimensions remain. No hero minimum height or viewport-height sizing was present.
- At 600px and narrower: Benefits use `minmax(0,1fr)`, extending the existing 480px single-column rule. Benefits container has 18px side gutters; heading/intro children are constrained to the available width and may wrap naturally; card children may shrink within their grid. Existing icons, borders, radii and font sizes remain.
- Headless Chrome layout checks: 1920, 1680, 1440, 1366, 1201, 1200, 1199, 1101, 1100, 1099, 1024, 769, 768, 767, 601, 600, 599, 481, 480, 479, 390 and 320px. Iframes have normal 15px vertical scrollbars; media queries use the requested viewport width.
- All 22 widths: document scroll width equals client width; no visible elements escape horizontal page bounds; no dashboard descendants cross an overflow-clipping ancestor; Android stays inside the hero-product container. Dashboard widths match the before-change fixture. Benefits are one column through 600px; heading and intro remain inside the gutters. At 390px the headline remains 42.12px, dashboard metrics remain 2×2, and hero CTAs are 165×50px.
- Visually inspected the 1680px desktop hero and 390px mobile hero/Benefits screenshots. Upcoming Dates retains its mobile layout and readable labels. The approved Android overlap remains.
- All widths: scripted Menu state, Product open/Escape, menu Escape, section-link menu closing, matching anchor targets, and demo dialog opening/close-button checks passed. Dialog focus restoration was inconsistent in the virtual-time headless harness, so that check is inconclusive and needs a normal browser check. No navigation or JavaScript files changed.
- PHP is unavailable on PATH and absent from checked common PHP/XAMPP locations. PHP lint was not run. Browser checks use the existing temporary, manually expanded HTML fixture with the actual repository CSS and JavaScript, not PHP output. PHP execution, trusted native dialog Escape, real touch input and other browsers remain unverified.
- `git diff --check` passed. Temporary harnesses, measurements and screenshots are outside the repository under `%TEMP%/fleetiq-refinement-qa` (`spacing-*` and `interaction-*`).

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
