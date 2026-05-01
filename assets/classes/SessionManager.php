<?php

class SessionManager {
    
    const SESSION_TIMEOUT = 3600;
    const SESSION_REGEN_INTERVAL = 600;
    
    public static function initialize() {
        
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => $_SERVER['HTTP_HOST'] ?? '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!self::checkSessionTimeout()) {
            session_destroy();
            return false;
        }
        
        if (!self::validateIPAddress()) {
            session_destroy();
            return false;
        }
        
        if (!self::checkSessionRegeneration()) {
            session_regenerate_id(true);
        }
        
        $_SESSION['last_activity'] = time();
        
        return true;
    }
    
    private static function checkSessionTimeout() {
        if (!isset($_SESSION['last_activity'])) {
            return true;
        }
        
        $elapsed = time() - $_SESSION['last_activity'];
        
        if ($elapsed > self::SESSION_TIMEOUT) {
            error_log("Session timeout for user: " . ($_SESSION['user_id'] ?? 'unknown'), 
                     3, __DIR__ . '/../../logs/session.log');
            return false;
        }
        
        return true;
    }
    
    private static function validateIPAddress() {
        $currentIP = self::getClientIP();
        
        if (!isset($_SESSION['ip_address'])) {
            $_SESSION['ip_address'] = $currentIP;
            return true;
        }
        
        if ($_SESSION['ip_address'] !== $currentIP) {
            error_log("Session IP mismatch. Previous: " . $_SESSION['ip_address'] . 
                     ", Current: " . $currentIP, 3, __DIR__ . '/../../logs/security.log');
            return false;
        }
        
        return true;
    }
    
    private static function checkSessionRegeneration() {
        if (!isset($_SESSION['last_regen'])) {
            $_SESSION['last_regen'] = time();
            return false;
        }
        
        if (time() - $_SESSION['last_regen'] > self::SESSION_REGEN_INTERVAL) {
            return false;
        }
        
        return true;
    }
    
    private static function getClientIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($ips[0]);
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
    
    public static function createUserSession($userData) {
        session_regenerate_id(true);
        
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['user_email'] = $userData['email'];
        $_SESSION['user_role'] = $userData['role'];
        $_SESSION['user_name'] = $userData['firstname'] . ' ' . $userData['lastname'];
        
        $_SESSION['login_time'] = time();
        $_SESSION['last_activity'] = time();
        $_SESSION['ip_address'] = self::getClientIP();
    }
    
    public static function destroySession() {
        $_SESSION = [];
        
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        
        session_destroy();
    }
    
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public static function hasRole($requiredRoles) {
        if (!self::isLoggedIn()) {
            return false;
        }
        
        if (is_string($requiredRoles)) {
            $requiredRoles = [$requiredRoles];
        }
        
        return in_array($_SESSION['user_role'] ?? '', $requiredRoles);
    }
    
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: /index.php?message=Please login first');
            exit();
        }
    }
    
    public static function requireRole($requiredRoles) {
        if (!self::hasRole($requiredRoles)) {
            http_response_code(403);
            die('Access denied. You do not have permission to access this page.');
        }
    }
    
    public static function getTimeRemaining() {
        if (!isset($_SESSION['last_activity'])) {
            return 0;
        }
        
        $elapsed = time() - $_SESSION['last_activity'];
        $remaining = self::SESSION_TIMEOUT - $elapsed;
        
        return max(0, $remaining);
    }
}
?>
