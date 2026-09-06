# Homepage refinement validation

## Phase 3 — About and Contact / Book a Demo — 6 September 2026

### Scope and repository state

Started in `C:/Users/iancr/FleetIQ`, branch `main`. The working tree initially contained the approved, uncommitted Phase 2 work; this was preserved. Phase 2 was committed externally during this pass (`60abe0a`). The unrelated `workshop.zip` deletion was not made or altered by this work. No commit or push was performed by the agent.

Created `about.php`, `contact.php`, `assets/css/commercial.css`, `includes/enquiry.php`, `includes/enquiry-delivery.php`, `includes/contact-request.php` and `tests/enquiry-test.php`.

Modified shared header/navigation/footer/demo CTA, the product-page CTA, the homepage demo link, config, shared JavaScript, sitemap and documentation. Approved homepage/product layouts and their stylesheets remain unchanged. The homepage change is only the demo href; shared navigation now has real About/Contact destinations. No framework, database, analytics, CAPTCHA, newsletter or additional commercial pages added.

### Pages and conversion journey

- About is product-led: the disconnected-records problem, overlapping operational responsibilities, relevant UK fleet sectors, five product principles and one connected fleet. It states FleetIQ is being developed around practical requirements and makes no corporate-history, customer or regulatory claims. It reuses existing icons, cards, spacing, colours and CTA; no new mockup was necessary.
- Contact has a compact navy introduction, a white enquiry panel, relevant demo topics and an accurate four-step next-steps explanation. Required fields: name, company, email, phone and fleet size. Industry and the help/message field are optional. Fleet ranges end in 251+ to avoid overlapping the 101–250 range.
- Every Book a Demo link now targets `contact.php`; the placeholder demo dialog is removed. Privacy/Terms remain labelled development notices. Privacy wording was corrected to acknowledge the form and its necessary security session cookie, without inventing a full policy or marketing consent.

### Form architecture, delivery and security

- `includes/config.php` holds the confirmed recipient `iancrofts@live.co.uk`. `FLEETIQ_DEMO_RECIPIENT` is an optional controlled override. `FLEETIQ_DEMO_FROM` has no invented default and must be a host-authorised fixed mailbox. `FLEETIQ_DEMO_TRANSPORT` supports `mail` or `disabled`.
- Validation and message transport are separate. The PHP mail adapter is replaceable with authenticated SMTP later. From is fixed configuration, Reply-To is the validated visitor address, subject text is bounded RFC 2047 encoding, and the UTF-8 plain-text body is base64 transfer-encoded. All requested fields and a UTC timestamp are included. The full company name remains in the body even if its subject representation needs shortening.
- Missing sender/invalid config/disabled transport returns false. A safe availability message is shown when configuration is incomplete. Mail failures/exceptions produce a generic error with safe values retained; no technical exception or mail configuration detail is shown. Success is created only when the adapter returns strict true, meaning transport acceptance rather than guaranteed inbox delivery.
- Validation trims scalar UTF-8 input, enforces field limits and allowed select values, validates email/phone, and rejects control characters, arrays, unknown fields and malformed/oversized POST bodies. User output is escaped. The honeypot and constant-time CSRF comparison run before transport. CSRF tokens use 32 random bytes and rotate on success.
- Only Contact starts a session. Cookies use HttpOnly, SameSite=Lax and Secure when HTTPS is reported by PHP. Responses are no-store. POST uses HTTP 303 PRG for both success and errors; GET cannot fabricate success. Safe failure values are one-time session state and expire logically after 30 minutes. Private session storage, HTTPS forwarding and physical session retention remain hosting responsibilities.

### Tests actually run

