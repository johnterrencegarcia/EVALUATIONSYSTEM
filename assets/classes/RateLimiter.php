<?php
/**
 * Rate Limiter - Brute Force Attack Protection
 * 
 * Prevents password guessing attacks by:
 * - Limiting login attempts per user
 * - Temporary account lockout after failed attempts
 * - Logging suspicious activity
 * 
 * Common Brute Force Attack:
 * Attacker tries 1000 passwords in 1 minute on user account
 * With rate limiting: Account locked after 5 failures
 * 
 * Uses sessions or database to track attempts
 * (Session approach is simpler, database approach survives server restart)
 */

class RateLimiter {
    
    // Maximum attempts allowed
    const MAX_ATTEMPTS = 5;
    
    // Lockout duration: 15 minutes = 900 seconds
    const LOCKOUT_DURATION = 900;
    
    // Time window for attempt counting: 1 hour = 3600 seconds
    const TIME_WINDOW = 3600;
    
    /**
     * Check if user/IP is rate limited
     * 
     * @param string $identifier Username, email, or IP address
     * @return array ['allowed' => bool, 'attempts' => int, 'lockout_remaining' => int]
     */
    public static function checkLimit($identifier) {
        // Get attempt record
        $record = self::getAttemptRecord($identifier);
        
        // Check if currently locked out
        if ($record['locked']) {
            $lockoutRemaining = $record['lockout_time'] + self::LOCKOUT_DURATION - time();
            
            return [
                'allowed' => false,
                'attempts' => $record['attempts'],
                'locked' => true,
                'lockout_remaining' => max(0, $lockoutRemaining)
            ];
        }
        
        return [
            'allowed' => true,
            'attempts' => $record['attempts'],
            'locked' => false,
            'lockout_remaining' => 0
        ];
    }
    
    /**
     * Record a failed login attempt
     * 
     * @param string $identifier Username, email, or IP
     * @return array Updated record
     */
    public static function recordFailedAttempt($identifier) {
        $record = self::getAttemptRecord($identifier);
        
        // Increment attempts
        $record['attempts']++;
        
        // Update last attempt time
        $record['last_attempt'] = time();
        
        // Lock account if max attempts reached
        if ($record['attempts'] >= self::MAX_ATTEMPTS) {
            $record['locked'] = true;
            $record['lockout_time'] = time();
            
            // Log the lockout
            error_log(
                "Rate limit lockout - Identifier: $identifier, Attempts: {$record['attempts']}, IP: {$_SERVER['REMOTE_ADDR']}", 
                3, 
                __DIR__ . '/../../logs/security.log'
            );
        }
        
        // Save record
        self::saveAttemptRecord($identifier, $record);
        
        return $record;
    }
    
    /**
     * Record a successful login
     * Clears failed attempt record
     * 
     * @param string $identifier Username, email, or IP
     * @return void
     */
    public static function recordSuccessfulLogin($identifier) {
        // Clear the attempt record
        self::clearAttemptRecord($identifier);
        
        // Log successful login after lockout
        $record = self::getAttemptRecord($identifier);
        if ($record['attempts'] > 0) {
            error_log(
                "Login after previous failed attempts - Identifier: $identifier, Previous Attempts: {$record['attempts']}", 
                3, 
                __DIR__ . '/../../logs/security.log'
            );
        }
    }
    
    /**
     * Get attempt record from session/database
     * 
     * @param string $identifier
     * @return array
     */
    private static function getAttemptRecord($identifier) {
        // Use session-based storage (simple approach)
        // For distributed systems, use database instead
        
        $key = 'rate_limit_' . md5($identifier);
        
        if (isset($_SESSION[$key])) {
            $record = $_SESSION[$key];
            
            // Check if time window has expired
            if (time() - $record['created'] > self::TIME_WINDOW) {
                // Time window expired, reset
                return [
                    'attempts' => 0,
                    'created' => time(),
                    'last_attempt' => 0,
                    'locked' => false,
                    'lockout_time' => 0
                ];
            }
            
            return $record;
        }
        
        // New record
        return [
            'attempts' => 0,
            'created' => time(),
            'last_attempt' => 0,
            'locked' => false,
            'lockout_time' => 0,
            'identifier' => $identifier
        ];
    }
    
    /**
     * Save attempt record
     * 
     * @param string $identifier
     * @param array $record
     * @return void
     */
    private static function saveAttemptRecord($identifier, $record) {
        $key = 'rate_limit_' . md5($identifier);
        $_SESSION[$key] = $record;
    }
    
    /**
     * Clear attempt record (after successful login)
     * 
     * @param string $identifier
     * @return void
     */
    private static function clearAttemptRecord($identifier) {
        $key = 'rate_limit_' . md5($identifier);
        unset($_SESSION[$key]);
    }
    
    /**
     * Manually reset rate limit (admin function)
     * 
     * @param string $identifier
     * @return void
     */
    public static function resetLimit($identifier) {
        self::clearAttemptRecord($identifier);
    }
    
