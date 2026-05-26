<?php
// Minimal security headers. Adjust CSP to your assets in production.
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer-when-downgrade");
header("Permissions-Policy: geolocation=(), microphone=()" );
// Content-Security-Policy - minimal, allow same origin and bootstrap CDN if used
header("Content-Security-Policy: default-src 'self' 'unsafe-inline' 'unsafe-eval' data:;");

// HSTS should only be enabled on production HTTPS
// header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

?>