- PHP 8.4.25 lint: all 24 PHP files passed, including the CLI-only test file.
- `php tests/enquiry-test.php`: 48 checks passed with fake transport callbacks; no messages sent. Includes required/optional fields, malformed input, UTF-8/control characters, length limits, selects, honeypot, CSRF, header injection, failure/exception handling, output escaping and encoded message construction.
- Local HTTP tests: 36 checks passed against the actual application with missing sender configuration. Covered required fields, bad email, CSRF, honeypot, arrays, injection, overlong/oversized requests, escaped preserved values, generic delivery failure, method 405 handling and one-time PRG state. No delivery attempted to the real recipient.
- Isolated PHP server plus a loopback-only SMTP sink: 10 checks passed. Config used reserved `example.invalid` sender/recipient addresses only. SMTP acceptance produced the requested confirmation and cleared personal values; success flashed once and rotated CSRF; replay was rejected. SMTP rejection produced a generic failure and retained values. Captured message headers/body contained the expected test data, fixed From, validated Reply-To and UTC timestamp. **No email was sent externally or to the confirmed real recipient.**
- Browser matrix: all ten pages at 1920, 1680, 1440, 1366, 1201, 1200, 1101, 1100, 1024, 769, 768, 601, 600, 481, 480, 390 and 320px (170 cases). No horizontal overflow or elements outside horizontal bounds after correcting a mobile line-break whitespace issue. No duplicate IDs or missing assets. All ten pages return 200, have one H1 and unique title/description metadata. No old demo dialog or misrouted Book a Demo link remains.
- Error layout checks at all nine requested widths plus 320px (10 cases): five required-field errors correctly associated, error-summary focus applied after PRG, no overflow. The Contact layout and form fields stack on mobile; inputs use 16px text and are at least 49px tall in the checked layout.
- 60 real navigation cases: About, Contact and header Book a Demo from every page at 1440 and 390px reached the intended destination with mobile menu closed. Every page/fragment link and CSS/JS/icon reference resolves.
- Trusted Chrome keyboard checks at 1440 and 390px: menu and Product disclosure activation, Tab into dropdown, Escape, form label/field order, visible focus and privacy-dialog open/Escape/focus restoration passed. PRG error focus initially lost to fragment navigation; a scoped `pageshow` handler now focuses the server-result panel. All ten subsequent error-state focus checks passed. No console/runtime errors captured in the new-page keyboard run.
- New form input borders were adjusted to 3.29:1 against white; body text is 5.64:1 and error text 7.01:1 against white. Existing focus and reduced-motion rules are reused. Role/status feedback, required attributes, labels, autocomplete and error-describedby relationships are present. This is not a complete accessibility certification.
- About/Contact canonical and OG URL checks passed with a configured sample subdirectory origin. Sitemap XML has all ten routes. With the live config still empty, canonical/OG URLs remain intentionally omitted and the sitemap retains its clearly documented reserved placeholder origin.
- Reviewed desktop/mobile About and Contact screenshots and a mobile error state. `git diff --check` passed.

### Production configuration and remaining limits

The enquiry recipient is configured, but **real delivery is not yet enabled/verified**: provide `FLEETIQ_DEMO_FROM` and a host-supported mail transport, then verify real mailbox receipt. PHP mail may be disabled or unreliable on free hosting; README documents the adapter replacement path, authorised sender/domain requirements, and the distinction between transport acceptance and inbox delivery. No live recipient test was performed.

Configure the public origin/sitemap/robots, HTTPS/error handling and private session storage. Complete operator/privacy/terms and retention arrangements before public collection. No response time is promised. Firefox/Safari, real devices, screen readers and a full accessibility/zoom audit remain untested. The confirmation was verified against a local SMTP sink, not a production provider.

Temporary evidence is under `%TEMP%/fleetiq-phase3-qa`. The two production page stylesheets from earlier phases were not redesigned. No commits or pushes were made.

## Final Phase 2 pre-commit QA — 6 September 2026

**Result: suitable to commit as the approved Phase 2 implementation. No application-code correction was required. Only this validation record changed during this QA pass.** The existing uncommitted Phase 2 files remain intact; no commit or push was performed.

### Navigation and responsive checks

- Rechecked the actual PHP-rendered homepage and seven product pages in Chrome at 1920, 1680, 1440, 1366, 1201, 1200, 1101, 1100, 1024, 769, 768, 601, 600, 481, 480, 390 and 320px: 136 page/viewport cases, including all nine requested widths.
- No document horizontal overflow, visible elements outside horizontal bounds, conceptual-interface descendants crossing clipping ancestors, or overlapping siblings in hero layouts, card grids, workflow stages, record grids, UI headers/rows, CTA groups and footer rows. Heading wrapping stays within the layout; cards and workflows retain their approved mobile stacking. CTA targets remain 50–52px tall, and all three product-page platform labels remain visible.
- All internal links, relative paths, fragment targets and asset references resolve. Features links target `features.php`; header/footer logos target the homepage; About/Contact remain homepage section links. Footer Privacy and Terms dialogs open and close on every product page.
- Executed every one of the six Product destinations from all eight starting pages at 1440 and 390px: 96 real cross-page navigation cases passed. Each case also checked the closed menu on arrival, return to the homepage About anchor and header Book a Demo opening/closing. The responsive matrix separately checks mobile Menu, Product disclosure, custom Escape and final CTA demo behaviour.

