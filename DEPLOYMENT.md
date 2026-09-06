# FleetIQ temporary test deployment

The confirmed **temporary** public URL is `http://fleetiq.fwh.is/`. It is not the production domain. `build/public-preparation/` has now been rebuilt for this domain and is ready to upload for website testing with mail unconfigured. The earlier domain-free preparation instructions are superseded.

Upload only the **contents of `build/public-preparation/`**, including hidden `.htaccess` and `.user.ini` files, into the host's public document root. There are 40 files; `build/package-manifest.txt` lists every path and stays outside the upload folder. Do not upload the entire `build/` directory or its previous-package backup.

## Central URL and rebuilding

`includes/config.php` supplies `http://fleetiq.fwh.is/` as the temporary default through the existing `FLEETIQ_SITE_URL` configuration. Environment settings take precedence over a private configuration file, which takes precedence over this default. The value is normalised without a trailing slash internally. All 12 canonicals/OG URLs and generated sitemap URLs use it; page/navigation/asset links remain relative so localhost still works. For local-only metadata, explicitly set `FLEETIQ_SITE_URL` to an empty string in private local configuration.

To rebuild, use a new destination (the builder never overwrites):

```powershell
php tools/build-public.php build/public-test-next --allow-http
```

`--allow-http` explicitly permits this confirmed HTTP test URL; it does not add redirects or modify runtime transport. Do not use `--prepare` for the upload build: that option intentionally makes an empty sitemap and blocks crawling. The current upload package has a 12-page sitemap and `Allow: /` robots with the correct sitemap reference. 404 is excluded.

## Mail remains unconfigured

Recipient: **iancrofts@live.co.uk**. Leave it unchanged. `FLEETIQ_DEMO_FROM` has no default sender. Without an authorised sender the form reports a generic failure, retains safe values for retry and does not attempt delivery. No sender, SMTP password or credentials have been added.

Once the actual provider confirms a permitted sender, set `FLEETIQ_DEMO_FROM` in the hosting control panel's PHP/application environment and reload PHP if required. Alternatively, copy `tools/config.example.php` to `fleetiq-config.php` immediately **above the public document root**, in a directory that is not served by any website. Set its `FLEETIQ_DEMO_FROM` entry to the actual authorised mailbox. `FLEETIQ_CONFIG_FILE` can identify another private absolute path. Never put private configuration inside the public package. Remove an explicitly empty environment override if using a non-empty private setting.

`FLEETIQ_DEMO_TRANSPORT` defaults to `mail`; `disabled` can suspend delivery. Hosting must support PHP `mail()` and have functioning onward delivery. After sender/transport setup, perform an authorised receipt test at the recipient, checking Reply-To, spam placement and sender authentication. Transport acceptance alone does not prove receipt. No external email was sent during this rebuild.

## HTTPS and later production domain

SSL has **not** been confirmed. Do not force HTTPS, add HSTS or enable HTTPS redirects for the current test upload. No such redirects are included. The current HTTP session cookie cannot use Secure; use synthetic enquiry data during HTTP testing.

When the provider confirms working SSL for this exact hostname, set `FLEETIQ_SITE_URL` to `https://fleetiq.fwh.is` in both the build environment and runtime configuration. Rebuild to a new directory **without** `--allow-http`, upload the regenerated package and verify HTTPS pages/assets/forms first. Only then configure one host-level HTTP-to-HTTPS redirect, confirming that it does not loop. Ensure PHP recognises HTTPS so session cookies use Secure.

When a production domain is chosen, replace the temporary fallback in `includes/config.php` with the confirmed production HTTPS URL and update/remove any overriding private/environment setting. Rebuild sitemap/robots/server paths using that same URL, upload the new package and verify canonical/OG URLs, sitemap and 404 routing. Do not edit individual page metadata. Keep URL settings scoped to deployment so localhost navigation continues to work.

## Host setup and checks after upload

- Use the tested PHP 8.4 branch at its latest patch level (code minimum 8.1), with sessions, filter and JSON support. Keep session/log storage private and writable by PHP. See README for PHP support references.
- Set `display_errors=Off`, `display_startup_errors=Off`, `log_errors=On`, `expose_php=Off`. `.user.ini` applies only on hosts supporting it; otherwise use the host's PHP controls. Keep logs outside the document root.
- Confirm Apache 2.4 permits the included `.htaccess` rules. For Nginx/other servers, apply equivalent private-directory/hidden-file access protection, disable listings, and internally route missing URLs to `404.php` with status 404. README includes the configuration outline. Local PHP-router checks do not establish host enforcement.
- Open all 12 content pages, including Privacy and Terms; follow navigation/Product dropdown/mobile menu and Book a Demo. Verify assets load and no debug/configuration information is displayed.
- Inspect canonical and `og:url` values: `http://fleetiq.fwh.is/` plus the intended route. Verify `/sitemap.xml` has 12 URLs and excludes 404; `/robots.txt` allows crawling and references `http://fleetiq.fwh.is/sitemap.xml`.
- Request `/404.php` and an unknown nested URL: branded page, HTTP 404, noindex, working Home/Explore links and no canonical. Ensure includes/components/hidden files cannot be read directly.
- Test the form with synthetic data: invalid fields, safe retained values, accessible errors and honest missing-sender failure. Complete real-browser/device tests after upload.
- Before collecting real public enquiries, confirm operator identity/contact details, providers, processing locations and retention, and update Privacy with confirmed specifics.

Outstanding: authorised `FLEETIQ_DEMO_FROM`, real-host mail receipt test, HTTPS/SSL confirmation, host access/PHP configuration verification, and real-browser/device testing after upload. These do not require inventing a sender or blocking the requested HTTP website test upload.

Package exclusions: `.git`, Codex files, tests/CLI scripts, browser fixtures, screenshots, reports, README, VALIDATION, deployment docs, archives (including `workshop.zip`), secrets/private configuration, backups and temporary/build tooling. Only the 34-file public allowlist plus six generated server/SEO files are uploaded.

No upload, commit, push or external email was performed.
