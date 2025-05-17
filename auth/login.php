<?php
// Start output buffering
ob_start();

require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/functions/login_functions.php';
require_once MODULES_PATH . '/common/functions/security_functions.php';

// Set security headers
set_security_headers();

// If user is already logged in, redirect to configured URL
if (isset($_SESSION['uuid'])) {
    header('Location: ' . LOGIN_REDIRECT_URL);
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if it's an AJAX request
    $is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    
    // Verify CSRF token
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode(['errors' => ['general' => 'Invalid request']]);
        } else {
            // Redirect back to login page with error message
            header('Location: /login?error=invalid_request');
        }
        exit;
    }

    // Sanitize user inputs
    $email = sanitize_input(trim($_POST['email'] ?? ''));
    $password = sanitize_input($_POST['password'] ?? '');
    
    // Check for login lockout
    list($is_locked, $minutes_remaining) = check_login_lockout($email);
    if ($is_locked) {
        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode(['errors' => ['general' => "Too many login attempts. Please try again in {$minutes_remaining} minutes."]]);
        } else {
            header("Location: /login?error=locked&minutes={$minutes_remaining}");
        }
        exit;
    }
    
    // Validate input
    $errors = validate_login($email, $password);
    
    // If no validation errors, attempt authentication
    if (empty($errors)) {
        $user = authenticate_user($email, $password);
        
        if ($user) {
            // Create user session and redirect to configured URL
            create_user_session($user);
            header('Location: ' . LOGIN_REDIRECT_URL);
            exit;
        } else {
            // Record failed login attempt
            record_login_attempt($email);
            $errors['general'] = 'Invalid email or password';
        }
    }
    
    // Handle errors
    if (!empty($errors)) {
        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode(['errors' => $errors]);
        } else {
            // For non-AJAX requests, redirect with error in query string
            $error_type = isset($errors['general']) ? 'invalid_credentials' : 'validation_failed';
            header("Location: /login?error={$error_type}");
        }
        exit;
    }
}

// Load the login view
require_once __DIR__ . '/views/view.login.php';

// Flush output buffer
ob_end_flush();
