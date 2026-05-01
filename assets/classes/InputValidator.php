<?php
/**
 * Input Validation & Sanitization Class
 * 
 * Provides secure methods for validating and sanitizing all user input.
 * 
 * WHY THIS IS IMPORTANT:
 * - Prevents SQL injection (combined with prepared statements)
 * - Prevents XSS attacks
 * - Ensures data integrity
 * - Provides consistent validation across application
 * 
 * USAGE:
 * $validator = new InputValidator();
 * $email = $validator->validateEmail($_POST['email']);
 * $username = $validator->validateUsername($_POST['username']);
 */

class InputValidator {
    
    /**
     * ===================================================================
     * VALIDATION METHODS
     * ===================================================================
     * These return the validated value or FALSE if validation fails
     */
    
    /**
     * Validate and return email
     * 
     * @param string $email Email to validate
     * @return string|false Cleaned email or false
     */
    public static function validateEmail($email) {
        // First trim whitespace
        $email = trim($email);
        
        // Use PHP's built-in email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        // Limit length (emails should be < 254 chars)
        if (strlen($email) > 254) {
            return false;
        }
        
        return $email;
    }
    
    /**
     * Validate username/student ID
     * Allow: letters, numbers, hyphens, underscores
     * 
     * @param string $username Username to validate
     * @param int $minLength Minimum length
     * @param int $maxLength Maximum length
     * @return string|false
     */
    public static function validateUsername($username, $minLength = 3, $maxLength = 50) {
        $username = trim($username);
        
        // Check length
        $len = strlen($username);
        if ($len < $minLength || $len > $maxLength) {
            return false;
        }
        
        // Allow only alphanumeric, hyphens, underscores
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
            return false;
        }
        