    /**
     * Get rate limit status as user-friendly message
     * 
     * @param string $identifier
     * @return string Message to show user
     */
    public static function getStatusMessage($identifier) {
        $status = self::checkLimit($identifier);
        
        if ($status['allowed']) {
            $remaining = self::MAX_ATTEMPTS - $status['attempts'];
            if ($remaining > 0) {
                return "You have $remaining login attempts remaining";
            }
            return "";
        }
        
        // Locked out
        $minutes = ceil($status['lockout_remaining'] / 60);
        return "Account locked due to too many failed attempts. Please try again in $minutes minutes.";
    }
}

/**
 * ===================================================================
 * DATABASE-BASED RATE LIMITING (For production with multiple servers)
 * ===================================================================
 * If you have multiple servers or need persistence, use this instead:
 */

class RateLimiterDB {
    
    const MAX_ATTEMPTS = 5;
    const LOCKOUT_DURATION = 900;
    const TIME_WINDOW = 3600;
    
    /**
     * Check rate limit using database
     * 
     * @param string $identifier
     * @param PDO $pdo Database connection
     * @return array Status
     */
    public static function checkLimit($identifier, $pdo) {
        $stmt = $pdo->prepare("
            SELECT * FROM rate_limit_attempts 
            WHERE identifier = ? 
            ORDER BY created DESC 
            LIMIT 1
        ");
        $stmt->execute([$identifier]);
        $record = $stmt->fetch();
        
        if (!$record) {
            return ['allowed' => true, 'attempts' => 0, 'locked' => false];
        }
        
        // Check if locked
        if ($record['locked'] && time() - $record['lockout_time'] < self::LOCKOUT_DURATION) {
            $remaining = $record['lockout_time'] + self::LOCKOUT_DURATION - time();
            return [
                'allowed' => false,
                'attempts' => $record['attempts'],
                'locked' => true,
                'lockout_remaining' => $remaining
            ];
        }
        
        // Check if time window expired
        if (time() - $record['created'] > self::TIME_WINDOW) {
            return ['allowed' => true, 'attempts' => 0, 'locked' => false];
        }
        
        return [
            'allowed' => $record['attempts'] < self::MAX_ATTEMPTS,
            'attempts' => $record['attempts'],
            'locked' => false
        ];
    }
    
    /**
     * Record failed attempt in database
     * 
     * @param string $identifier
     * @param PDO $pdo
     * @return void
     */
    public static function recordFailedAttempt($identifier, $pdo) {
        $stmt = $pdo->prepare("
            INSERT INTO rate_limit_attempts (identifier, attempts, locked, last_attempt, ip_address)
            VALUES (?, 1, 0, NOW(), ?)
            ON DUPLICATE KEY UPDATE 
                attempts = attempts + 1,
                last_attempt = NOW(),
                locked = IF(attempts >= ?, 1, 0),
                lockout_time = IF(attempts >= ?, NOW(), lockout_time)
        ");
        
        $stmt->execute([
            $identifier,
            $_SERVER['REMOTE_ADDR'],
            self::MAX_ATTEMPTS,
            self::MAX_ATTEMPTS
        ]);
    }
}

/**
 * ===================================================================
 * DATABASE SETUP FOR RATE_LIMIT_ATTEMPTS TABLE
 * ===================================================================
 * 
 * Create this table to use database-based rate limiting:
 * 
 * CREATE TABLE rate_limit_attempts (
 *     id INT PRIMARY KEY AUTO_INCREMENT,
 *     identifier VARCHAR(255) UNIQUE NOT NULL,
 *     attempts INT DEFAULT 0,
 *     locked BOOLEAN DEFAULT 0,
 *     created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 *     last_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 *     lockout_time TIMESTAMP NULL,
 *     ip_address VARCHAR(45),
 *     INDEX(identifier),
 *     INDEX(created)
 * );
 */

/**
 * ===================================================================
 * USAGE EXAMPLES
 * ===================================================================
 */

/*
// Example 1: Login page with rate limiting
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check rate limit
    $limitStatus = RateLimiter::checkLimit($username);
    if (!$limitStatus['allowed']) {
        die("Too many failed login attempts. " . RateLimiter::getStatusMessage($username));
    }
    
    // Verify credentials
    $user = getUser($username);
    if (!$user || !password_verify($password, $user['password'])) {
        // Record failed attempt
        RateLimiter::recordFailedAttempt($username);
        die("Invalid username or password");
    }
    
    // Successful login
    RateLimiter::recordSuccessfulLogin($username);
    $_SESSION['user_id'] = $user['id'];
    header('Location: /dashboard.php');
}
?>

// Example 2: Show remaining attempts on login form
<?php
$username = $_GET['username'] ?? '';
if ($username) {
    echo RateLimiter::getStatusMessage($username);
}
?>

// Example 3: Admin unlock account
RateLimiter::resetLimit($username_to_unlock);

// Example 4: Unlock all accounts older than 24 hours
// (Run periodically via cron job)
// DELETE FROM rate_limit_attempts WHERE created < DATE_SUB(NOW(), INTERVAL 24 HOUR);
*/

?>
