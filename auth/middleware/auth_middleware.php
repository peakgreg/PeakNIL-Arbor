<?php
require_once __DIR__ . '/../functions/login_functions.php';
require_once MODULES_PATH . '/common/functions/security_functions.php';
require_once __DIR__ . '/../../config/config.php';

/**
 * Check if user's email is verified
 * 
 * @return bool True if email is verified or verification not required
 */
function is_email_verified() {
    global $db;
    
    if (!REQUIRE_EMAIL_VERIFICATION) {
        return true;
    }
    
    if (!isset($_SESSION['uuid'])) {
        return false;
    }
    
    $stmt = $db->prepare("SELECT email_verified FROM users WHERE id = ?");
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    return $result && $result['email_verified'] == 1;
}

function require_auth($skip_verification = false) {
    error_log('Auth check - Session ID: ' . session_id());
    error_log('Auth check - Session data: ' . print_r($_SESSION, true));
    
    // Check if session exists and has user data
    if (!isset($_SESSION['uuid']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        error_log('Auth check failed - Invalid session data');
        header('Location: /login');
        exit();
    }
    
    // Check for session timeout
    if (check_session_timeout()) {
        error_log('Auth check failed - Session timeout');
        header('Location: /login?error=session_expired');
        exit();
    }
    
    // Skip verification check if requested (for verification pages)
    if ($skip_verification) {
        error_log('Auth check - Skipping verification check');
        return;
    }
    
    // Check email verification if required
    if (REQUIRE_EMAIL_VERIFICATION && !is_email_verified()) {
        error_log('Auth check - Email not verified, redirecting to verification');
        header('Location: /verify-email');
        exit();
    }
    
    error_log('Auth check passed');
}

function require_admin() {
    require_auth();
    if (!is_admin()) {
        header('Location: /dashboard');
        exit();
    }
}

// EOF
