<?php
// Start output buffering
ob_start();

require_once __DIR__ . '/../config/init.php';
require_once MODULES_PATH . '/common/functions/security_functions.php';
require_once __DIR__ . '/functions/login_functions.php';

// Set security headers
set_security_headers();

// Verify CSRF token for POST logout (prevents CSRF logout attacks)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        header('Location: /dashboard?error=invalid_request');
        exit;
    }
}

// Use the logout_user function from login_functions.php
logout_user();

// Clear any other auth-related cookies if they exist
$auth_cookies = ['remember_me', 'user_token'];
foreach ($auth_cookies as $cookie) {
    if (isset($_COOKIE[$cookie])) {
        setcookie(
            $cookie,
            '',
            [
                'expires' => time() - 3600,
                'path' => '/',
                'domain' => $_SERVER['HTTP_HOST'],
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]
        );
    }
}

// Redirect to login page with cache-control headers
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
header('Location: /login');

// Flush output buffer
ob_end_flush();
exit();
