# FleetIQ website — Phase 3

Framework-free PHP website with the approved homepage, seven core product pages, About and Contact/Demo. Custom CSS and vanilla JavaScript; no build step or application dependencies. Requires PHP 8.1 or newer.

```sh
php -S 127.0.0.1:8080
```

Open http://127.0.0.1:8080. PHP must execute the templates; opening PHP files directly does not render the website.

## Pages

- `index.php`: approved homepage.
- `features.php`: platform overview, ten functional areas and Windows/Web/Android.
- `fleet-vehicles.php`: vehicle records, assignments, documents and dates.
- `drivers-compliance.php`: driver records and operation-specific requirements.
- `workshop.php`: inspection → defect → repair job → completion → history/reporting.
- `documents-reminders.php`: documents, expiry dates, calendar and reminders.
- `reports.php`: recorded vehicle, inspection and workshop activity.
- `mobile.php`: Windows, Web and Android usage.

- `about.php`: product-led background, operational context and principles.
- `contact.php`: secure demo enquiry form and next steps.

Pricing, Login, Customer Stories, Resources and Security pages are not built.

## Shared structure

- `components/header.php`, `navigation.php`, `footer.php`: global shell and navigation.
- `components/demo-cta.php`: shared final CTA.
- `components/icons.php`: SVG icon and FleetIQ brand helpers.
- `components/product-page.php`: reusable product-page layout, capability cards, workflow and related links.
- `components/product-visual.php`: accessible HTML conceptual record/activity and device views.
- `includes/product-pages.json`: page-specific titles, descriptions, copy, visual records and relationships. Keep content within confirmed product scope. All output is escaped by the PHP renderer.
- `includes/config.php`: public origin, demo email and escaping helper.
- `includes/seo.php`: page-aware description, canonical and Open Graph metadata.
- `assets/css/site.css`: approved shared design system; unchanged in Phase 2.
- `assets/css/product.css`: internal-page-only layouts; loaded only on product pages.
- `assets/js/site.js`: mobile menu, Product disclosure, legal dialogs and focus for server-side form results.
- `assets/css/commercial.css`: About and Contact layouts, form and feedback styling; loaded only on those pages.
- `includes/enquiry.php`: field definitions, validation and a transport-independent submission service.
- `includes/enquiry-delivery.php`: message construction and replaceable PHP mail adapter.
- `includes/contact-request.php`: contact-only session, CSRF, POST handling and PRG state.
- `tests/enquiry-test.php`: CLI validation/security tests using fake transport callbacks; never sends email.

Each product entry point selects a fixed content key. Adding a capability to an existing page generally requires only editing its content in the JSON file. Record visuals are semantic HTML with visible conceptual/illustrative captions, not simulated interactive application controls.

## Before deployment

1. Set `SITE_URL` to the confirmed HTTPS site URL in `includes/config.php`. It is currently empty, so canonical and OG URL tags are omitted. Product pages append their own file path; the homepage uses the root.
2. Replace `https://example.invalid` in `sitemap.xml` with the same confirmed origin before publishing/submitting it. All ten routes are listed, but this is a deployment template until configured. Add the absolute sitemap URL to `robots.txt`.
3. Configure and verify enquiry mail as described below. All Book a Demo links now lead to `contact.php`; the former placeholder demo modal has been retired.
4. Supply operator information and approved privacy/terms content. Current legal dialogs are development notices.
5. Review product copy against the shipping application and replace conceptual views when approved screenshots become available.
6. Configure HTTPS and production PHP error handling. Check current Firefox, Safari and real Android devices, including keyboard focus, touch and zoom.

No external fonts, analytics, trackers, frameworks or third-party client scripts are included. The enquiry form works without JavaScript. Only Contact starts a necessary session cookie for CSRF and one-time form-result state. Privacy/Terms remain clearly identified development notices; the full privacy notice must be completed before collecting production enquiries. JavaScript enhances these notices into dialogs.

## Validation

