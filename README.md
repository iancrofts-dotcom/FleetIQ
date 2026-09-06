# FleetIQ website — Phase 4

Framework-free PHP website using the approved FleetIQ layouts, custom CSS and vanilla JavaScript. Requires PHP **8.1 or newer** with sessions, filter and JSON support. No database, framework, client dependencies, analytics or advertising trackers.

## Local development

```sh
php -S 127.0.0.1:8080 tools/router.php
php tests/enquiry-test.php
```

Open http://127.0.0.1:8080. The local router restricts requests to public routes/assets and renders the branded 404 for unknown URLs. It is a development tool, not a production server. Only Contact starts the necessary enquiry session. The form works without JavaScript.

## Public pages and shared code

The twelve content routes are `index.php`, `features.php`, `fleet-vehicles.php`, `drivers-compliance.php`, `workshop.php`, `documents-reminders.php`, `reports.php`, `mobile.php`, `about.php`, `contact.php`, `privacy.php` and `terms.php`. `404.php` is a non-indexed error page with HTTP 404 status.

- `components/`: shared header, navigation, footer, calls to action, icons and conceptual product visuals.
- `includes/product-pages.json`: approved product content and page metadata.
- `includes/config.php`: central configuration and output escaping.
- `includes/bootstrap.php`: public error boundary and response security headers.
- `includes/seo.php`: descriptions, Open Graph and configured canonical URLs.
- `includes/enquiry.php`: validation and transport-independent submission processing.
- `includes/enquiry-delivery.php`: message construction and replaceable PHP mail adapter.
- `includes/contact-request.php`: contact-only session, CSRF and POST/Redirect/GET.
- `assets/`: shared and page-specific CSS, navigation/form-focus JavaScript and favicon.
- `tools/public-files.php`: explicit deployment allowlist. Update deliberately when public dependencies change.
- `tests/enquiry-test.php`: CLI security/validation checks using fake transports; never sends email.

Conceptual product views and illustrative data remain labelled. No Pricing, Login, Resources, newsletter or customer-story features have been added.

## TEST DEPLOYMENT

### 1. Confirm the host and private configuration

