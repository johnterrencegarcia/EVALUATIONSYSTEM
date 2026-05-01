<?php
/**
 * Secure PDO Database Connection
 * 
 * This file demonstrates the SECURE way to connect to a MySQL database
 * using PDO (PHP Data Objects) instead of deprecated MySQLi functions.
 * 
 * PDO provides:
 * - Prepared statements (prevents SQL injection)
 * - Better error handling
 * - Support for multiple database types
 * - Parameterized queries
 */

// 1. LOAD CONFIGURATION
// In production, load from environment variables or config file outside webroot
if (file_exists(__DIR__ . '/../../.env')) {
    $env = parse_ini_file(__DIR__ . '/../../.env');
} else {
    // Fallback to define constants here (development only)
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'evaluation');
    define('APP_DEBUG', false);
}

if (!defined('DB_HOST')) {
    define('DB_HOST', $env['DB_HOST'] ?? 'localhost');
    define('DB_USER', $env['DB_USER'] ?? 'root');
    define('DB_PASS', $env['DB_PASS'] ?? '');
    define('DB_NAME', $env['DB_NAME'] ?? 'evaluation');
    define('APP_DEBUG', ($env['APP_DEBUG'] ?? 'false') === 'true');
}

// 2. CREATE PDO CONNECTION
try {
    // DSN (Data Source Name) format: mysql:host=hostname;dbname=database
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    
    // PDO Options for security
    $options = [
        // Enable exceptions for errors
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        
        // Return fetch results as associative arrays
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        
        // Don't allow emulated prepared statements (use real ones)
        // This is critical for preventing SQL injection
        PDO::ATTR_EMULATE_PREPARES => false,
        
        // Set default character set to UTF-8
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
    ];
    
    // Create connection
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
    // ✅ Connection successful
    // Don't echo "Connected successfully!" in production
    if (APP_DEBUG) {
        echo "Database connected successfully";
    }
    
} catch (PDOException $e) {
    // 3. SECURE ERROR HANDLING
    // ✅ IMPORTANT: Never show database errors to users!
    
    if (APP_DEBUG) {
        // Development: Show detailed error for debugging
        die("Database connection failed: " . $e->getMessage());
    } else {
        // Production: Show generic error, log details
        error_log("Database connection error: " . $e->getMessage(), 3, __DIR__ . '/../../logs/db_errors.log');
        die("A database error occurred. Please try again later.");
    }
}

/**
 * SECURE QUERY EXAMPLES
 * 
 * ❌ NEVER DO THIS (SQL Injection vulnerable):
 * $sql = "SELECT * FROM users WHERE email = '" . $_POST['email'] . "'";
 * 
 * ✅ ALWAYS DO THIS (Prepared statement):
 * $sql = "SELECT * FROM users WHERE email = ?";
 * $stmt = $pdo->prepare($sql);
 * $stmt->execute([$_POST['email']]);
 * 
 * =====================================================
 * 
 * Example 1: Using ? Placeholders
 * =====================================================
 */

// This is the simplest way - use ? for each parameter
function exampleWithPlaceholders($email, $status) {
    global $pdo;
    
    $sql = "SELECT id, email, role FROM users WHERE email = ? AND status = ?";
    $stmt = $pdo->prepare($sql);
    
    // Execute with array of values in order
    $stmt->execute([$email, $status]);
    
    // Fetch single row
    $user = $stmt->fetch();
    
    return $user;
}

/**
 * =====================================================
 * Example 2: Using Named Placeholders (Recommended)
 * =====================================================
 * Named placeholders are clearer and less error-prone
 */

function exampleWithNamedPlaceholders($email, $role) {
    global $pdo;
    
    $sql = "SELECT id, firstname, lastname, email 
            FROM users 
            WHERE email = :email AND role = :role";
    
    $stmt = $pdo->prepare($sql);
    
    // Execute with associative array (order doesn't matter)
    $stmt->execute([
        ':email' => $email,
        ':role' => $role
    ]);
    
    return $stmt->fetch();
}

/**
 * =====================================================
 * Example 3: Inserting Data Securely
 * =====================================================
 */

function insertUserSecurely($firstname, $lastname, $email, $hashedPassword, $role) {
    global $pdo;
    
    $sql = "INSERT INTO users (firstname, lastname, email, password, role, created_at) 
            VALUES (:firstname, :lastname, :email, :password, :role, NOW())";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':email' => $email,
        ':password' => $hashedPassword,
        ':role' => $role
    ]);
    
    if ($result) {
        return $pdo->lastInsertId();
    }
    return false;
}

/**
 * =====================================================
 * Example 4: Updating Data Securely
 * =====================================================
 */

function updateUserSecurely($userId, $firstname, $lastname) {
    global $pdo;
    
    $sql = "UPDATE users 
            SET firstname = :firstname, lastname = :lastname, updated_at = NOW()
            WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':id' => $userId
    ]);
}

/**
 * =====================================================
 * Example 5: Getting Multiple Rows (Loop Through Results)
 * =====================================================
 */

function getAllStudentsSecurely() {
    global $pdo;
    
    $sql = "SELECT id, firstname, lastname, email, student_id 
            FROM users 
            WHERE role = :role 
            ORDER BY firstname ASC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':role' => 'Student']);
    
    // Fetch all as array
    return $stmt->fetchAll();
    
    // Or use loop:
    // while ($student = $stmt->fetch()) {
    //     echo htmlspecialchars($student['firstname']); // Always escape output!
    // }
}

/**
 * =====================================================
 * Example 6: Handling Errors Safely
 * =====================================================
 */

function deleteUserSecurely($userId) {
    global $pdo;
    
    try {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([':id' => $userId])) {
            return ['success' => true, 'message' => 'User deleted successfully'];
        }
        
    } catch (PDOException $e) {
        // Log error, don't show to user
        error_log("Delete user error: " . $e->getMessage(), 3, __DIR__ . '/../../logs/db_errors.log');
        return ['success' => false, 'message' => 'An error occurred while deleting user'];
    }
}

/**
 * =====================================================
 * IMPORTANT SECURITY NOTES
 * =====================================================
 * 
 * 1. ALWAYS use prepared statements
 *    - ? placeholders or :named placeholders
 *    - execute() with array of values
 * 
 * 2. NEVER concatenate user input into SQL
 *    - Even with mysqli_real_escape_string()
 *    - Even with PDO::quote()
 * 
 * 3. NEVER display database errors to users
 *    - Always log to file instead
 *    - Show generic error messages
 * 
 * 4. ALWAYS validate and sanitize input first
 *    - Use InputValidator class (see separate file)
 *    - Check data types, lengths, patterns
 * 
 * 5. ALWAYS escape output
 *    - Use htmlspecialchars() in HTML
 *    - Use json_encode() in JavaScript
 * 
 * 6. USE fetch() for single result
 *    - Returns single row as array
 * 
 * 7. USE fetchAll() for multiple results
 *    - Returns array of all rows
 * 
 * 8. Check rowCount() for UPDATE/DELETE
 *    - $stmt->rowCount() tells how many affected
 */

?>