### Accessibility, consistency and spacing

- Used Chrome DevTools Protocol trusted key input on every product page at 1440 and 390px (14 cases). Passed: mobile Menu activation with Enter, Product activation with Enter, Tab to its first link, visible keyboard focus, Escape closing Product and restoring summary focus, mobile menu Escape restoring toggle focus, keyboard demo opening, native dialog Escape and focus restoration to the initiating hero CTA. Tab did not focus background page controls while the modal was open. Native Chrome may move focus through browser chrome when tabbing past the dialog's only control; this is not an application focus escape.
- This trusted-input check resolves the earlier inconclusive hero-demo Escape/focus result for the tested Chrome cases. It does not certify every browser or every possible modal opener.
- All links/buttons/disclosures have text or an accessible label. ARIA controls/labelled-by references resolve, there are no duplicate IDs, and main-content H1/H2/H3 levels have no skipped levels. Native details/summary and dialog semantics remain in use. Decorative icons retain `aria-hidden`.
- Emulated reduced motion on all seven pages: smooth scrolling becomes `auto` and button transition duration becomes zero.
- Sampled text contrast ratios: white CTA text 5.27:1; body on white 5.64:1; UI muted text 5.25:1; blue/amber/red/green status labels 4.93/5.33/5.01/4.88:1; conceptual caption on navy 8.28:1; Android kicker 5.10:1. All sampled pairs exceed 4.5:1. These samples are not a complete WCAG audit of every gradient or state.
- Shared hero structure, typography, card borders/radii, CTA styles, palette, conceptual UI and footer remain consistent. Inspected spacing rules and rendered sections: product sections have no fixed/minimum section heights creating blank areas; spacing comes from approved padding and content. No spacing or aesthetic changes made.

### Product accuracy, SEO and technical results

- Audited the seven entry points, shared product templates and complete page-content JSON. No unsupported DVSA approval, guaranteed-compliance, tracking/GPS, telematics, routing, fuel, predictive/AI, integration, customer, testimonial or savings claims. The only guarantee-related match explicitly says recording a date does **not** guarantee legal compliance. No new DVSA statement is made by the Phase 2 content. The existing homepage's guidance wording remains unchanged.
- Each conceptual view retains its visible conceptual/illustrative caption; illustrative records and inspection progress are not represented as customers, performance statistics or live application screenshots.
- All eight pages have unique titles and descriptions, one H1, working internal links and Open Graph metadata. Configured canonical/OG URL tests passed for each product route, including an origin with a subdirectory. With the current empty configuration these URL tags are deliberately omitted.
- Sitemap XML parses and lists the homepage plus all seven existing product files. `robots.txt` has valid User-agent/Allow directives. Both remain deployment templates where the public origin is required: the sitemap uses `https://example.invalid`, and robots has no absolute Sitemap directive yet.
- PHP 8.4.25 lint passed for all 18 PHP files. All page and asset HTTP requests checked returned 200. No JavaScript console errors, browser log errors or uncaught runtime exceptions were captured while loading the seven pages through CDP. `git diff --check` passed.

### Limitations and commit readiness

Safe to commit the approved Phase 2 work. Public launch still requires the confirmed origin in config/sitemap/robots, a monitored demo email and approved operator/legal content. Demo remains the existing development notice; the interfaces remain conceptual. Firefox/Safari, real-device touch, screen readers and a complete zoom/contrast audit remain untested. No production-readiness or full accessibility-conformance claim is made.

Evidence is outside the repository under `%TEMP%/fleetiq-phase2-final-qa` (responsive, navigation, keyboard, semantics, console and baseline file-hash records). Baseline hashes confirmed that application files were unchanged during this pass. The temporary PHP runtime/server is from the preceding Phase 2 validation.

## Phase 2 — Core product pages — 6 September 2026

### Scope and implementation

