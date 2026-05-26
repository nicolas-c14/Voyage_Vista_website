# VoyageVista - Updated TODO (ordered)

This TODO lists prioritized work to complete the project according to the subject (Sujet 4).

High priority (implement in order)
- [ ] Add full DB schema and seed data: `sql/voyagevista_schema.sql`, `sql/seed_data.sql` (users, destinations, countries, transports, hebergements, chambres, activites, reservations, notifications)
- [ ] Add `sql/europe_countries.sql` with a table of allowed European countries and seed it
- [ ] Add central session starter: `includes/session.php` (secure cookie params)
- [ ] Add security headers include: `includes/security_headers.php` (CSP, HSTS, X-Frame-Options, Referrer-Policy)
- [ ] Update `includes/navbar.php` to use `includes/session.php` and include security headers
- [ ] Implement `api/destination_create.php` with CSRF + server-side Europe-only validation
- [ ] Implement provider dashboard pages (protected by role middleware)
- [ ] Implement reservation API with SQL transactions and availability checks

Medium priority
- [ ] Implement role middleware: `includes/auth_middleware.php` and protect admin/provider routes
- [ ] Add notifications API + small UI in navbar
- [ ] Add input validation helpers and centralize error handling/flash messages

Low priority
- [ ] Add React frontend + JSON endpoints (optional for full React requirement)
- [ ] Create deliverables: wireframes, MEA, README, PPT, IA journal
- [ ] Add automated tests: curl integration scripts, PHPUnit tests, static analysis

Notes
- Changes should preserve the existing skeleton. Add new files and includes, avoid renames.
- Europe-only rule: enforced at UI, server API, and DB level (countries table + FK constraint).