The code minimum is PHP 8.1; deploy on the latest patched PHP 8.4 release (the branch tested locally), with HTTPS, sessions and private writable session/log storage. PHP 8.1 is no longer supported; see [PHP supported versions](https://www.php.net/supported-versions.php). Confirm the actual domain and any installation subdirectory. Do not derive the public URL from a visitor's Host header.

**One base URL setting: `FLEETIQ_SITE_URL`.** Use the same value when generating the package and running it on the host. It controls canonicals, Open Graph URLs, nested 404 navigation, generated sitemap URLs and the robots sitemap reference. Use the confirmed HTTPS base URL, including an installation subdirectory if applicable, without a trailing slash. Changing it requires rebuilding sitemap/robots and server error routing. No real domain is assumed in source.

Configure these environment variables in the hosting control panel's PHP/application environment, then restart/reload PHP if required:

| Setting | Value |
| --- | --- |
| `FLEETIQ_SITE_URL` | Confirmed HTTPS base URL |
| `FLEETIQ_DEMO_RECIPIENT` | Defaults to `iancrofts@live.co.uk`; retain for test enquiries |
| `FLEETIQ_DEMO_FROM` | Fixed mailbox authorised by the actual hosting/mail provider; no invented default |
| `FLEETIQ_DEMO_TRANSPORT` | `mail`, or `disabled` to suspend delivery |

**Shared hosting without environment settings:** copy `tools/config.example.php` to `fleetiq-config.php` in the directory immediately **above** the public document root. For example, if files are served from `public_html`, the private config is beside `public_html`, not inside it. Edit that private copy to supply the settings. Alternatively set `FLEETIQ_CONFIG_FILE` to its absolute private path. Environment values take precedence, including an explicitly empty value. The application rejects a private config resolved inside its public directory. Ensure the parent directory is genuinely outside every served location and readable only by the account/PHP process as appropriate. Do not commit or publicly upload credentials or the private config.

### 2. Build the public package

From the repository, set the confirmed URL in your shell or private config, then run:

```powershell
$env:FLEETIQ_SITE_URL = 'https://YOUR-CONFIRMED-DOMAIN'
php tools/build-public.php C:\path\to\new-fleetiq-public
```

The displayed domain is an instruction placeholder, not a real FleetIQ domain. The destination must be a **new directory outside the repository or beneath its dedicated `build/` directory**, with an existing parent. The builder never deletes or overwrites a directory. It copies only the files in `tools/public-files.php`, generates `sitemap.xml` and `robots.txt` from the configured URL, and includes Apache access/error rules and conservative `.user.ini` settings. The twelve content routes are in the sitemap; 404 is excluded. The source sitemap/robots are reference templates and must not be uploaded directly.

While the domain is unknown, `php tools/build-public.php build/public-preparation --prepare` produces a local preparation copy. The current copy is at `build/public-preparation/`; its exact manifest is in `build/package-manifest.txt`, outside the public folder. Preparation mode deliberately generates an empty sitemap and crawl-disallowed robots without a fake domain. **Do not upload this preparation copy.** Once the domain is known, set `FLEETIQ_SITE_URL` and run `php tools/build-public.php build/public-test` without `--prepare`, then upload that new package. Build output is ignored by Git.

Upload the **contents of this generated package**, including its hidden `.htaccess` and `.user.ini` files, into the site's document root. Use appropriate host ownership and permissions (typically directories 755 and public files 644); private configuration, logs and sessions must remain private. The local package root is created with restrictive permissions, so adjust its permissions if using it directly as a server document root.

Never upload the whole repository. The package excludes `.git`, `.agents`, `.codex`, tests, tooling, README, VALIDATION, QA fixtures/screenshots, logs, archives and `workshop.zip`. Keep useful tests/docs in the repository. Do not expose a source archive or a backup beside the deployed site.

### 3. Apply host routing, access and PHP settings

The package includes **Apache 2.4** rules: directory listings disabled; `ErrorDocument 404` points to the correct base path; hidden files and direct requests into `includes`/`components` are denied. Confirm the host permits `Options`, `ErrorDocument` and `Require` through `.htaccess`. If it does not, have the provider apply equivalent rules in its server configuration; do not leave a broken configuration or remove protections without replacements.

On **Nginx or another server**, `.htaccess` is ignored. Ask the provider to deny hidden files and the `includes`/`components` directories, disable listings, run only the site's public PHP entry points and internally route unknown URLs to `404.php` **while preserving status 404**. For an Nginx site installed at the domain root, the relevant rules inside the existing server block are:

```nginx
location ~ /\. { deny all; }
location ~ ^/(includes|components)(/|$) { deny all; }
error_page 404 /404.php;
location / { try_files $uri $uri/ =404; }
```

These complement the provider's existing secure PHP-FPM handler (which must check file existence before forwarding PHP). They are not a complete server configuration. Prefix paths for a subdirectory installation and check location precedence with the host. Do not use a redirect or `=200` error-page mapping.

At PHP/host level set `display_errors=Off`, `display_startup_errors=Off`, `log_errors=On`, and `expose_php=Off`. The generated `.user.ini` is for CGI/FastCGI hosts that support it; other hosts require equivalent PHP settings in their control panel/php.ini. Set `error_log` and `session.save_path` to private locations outside the document root. Verify PHP can write there and configure log rotation/access and session cleanup. The application adds a generic buffered 500 response for runtime exceptions/fatal errors and logs error type/location without exception messages or enquiry bodies. PHP startup and entry-point parse errors occur before this boundary; host settings are essential.

Use HTTPS throughout and configure the host to redirect HTTP to HTTPS. PHP must receive trustworthy HTTPS state so the session cookie receives `Secure`; do not trust arbitrary forwarded headers from clients. HTTPS termination/proxy settings are host-specific. Enable HSTS only after the domain and all affected HTTPS services are verified; the application deliberately does not assume that setup.

Application responses set CSP restricting scripts/styles and form submission to the same origin, `nosniff`, a restrictive referrer policy, same-origin framing and permissions restrictions. No inline script/style exceptions or external CDN permissions are needed. Static-file headers and host-generated error responses remain the host's responsibility.

### 4. Configure and verify mail

Retain the confirmed recipient **iancrofts@live.co.uk**. `FLEETIQ_DEMO_FROM` must be a fixed sender authorised by the actual provider. PHP `mail()` must be enabled and connected to a working mail service. On Windows, PHP SMTP host/port settings apply; other hosts commonly require a configured local sendmail/mail service. Ask the host what it supports: free hosting may disable mail or accept messages without reliable onward delivery.

Visitors never control From. A validated email becomes Reply-To. The subject starts `FleetIQ Demo Enquiry -` and encodes/bounds company text safely. The plain-text UTF-8 body contains name, company, email, phone, fleet size, industry/fleet type, enquiry and a UTC timestamp. Header controls are rejected and body transfer encoding prevents SMTP/MIME injection.

Success is shown only if the transport reports acceptance. This does not guarantee inbox delivery. Missing configuration or failed delivery produces a generic message; safe values remain available to retry. Success clears values and rotates CSRF. No response time is promised.

Verify actual receipt and Reply-To in the monitored mailbox once the host is configured, including spam placement and sender authentication (SPF/DKIM as required by the provider). No external test messages were sent during development. For later commercial launch, prefer authenticated SMTP or a transactional mail provider. Replace the adapter/readiness check in `includes/enquiry-delivery.php`, keeping validation and PRG intact; keep credentials outside source control. No SMTP dependency has been introduced prematurely.

### 5. Privacy and operator checks

Privacy and Terms are real linked pages. The privacy notice covers enquiries, legitimate interests, necessary technical/session handling, provider categories, retention criteria, rights and ICO contact routes. The terms concern website use only; they do not fabricate a SaaS contract or choose an unconfirmed UK jurisdiction.

Before collecting real public enquiries, confirm the operator's full legal identity/contact details, actual hosting/email providers, processing locations and any international transfer safeguards, access arrangements and operational retention periods. Update the notice with those specifics; a FleetIQ trading name alone may not identify the legal controller sufficiently. Before commercial launch, obtain appropriate review of operator disclosures and website terms. No company number, registered office, ICO number or DPO has been invented.

Only Contact uses `fleetiq_enquiry`, a necessary browser-session cookie with HttpOnly and SameSite=Lax (Secure under HTTPS). It stores a session identifier; safe retry values are held server-side and consumed on the next GET, with an application expiry of 30 minutes for unused results. Actual deletion also depends on host session cleanup. No consent banner is needed for this necessary-cookie-only implementation. Reassess if tracking or other cookies are added later.

### 6. Verify before inviting testers

- Open all twelve pages; follow logo, Product, Features, About, Contact, demo and legal links. Check assets and browser console.
- Check an unknown **nested** URL and direct `404.php`: status 404, branded page, correct links, no canonical, noindex. Request `includes/product-pages.json`, `components/header.php`, `.user.ini`, `.git/HEAD`, `tests/enquiry-test.php`, `README.md` and archives: none may expose contents.
- Inspect canonicals and OG URLs, generated sitemap/robots and HTTPS redirects against the confirmed deployment base URL. No reserved/local/test URLs should remain in deployed metadata.
- Verify private logs work, PHP errors stay generic and sessions survive redirects. Check cookie flags under actual HTTPS. Do not deliberately break the public service to test this; use an isolated test instance.
- Run enquiry validation, invalid CSRF/honeypot, mail failure and authorised end-to-end acceptance/receipt checks. Confirm error associations, retained values, success confirmation and no duplicate sends on refresh.
- Check the requested desktop/mobile widths, keyboard, zoom and reduced motion. Test Firefox, Safari and real Android/iOS devices as well as Chrome.

## Validation

See `VALIDATION.md` for measured Phase 4 results and limitations. PHP 8.4.25 and Chrome were available locally. Test tools/runtime and local mail sink are outside the public package.

```powershell
php tests/enquiry-test.php
Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
```

This repository is ready for end-to-end testing once the actual host, base URL, operator/provider details and authorised sender are configured and the deployment checks above pass. Local tests do not establish real-host mail delivery, legal completeness or cross-browser/device coverage.