        return $username;
    }
    
    /**
     * Validate password strength
     * 
     * Requirements:
     * - At least 8 characters
     * - At least 1 uppercase letter
     * - At least 1 lowercase letter
     * - At least 1 number
     * - At least 1 special character
     * 
     * @param string $password Password to validate
     * @return string|false
     */
    public static function validatePassword($password) {
        // Minimum length
        if (strlen($password) < 8) {
            return false;
        }
        
        // Maximum length (prevent very long strings)
        if (strlen($password) > 128) {
            return false;
        }
        
        // Check for uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }
        
        // Check for lowercase letter
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }
        
        // Check for number
        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }
        
        // Check for special character
        if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};:\'",.<>?\/\\|`~]/', $password)) {
            return false;
        }
        
        return $password;
    }
    
    /**
     * Validate name (firstname, lastname)
     * Allow: letters, spaces, hyphens, apostrophes
     * 
     * @param string $name Name to validate
     * @param int $minLength Minimum length
     * @param int $maxLength Maximum length
     * @return string|false
     */
    public static function validateName($name, $minLength = 2, $maxLength = 100) {
        $name = trim($name);
        
        $len = strlen($name);
        if ($len < $minLength || $len > $maxLength) {
            return false;
        }
        
        // Allow letters, spaces, hyphens, apostrophes
        if (!preg_match("/^[a-zA-Z\s\-']+$/", $name)) {
            return false;
        }
        
        return $name;
    }
    
    /**
     * Validate phone number
     * Accept various formats (with dashes, spaces, etc.)
     * 
     * @param string $phone Phone to validate
     * @return string|false Cleaned phone (digits and dashes only)
     */
    public static function validatePhone($phone) {
        $phone = trim($phone);
        
        // Remove non-digit, non-dash characters
        $cleaned = preg_replace('/[^\d\-]/', '', $phone);
        
        // Should be at least 10 digits
        $digitOnly = preg_replace('/[^\d]/', '', $cleaned);
        if (strlen($digitOnly) < 10) {
            return false;
        }
        
        return $cleaned;
    }
    
    /**
     * Validate URL
     * 
     * @param string $url URL to validate
     * @return string|false
     */
    public static function validateURL($url) {
        $url = trim($url);
        
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }
        
        return $url;
    }
    
    /**
     * Validate integer
     * 
     * @param mixed $value Value to validate
     * @param int $min Minimum value
     * @param int $max Maximum value
     * @return int|false
     */
    public static function validateInteger($value, $min = null, $max = null) {
        $value = trim((string)$value);
        
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            return false;
        }
        
        $intValue = (int)$value;
        
        if ($min !== null && $intValue < $min) {
            return false;
        }
        
        if ($max !== null && $intValue > $max) {
            return false;
        }
        
        return $intValue;
    }
    
    /**
     * Validate year (current or future)
     * 
     * @param string $year Year to validate
     * @return int|false
     */
    public static function validateYear($year) {
        $year = self::validateInteger($year, 2000, date('Y'));
        return $year;
    }
    
    /**
     * Validate gender
     * Only allow predefined values
     * 
     * @param string $gender Gender to validate
     * @return string|false
     */
    public static function validateGender($gender) {
        $allowed = ['Male', 'Female', 'Other', 'Prefer not to say'];
        $gender = trim($gender);
        
        if (!in_array($gender, $allowed)) {
            return false;
        }
        
        return $gender;
    }
    
    /**
     * Validate role (User role/permission)
     * Only allow predefined roles
     * 
     * @param string $role Role to validate
     * @return string|false
     */
    public static function validateRole($role) {
        $allowed = ['Admin', 'Student', 'Faculty', 'Staff'];
        $role = trim($role);
        
        if (!in_array($role, $allowed)) {
            return false;
        }
        
        return $role;
    }
    
    /**
     * ===================================================================
     * SANITIZATION METHODS
     * ===================================================================
     * These clean data but don't reject invalid values (use when possible)
     */
    
    /**
     * Sanitize string for database
     * Removes potentially harmful characters
     * STILL USE PREPARED STATEMENTS - this is extra layer only!
     * 
     * @param string $text Text to sanitize
     * @return string
     */
    public static function sanitizeString($text) {
        // Trim whitespace
        $text = trim($text);
        
        // Remove null bytes
        $text = str_replace("\0", '', $text);
        
        // Remove control characters
        $text = preg_replace('/[\x00-\x1F\x7F]/u', '', $text);
        
        return $text;
    }
    
    /**
     * Sanitize HTML special characters for display
     * Always use this when outputting user data in HTML!
     * 
     * @param string $text Text to sanitize
     * @param string $context 'html', 'attr', 'js', or 'url'
     * @return string
     */
    public static function escape($text, $context = 'html') {
        switch ($context) {
            case 'html':
                // For HTML content
                return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
                
            case 'attr':
                // For HTML attributes
                return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
                
            case 'js':
                // For JavaScript
                return json_encode($text);
                
            case 'url':
                // For URLs
                return urlencode($text);
                
            default:
                return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        }
    }
    
    /**
     * Remove HTML tags
     * SAFER than allowing HTML - prevents XSS
     * 
     * @param string $text Text to clean
     * @return string
     */
    public static function stripHTML($text) {
        return htmlspecialchars(strip_tags($text), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * ===================================================================
     * BATCH VALIDATION HELPER
     * ===================================================================
     * Validate multiple fields at once
     */
    
    /**
     * Validate multiple fields
     * Returns array of cleaned values or errors
     * 
     * @param array $data Input data (usually $_POST)
     * @param array $rules Validation rules
     * @return array ['success' => bool, 'data' => array, 'errors' => array]
     * 
     * USAGE:
     * $rules = [
     *     'email' => 'email',
     *     'password' => 'password',
     *     'firstname' => 'name',
     *     'role' => 'role'
     * ];
     * $result = InputValidator::validateBatch($_POST, $rules);
     * if ($result['success']) {
     *     // Use $result['data'] for database queries
     * } else {
     *     // Show $result['errors'] to user
     * }
     */
    public static function validateBatch($data, $rules) {
        $cleaned = [];
        $errors = [];
        
        foreach ($rules as $field => $type) {
            if (!isset($data[$field])) {
                $errors[$field] = "This field is required";
                continue;
            }
            
            $value = $data[$field];
            $result = false;
            
            switch ($type) {
                case 'email':
                    $result = self::validateEmail($value);
                    $error_msg = "Invalid email address";
                    break;
                    
                case 'username':
                    $result = self::validateUsername($value);
                    $error_msg = "Username must be 3-50 characters, letters/numbers/hyphens only";
                    break;
                    
                case 'password':
                    $result = self::validatePassword($value);
                    $error_msg = "Password must be at least 8 characters with uppercase, lowercase, number, and special character";
                    break;
                    
                case 'name':
                    $result = self::validateName($value);
                    $error_msg = "Name must be 2-100 characters, letters and spaces only";
                    break;
                    
                case 'phone':
                    $result = self::validatePhone($value);
                    $error_msg = "Invalid phone number";
                    break;
                    
                case 'role':
                    $result = self::validateRole($value);
                    $error_msg = "Invalid role selected";
                    break;
                    
                case 'gender':
                    $result = self::validateGender($value);
                    $error_msg = "Invalid gender selected";
                    break;
                    
                default:
                    $result = self::sanitizeString($value);
                    break;
            }
            
            if ($result === false) {
                $errors[$field] = $error_msg ?? "Invalid input";
            } else {
                $cleaned[$field] = $result;
            }
        }
        
        return [
            'success' => empty($errors),
            'data' => $cleaned,
            'errors' => $errors
        ];
    }
}

/**
 * ===================================================================
 * USAGE EXAMPLES
 * ===================================================================
 */

/*
// Example 1: Validate a single field
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = InputValidator::validateEmail($_POST['email']);
    if (!$email) {
        die('Invalid email');
    }
    // Use $email in database query
}

// Example 2: Validate multiple fields
$rules = [
    'email' => 'email',
    'firstname' => 'name',
    'lastname' => 'name',
    'password' => 'password',
    'gender' => 'gender',
    'role' => 'role'
];

$validation = InputValidator::validateBatch($_POST, $rules);

if (!$validation['success']) {
    // Show errors
    foreach ($validation['errors'] as $field => $error) {
        echo "$field: $error<br>";
    }
} else {
    // Use clean data
    $cleanedData = $validation['data'];
    
    // Now use with prepared statements
    $stmt = $pdo->prepare("INSERT INTO users (email, firstname, lastname, password, gender, role) 
                          VALUES (:email, :firstname, :lastname, :password, :gender, :role)");
    $stmt->execute($cleanedData);
}

// Example 3: Escape output
$user = $stmt->fetch();
echo "Hello, " . InputValidator::escape($user['firstname']);

// Example 4: HTML attribute
echo '<input value="' . InputValidator::escape($user['email'], 'attr') . '">';

// Example 5: JavaScript
echo '<script>var user = ' . InputValidator::escape($user, 'js') . ';</script>';
*/

?>
