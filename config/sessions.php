<?php
error_log('Starting sessions.php');

// Basic session configuration
ini_set('session.use_strict_mode', 1);
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.gc_maxlifetime', SESSION_LIFETIME);

// Use files for session storage
ini_set('session.save_handler', 'files');

// Set session path
$session_path = ini_get('session.save_path') ?: sys_get_temp_dir();
error_log('Session save path: ' . $session_path);

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    error_log('Starting new session');
    session_start();
    error_log('New session started with ID: ' . session_id());
    
    // Initialize session if needed
    if (!isset($_SESSION['LAST_ACTIVITY'])) {
        $_SESSION['LAST_ACTIVITY'] = time();
        error_log('Initialized new session with LAST_ACTIVITY');
    }
}

error_log('Current session data: ' . print_r($_SESSION, true));
