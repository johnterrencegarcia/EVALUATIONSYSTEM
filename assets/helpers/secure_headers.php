<?php
/**
 * Security Headers Configuration
 * 
 * These headers protect against various web attacks:
 * - XSS (Cross-Site Scripting)
 * - Clickjacking
 * - MIME type sniffing
 * - Protocol downgrade attacks
 * 
 * USAGE:
 * Include this file at the very top of every PHP file, before any output:
 * 
 * <?php
 * require_once __DIR__ . '/assets/helpers/secure_headers.php';
 * ?>
 */

/**
 * ===================================================================
 * HTTPS ENFORCEMENT
 * ===================================================================
 * Force HTTPS on production
 * Never send sensitive data over HTTP
 */

if (!in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1', 'localhost:80'])) {
    // Not localhost, enforce HTTPS
    if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
        header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit();
    }
}

/**
 * ===================================================================
 * SECURITY HEADERS
 * ===================================================================
 */

// 1. Strict-Transport-Security (HSTS)
// Forces browser to always use HTTPS for this domain
// max-age: how long to enforce (1 year = 31536000 seconds)
// includeSubDomains: also apply to subdomains
header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');

// 2. X-Content-Type-Options
// Prevents browser from guessing MIME types (MIME sniffing)
// Prevents executing CSS/JS files as other types
header('X-Content-Type-Options: nosniff');

// 3. X-Frame-Options
// Prevents clickjacking attacks (embedding site in iframe)
// DENY: Don't allow embedding in any frame
// SAMEORIGIN: Allow embedding only on same domain
header('X-Frame-Options: DENY');

// 4. X-XSS-Protection (Legacy, but still useful for older browsers)
// Enables browser's built-in XSS protection
header('X-XSS-Protection: 1; mode=block');

// 5. Referrer-Policy
// Controls what referrer information is sent
// strict-origin-when-cross-origin: Send origin only in cross-site requests
header('Referrer-Policy: strict-origin-when-cross-origin');

// 6. Content-Security-Policy (CSP)
// Controls which resources browser can load
// Prevents inline scripts and external script injection
// 
// CSP Directives:
// - default-src 'self': Only allow resources from same origin
// - script-src: Where scripts can load from
// - style-src: Where stylesheets can load from
// - img-src: Where images can load from
// - font-src: Where fonts can load from
// - connect-src: Where XMLHttpRequest, WebSocket, etc. can connect

$csp = [
    "default-src 'self'",                           // Default: same origin only
    "script-src 'self' https://cdn.jsdelivr.net",  // Scripts: same origin + CDN
    "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com", // Styles
    "font-src 'self' https://fonts.gstatic.com",   // Fonts
    "img-src 'self' data: https:",                 // Images: same origin, data URLs, HTTPS
    "connect-src 'self'",                          // AJAX/WebSocket: same origin
    "frame-ancestors 'none'",                      // Prevent embedding in frames
    "base-uri 'self'",                             // Base URL: same origin only
    "form-action 'self'",                          // Forms: submit to same origin only
];

header('Content-Security-Policy: ' . implode('; ', $csp));

// 7. Permissions-Policy (formerly Feature-Policy)
// Controls which browser features can be used
// Prevents malicious code from accessing camera, microphone, etc.
header('Permissions-Policy: geolocation=(), microphone=(), camera=(), payment=()');

// 8. Cross-Origin-Opener-Policy
// Prevents other sites from opening this site in a window
header('Cross-Origin-Opener-Policy: same-origin');

// 9. Cross-Origin-Embedder-Policy
// Requires explicit permission for cross-origin resources
header('Cross-Origin-Embedder-Policy: require-corp');

/**
 * ===================================================================
 * DISABLE CACHING FOR SENSITIVE PAGES
 * ===================================================================
 * Don't cache login pages, dashboards, etc.
 */

// Only disable cache for non-public pages
$publicPages = ['/', '/index.php', '/about.php']; // URLs that can be cached
if (!in_array($_SERVER['REQUEST_URI'], $publicPages)) {
    header('Cache-Control: no-cache, no-store, must-revalidate, private');
    header('Pragma: no-cache');
    header('Expires: 0');
}

/**
 * ===================================================================
 * SECURITY HEADERS REFERENCE
 * ===================================================================
 * 
 * Header Name                              Purpose
 * ============================================================================================================
 * Strict-Transport-Security                Force HTTPS usage
 * X-Content-Type-Options: nosniff         Prevent MIME type guessing
 * X-Frame-Options                         Prevent clickjacking
 * X-XSS-Protection                        Enable XSS protection (legacy)
 * Content-Security-Policy                 Control what resources can load
 * Referrer-Policy                         Control referrer information
 * Permissions-Policy                      Restrict browser features
 * Cross-Origin-Embedder-Policy            Require explicit cross-origin permission
 * Cross-Origin-Opener-Policy              Prevent cross-origin window control
 * 
 * ===================================================================
 * TESTING YOUR HEADERS
 * ===================================================================
 * 
 * 1. Use online scanner: https://securityheaders.com
 * 2. Use curl: curl -i https://yoursite.com | grep -i "^[a-z-]*:"
 * 3. Browser console: Open DevTools > Network tab > Click request > Headers
 * 
 * ===================================================================
 * CSP TROUBLESHOOTING
 * ===================================================================
 * 
 * If resources are blocked by CSP:
 * 1. Check browser console for CSP violations
 * 2. Add the source to the appropriate directive
 * 3. Examples:
 *    - External script: script-src 'self' https://example.com
 *    - Inline script: script-src 'self' 'unsafe-inline' (NOT RECOMMENDED)
 *    - Data URL: img-src 'self' data:
 * 
 * ===================================================================
 * BEST PRACTICES
 * ===================================================================
 * 
 * 1. Start with strict CSP, gradually open as needed
 * 2. Monitor CSP violations in production
 * 3. Use nonces for inline scripts:
 *    - script-src 'nonce-{random}'
 *    - <script nonce="{random}">...
 * 4. Use hash for inline CSS:
 *    - style-src 'hash-{base64}'
 * 5. Test on development server first
 * 6. Understand performance implications
 */

?>
