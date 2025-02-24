<?php

/**
 * Sanitizes input data to prevent XSS
 * 
 * @param mixed $data The input data to sanitize
 * @return mixed The sanitized data
 */
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return $data;
}

/**
 * Escapes output for HTML context
 * 
 * @param string $output The string to escape
 * @return string The escaped string
 */
function escape_output($output) {
    return htmlspecialchars($output, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Sets security headers
 * Must be called before any output
 * 
 * @return void
 */
function set_security_headers() {
    if (!headers_sent()) {
        // Content Security Policy
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline'",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net",
            "img-src 'self' data: https://cdn.peaknil.com",
            "font-src 'self'",
            "frame-ancestors 'self'",
            "form-action 'self'",
            "base-uri 'self'",
            "object-src 'none'"
        ];
        header("Content-Security-Policy: " . implode("; ", $csp));
        
        // Additional security headers
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: SAMEORIGIN");
        header("X-XSS-Protection: 1; mode=block");
        header("Referrer-Policy: strict-origin-when-cross-origin");
    }
}

/**
 * Records a failed login attempt
 * 
 * @param string $email The email used in the attempt
 * @return void
 */
function record_login_attempt($email) {
    global $db;
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $current_time = date('Y-m-d H:i:s');
    
    $stmt = $db->prepare("INSERT INTO login_attempts (ip_address, email, attempt_time) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $ip, $email, $current_time);
    $stmt->execute();
    
    // Clean up old attempts
    cleanup_login_attempts();
}

/**
 * Checks if the current user is locked out due to too many failed attempts
 * 
 * @param string $email The email to check
 * @return array [bool $is_locked, int $minutes_remaining] Whether user is locked out and minutes remaining
 */
function check_login_lockout($email) {
    global $db;
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $check_time = date('Y-m-d H:i:s', time() - ATTEMPT_WINDOW);
    
    // Count recent attempts
    $stmt = $db->prepare("
        SELECT COUNT(*) as attempt_count, MAX(attempt_time) as last_attempt 
        FROM login_attempts 
        WHERE (ip_address = ? OR email = ?) 
        AND attempt_time > ?
    ");
    $stmt->bind_param('sss', $ip, $email, $check_time);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    if ($result['attempt_count'] >= MAX_LOGIN_ATTEMPTS) {
        $last_attempt_time = strtotime($result['last_attempt']);
        $time_remaining = ($last_attempt_time + LOCKOUT_TIME) - time();
        
        if ($time_remaining > 0) {
            return [true, ceil($time_remaining / 60)];
        }
    }
    
    return [false, 0];
}

/**
 * Removes old login attempts from the database
 * 
 * @return void
 */
function cleanup_login_attempts() {
    global $db;
    
    // Remove attempts older than the attempt window
    $cleanup_time = date('Y-m-d H:i:s', time() - ATTEMPT_WINDOW);
    
    $stmt = $db->prepare("DELETE FROM login_attempts WHERE attempt_time < ?");
    $stmt->bind_param('s', $cleanup_time);
    $stmt->execute();
}

/**
 * Regenerate session ID to prevent session fixation attacks
 * 
 * @param bool $delete_old_session Whether to delete the old session data
 * @return void
 */
function regenerate_session() {
    if (session_status() === PHP_SESSION_ACTIVE) {
        try {
            // Get current session data
            $session_data = $_SESSION;
            
            // Clear session data but keep the session
            session_unset();
            
            // Generate new session ID
            if (@session_regenerate_id(true)) {
                // Restore session data
                $_SESSION = $session_data;
                $_SESSION['LAST_ACTIVITY'] = time();
                return true;
            }
            
            // If regeneration failed, at least restore the data
            $_SESSION = $session_data;
            $_SESSION['LAST_ACTIVITY'] = time();
            
            // Log the failure but don't break the flow
            error_log("Session ID regeneration failed, but session data preserved");
            return true;
        } catch (Exception $e) {
            error_log("Session regeneration error: " . $e->getMessage());
            return false;
        }
    }
    return false;
}

/**
 * Check if the session has timed out
 * 
 * @return bool True if session has timed out, false otherwise
 */
function check_session_timeout() {
    // If no last activity time is set, session has expired
    if (!isset($_SESSION['LAST_ACTIVITY'])) {
        return true;
    }
    
    // Check if session has expired
    if (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_LIFETIME) {
        // Session has expired, destroy it
        session_unset();
        session_destroy();
        return true;
    }
    
    // Update last activity time
    $_SESSION['LAST_ACTIVITY'] = time();
    return false;
}

/**
 * Generate a CSRF token and store it in the session
 * 
 * @return string The generated CSRF token
 */
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(CSRF_TOKEN_LENGTH));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate the CSRF token from the form submission
 * 
 * @param string $token The token to validate
 * @return bool True if token is valid, false otherwise
 */
function validate_csrf_token($token) {
    if (!empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
        // Token is valid, remove it so it can't be reused
        unset($_SESSION['csrf_token']);
        return true;
    }
    return false;
}

/**
 * Generate HTML for CSRF token input field
 * 
 * @return string HTML input field containing CSRF token
 */
function csrf_token_field() {
    $token = generate_csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}
