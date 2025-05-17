<?php
// Start output buffering
ob_start();

require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/functions/register_functions.php';
require_once __DIR__ . '/../modules/common/functions/security_functions.php';

// Set security headers
set_security_headers();

// Debug log
error_log('Register.php - Session ID: ' . session_id());
error_log('Register.php - Session data: ' . print_r($_SESSION, true));

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: /dashboard');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $errors['general'] = 'Invalid request';
        $_SESSION['form_errors'] = $errors;
        header('Location: /register');
        exit;
    }

    // Sanitize user inputs
    $username = sanitize_input(trim($_POST['username'] ?? ''));
    $email = sanitize_input(trim($_POST['email'] ?? ''));
    $password = sanitize_input($_POST['password'] ?? '');
    $confirm_password = sanitize_input($_POST['confirm_password'] ?? '');
    
    // Validate input
    $errors = validate_registration($username, $email, $password, $confirm_password);
    
    // Check if username exists
    if (empty($errors['username']) && username_exists($username)) {
        $errors['username'] = 'Username already taken';
    }
    
    // Check if email exists
    if (empty($errors['email']) && email_exists($email)) {
        $errors['email'] = 'Email already registered';
    }
    
    // If no errors, create user
    if (empty($errors)) {
        error_log('Attempting to create user with username: ' . $username . ' and email: ' . $email);
        $result = create_user($username, $email, $password);
        
        if (isset($result['error'])) {
            error_log('User creation failed: ' . $result['error']);
            $errors['general'] = 'Registration failed: ' . $result['error'];
        } elseif (isset($result['user_id'])) {
            error_log('User created successfully with ID: ' . $result['user_id']);
            error_log('Current session ID: ' . session_id());
            error_log('Session data before: ' . print_r($_SESSION, true));
            
            // Set session variables
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['uuid'] = $result['uuid'];
            $_SESSION['logged_in'] = true;
            
            error_log('Session data after: ' . print_r($_SESSION, true));
            error_log('Verification code for testing: ' . $result['verification_code']);
            
            // Redirect to verification page
            header('Location: /verify-email');
            exit;
        } else {
            error_log('Unexpected result from create_user(): ' . print_r($result, true));
            $errors['general'] = 'An unexpected error occurred. Please try again.';
        }
    }
    
    // Convert errors to JSON for AJAX response
    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
        header('Location: /register');
        exit;
    }
}

// Load the registration view
require_once __DIR__ . '/views/view.register.php';

// Flush output buffer
ob_end_flush();
