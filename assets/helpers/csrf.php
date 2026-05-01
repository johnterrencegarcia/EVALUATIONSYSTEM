<?php
/**
 * CSRF Token Protection Helper
 * 
 * Protects against Cross-Site Request Forgery (CSRF) attacks
 * 
 * CSRF Attack Scenario:
 * 1. User logs in to your website
 * 2. User visits malicious website (without logging out)
 * 3. Malicious site makes hidden request to your site
 * 4. Request succeeds because user is already logged in!
 * 
 * CSRF Protection:
 * - Generate unique token for each form
 * - Verify token matches when form submitted
 * - Token must be user-specific and unpredictable
 * 
 * USAGE:
 * 1. Start session at top of page: session_start();
 * 2. Generate token: csrf_generate_token();
 * 3. Add to form: <input type="hidden" name="csrf_token" value="<?php echo csrf_get_token(); ?>">
 * 4. Validate on submit: if (!csrf_validate_token($_POST['csrf_token'])) { die('CSRF validation failed'); }
 */

/**
 * Generate and initialize CSRF token
 * Call this once per session, usually right after session_start()
 * 
 * @return void
 */
function csrf_generate_token() {
    // Only generate if doesn't exist
    if (empty($_SESSION['csrf_token'])) {
        // Use random_bytes for cryptographically secure random data
        // bin2hex converts to readable hex string
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

/**
 * Get current CSRF token
 * Use this in forms
 * 
 * @return string CSRF token
 * 
 * USAGE IN FORM:
 * <input type="hidden" name="csrf_token" value="<?php echo csrf_get_token(); ?>">
 */
function csrf_get_token() {
    // Generate if not exists
    if (empty($_SESSION['csrf_token'])) {
        csrf_generate_token();
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 * Call this before processing POST requests
 * 
 * @param string $token Token from form $_POST['csrf_token']
 * @return bool true if valid, false otherwise
 * 
 * USAGE:
 * if (!csrf_validate_token($_POST['csrf_token'] ?? '')) {
 *     die('CSRF validation failed');
 * }
 */
function csrf_validate_token($token) {
    // Check if token exists in session
    if (empty($_SESSION['csrf_token'])) {
        return false;
    }
    
    // Compare tokens using hash_equals() to prevent timing attacks
    // hash_equals() compares strings in constant time
    // This prevents attackers from guessing tokens by measuring response time
    return hash_equals($_SESSION['csrf_token'], $token ?? '');
}

/**
 * Refresh CSRF token after validation
 * Good practice: rotate token after each use
 * 
 * @return void
 */
function csrf_refresh_token() {
    // Generate new token
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * CSRF Protection Middleware
 * Use this to validate ALL POST requests
 * 
 * @return void Dies if CSRF validation fails
 * 
 * USAGE AT TOP OF POST-HANDLING CODE:
 * if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 *     csrf_protect();
 *     // Process form...
 * }
 */
function csrf_protect() {
    // Only check POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }
    
    // Get token from POST data
    $token = $_POST['csrf_token'] ?? '';
    
    // Validate
    if (!csrf_validate_token($token)) {
        http_response_code(403);
        error_log("CSRF attack attempt detected", 3, __DIR__ . '/../../logs/security.log');
        
        // Return JSON for AJAX requests
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'CSRF validation failed']);
            exit();
        }
        
        // Return HTML for form requests
        die('CSRF validation failed. Please try again.');
    }
    
    // Optionally refresh token after validation
    // csrf_refresh_token();
}

/**
 * Get CSRF token as hidden input HTML
 * Makes it easier to add to forms
 * 
 * @return string HTML hidden input with token
 * 
 * USAGE IN FORM:
 * <?php echo csrf_get_input(); ?>
 */
function csrf_get_input() {
    return '<input type="hidden" name="csrf_token" value="' . csrf_get_token() . '">';
}

/**
 * ===================================================================
 * SECURITY NOTES
 * ===================================================================
 * 
 * 1. ALWAYS call csrf_generate_token() right after session_start()
 * 
 * 2. ALWAYS include token in EVERY form
 *    - HTML forms: <input type="hidden" name="csrf_token" value="...">
 *    - AJAX: Add to request headers or data
 * 
 * 3. ALWAYS validate before processing POST data
 *    if (!csrf_validate_token($_POST['csrf_token'] ?? '')) {
 *        die('CSRF validation failed');
 *    }
 * 
 * 4. Consider rotating token after each use
 *    - More secure but more complex
 *    - csrf_refresh_token()
 * 
 * 5. Use hash_equals() for comparison
 *    - Prevents timing attacks
 *    - Compare in constant time
 * 
 * 6. Log failed CSRF attempts
 *    - Indicates potential attack
 *    - Monitor for patterns
 * 
 * 7. AJAX CSRF Protection:
 *    - Add token to request header
 *    - Or include in data
 *    - See AJAX example below
 */

/**
 * ===================================================================
 * AJAX CSRF PROTECTION EXAMPLE
 * ===================================================================
 */

/*
// In your HTML template, add token to meta tag:
<meta name="csrf-token" content="<?php echo csrf_get_token(); ?>">

// In your JavaScript:
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

fetch('/api/endpoint', {
    method: 'POST',
    headers: {
        'X-CSRF-Token': csrfToken,
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(data)
});

// In your PHP, validate:
$token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
if (!csrf_validate_token($token)) {
    die('CSRF validation failed');
}
*/

?>