Started on `main` in `C:/Users/iancr/FleetIQ` with a clean working tree. Created the seven requested PHP entry points, `components/product-page.php`, `components/product-visual.php`, `includes/product-pages.json` and `assets/css/product.css`. Updated shared header/navigation/footer, cross-page anchor focus handling, SEO, sitemap and documentation. `index.php` and `assets/css/site.css` are unchanged. No commits, pushes, frameworks or application dependencies added.

Features groups ten functional areas separately from the three platforms. Vehicle Details, driver requirements, workshop job progress, documents/upcoming dates and a workshop activity report use a shared readable record/row design. Mobile uses a monitor, browser record and Android inspection view. Every new visual has a visible conceptual/illustrative figcaption. Capability cards, related links and final demo CTA reuse the established design; Workshop retains the five numbered stages and green completion/history styling. Cards and workflows stack on mobile. No unsupported tracking, analytics, customer or compliance claims were introduced.

### Runtime and static validation

- Downloaded official portable PHP 8.4.25 NTS x64 into `%TEMP%/fleetiq-phase2-qa/php`; verified the archive SHA-256 against the official Windows PHP release manifest. It is a QA tool outside the repository, not an application dependency or global installation.
- All 18 PHP files passed `php -l`. All eight pages returned HTTP 200 from the PHP development server with no PHP warnings or errors detected in rendered output.
- All eight pages have unique titles/descriptions and exactly one H1. Open Graph title/description are sourced from the same page metadata. A separate PHP check with a configured sample subdirectory origin passed page-specific canonical and OG URL assertions for all seven product pages. Live preview configuration remains empty and emits neither URL tag.
- All internal page/fragment targets resolve; all referenced CSS, JS and image assets returned HTTP 200. No duplicate IDs found.
- Sitemap XML parses, contains all eight routes, and all corresponding files exist. The reserved `https://example.invalid` origin explicitly marks it as a deployment template. Replace it with the confirmed `SITE_URL` before publishing/submitting and set the robots sitemap URL.
- `git diff --check` passed. Homepage markup and shared stylesheet have no diff.

### Chrome responsive and interaction validation

Tested the actual PHP application, not a manually expanded fixture: all eight pages at 1920, 1680, 1440, 1366, 1201, 1200, 1101, 1100, 1024, 769, 768, 601, 600, 481, 480, 390 and 320px (136 page/viewport checks). Frames use normal vertical scrollbars, which reduce content width by 15px.

Passed across the matrix: document scroll width equals client width; no visible elements escape horizontal bounds; no product-visual/dashboard descendants cross clipping ancestors; CSS applies; IDs are unique; conceptual captions exist; Menu opens/closes; Product disclosure opens and closes on Escape; menu closes on Escape; final Book a Demo opens and closes its dialog. Product-page capability links reach their sections. Windows, Web and Android remain visible at every tested product-page width. Final CTA buttons remain 50–52px tall. Narrow-mobile capability cards use one column and workshop stages stack.

Additionally tested real cross-page clicks from all eight starting pages at 1440 and 390px (16 navigation cases): Product → Workshop loads the requested page with the menu closed; About returns to the homepage section; header Book a Demo opens its dialog and closes the mobile menu. All passed.

Inspected desktop hero screenshots for the platform, records, documents, reports and device compositions, plus mobile hero, capability and workshop workflow views. Screenshot review led to top-aligned internal hero copy, a more compact device composition, a separate Features platform group and an internal-page override for the inherited rule that hid the final platform label on mobile.

### Remaining limitations

- Production origin, monitored demo email and operator/legal content are still unset. Demo booking remains the existing development notice; no new submission system was requested.
- Conceptual interfaces are illustrative, static HTML, not working software controls or exact application screenshots. Compliance wording is scoped to relevant operations and does not guarantee compliance.
- Headless Chrome checks are not real-device or cross-browser certification. Trusted keyboard/native dialog Escape, screen readers, zoom and dialog focus restoration still need normal-browser testing. Prior headless focus-restoration results were inconsistent; this pass does not claim to resolve them.
- Temporary server, PHP runtime, harnesses, rendered measurements and screenshots are under `%TEMP%/fleetiq-phase2-qa`. Historical validation sections below describe earlier environments and do not supersede this PHP-enabled pass.

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