See `VALIDATION.md` for the current Phase 3 checks and previous passes. Phase 2 was linted and rendered with a temporary official PHP 8.4.25 runtime, downloaded outside the repository and verified against the publisher's SHA-256. Chrome checked the actual PHP application at 17 widths across all eight pages. The temporary runtime and QA harnesses are not application dependencies.

```powershell
Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
```

## Enquiry delivery and production hosting

The confirmed recipient is `iancrofts@live.co.uk`, held centrally in `includes/config.php` as `DEMO_EMAIL`. It is not repeated in the form handler. The optional `FLEETIQ_DEMO_RECIPIENT` environment variable overrides it for controlled deployment/testing.

Required production settings:

- `FLEETIQ_DEMO_FROM`: a fixed mailbox on a sending domain authorised by your hosting/mail provider. There is deliberately no invented default. Configure this before enabling enquiries.
- `FLEETIQ_DEMO_TRANSPORT`: `mail` (default) or `disabled`. PHP `mail()` must be enabled and the host's mail service configured. Missing/invalid sender or recipient configuration safely prevents delivery.
- On Windows PHP, SMTP host/port are PHP mail configuration; on other hosts, the host may require a working sendmail path or local mail service. Ask the provider whether PHP mail is supported. Free PHP hosting may disable it or report acceptance without reliable onward delivery.
- Authorise the sending domain as required by the provider (including its SPF/DKIM and sender policies), use HTTPS, configure PHP to suppress detailed errors to visitors, and verify actual receipt in the monitored mailbox before launch. A successful `mail()` return means transport acceptance, not guaranteed inbox delivery.

Visitors never control From. Their validated email is used as Reply-To. The subject begins `FleetIQ Demo Enquiry -` and uses encoded words for the company name, with a bounded subject length; the complete company name stays in the body. The UTF-8 plain-text body contains all seven enquiry fields and a UTC submission timestamp. Body transfer encoding prevents visitor content becoming SMTP commands or MIME headers.

Delivery is isolated in `includes/enquiry-delivery.php`. To adopt authenticated SMTP or a transactional provider later, replace the adapter and its readiness check while retaining the validation and POST/redirect flow. Return true only after that transport accepts the submission. Keep any credentials in host environment configuration, not source control. No SMTP library or third-party dependency has been added in this phase.

If delivery is unavailable, the page shows a generic availability/failure message and never claims the enquiry was sent. After a transport failure, safe entered values remain for retry. Successful transport acceptance produces the confirmation and clears entered values. GET/query parameters cannot fabricate a success state. All POST results redirect with HTTP 303, and successful submission rotates the CSRF token to reject replay.

## Form security and data handling

Server validation covers required fields, scalar types, valid UTF-8, control characters, email format, phone digits, maximum lengths and allowed select values. Malformed/oversized requests, unknown fields, invalid CSRF and filled honeypots never reach delivery. No file uploads, database, analytics, marketing subscription, CAPTCHA or visitor IP collection are added.

The Contact-only cookie is HttpOnly, SameSite=Lax and Secure when PHP sees HTTPS; cookie expiry is the browser session. Ensure your HTTPS/reverse-proxy setup supplies trustworthy HTTPS state to PHP. Use a private writable `session.save_path` outside the document root. Safe failure values are held briefly in the server session, removed on the redirected GET, and ignored after 30 minutes. Session garbage collection/retention must also be configured by the host; the application does not promise physical deletion at an exact time. Success does not retain enquiry values in its session result. No enquiry body is written to application logs.

Complete the privacy notice, operator details and operational retention arrangements before public collection. No pre-ticked marketing consent or mailing-list addition exists.

## Phase 3 tests

```powershell
php tests/enquiry-test.php
Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
```

The CLI suite uses fake acceptance/failure callbacks and constructs messages without sending them. Additional local HTTP and SMTP-sink checks were run outside the repository using reserved test addresses and a loopback-only mail sink. No test message was sent to the real recipient. The production sender/domain and live hosting delivery remain unverified.
