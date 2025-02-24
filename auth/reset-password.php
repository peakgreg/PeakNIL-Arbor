<?php
// Start output buffering
ob_start();

require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/functions/password_functions.php';
require_once MODULES_PATH . '/common/functions/security_functions.php';

// Set security headers
set_security_headers();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['uuid'])) {
    header('Location: /dashboard');
    exit;
}

$errors = [];
$success = false;

// Handle password reset request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!validate_csrf_token($_POST['csrf_token'] ?? '')) {
        $errors['general'] = 'Invalid request';
        header('Content-Type: application/json');
        echo json_encode(['errors' => $errors]);
        exit;
    }

    // Check if this is the initial reset request or token verification
    if (isset($_POST['email'])) {
        // Initial reset request
        $email = sanitize_input(trim($_POST['email'] ?? ''));
        
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Generate and store reset token, then send email
            $result = initiate_password_reset($email);
            if ($result) {
                $success = true;
            } else {
                $errors['email'] = 'Unable to process reset request. Please try again later.';
            }
        } else {
            $errors['email'] = 'Please enter a valid email address.';
        }
    } else if (isset($_POST['token'], $_POST['password'], $_POST['confirm_password'])) {
        // Password reset with token
        $token = sanitize_input($_POST['token']);
        $password = sanitize_input($_POST['password']);
        $confirm_password = sanitize_input($_POST['confirm_password']);
        
        // Validate password
        if (strlen($password) < 8) {
            $errors['password'] = 'Password must be at least 8 characters long.';
        } else if ($password !== $confirm_password) {
            $errors['confirm_password'] = 'Passwords do not match.';
        }
        
        if (empty($errors)) {
            // Verify token and update password
            $result = complete_password_reset($token, $password);
            if ($result) {
                $success = true;
                header('Location: /login?reset=success');
                exit;
            } else {
                $errors['general'] = 'Invalid or expired reset token.';
            }
        }
    }
    
    // Handle AJAX requests
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        if (!empty($errors)) {
            echo json_encode(['errors' => $errors]);
        } else {
            echo json_encode(['success' => true]);
        }
        exit;
    }
}

// Load the appropriate view
if (isset($_GET['token'])) {
    // Show reset form
    require_once __DIR__ . '/views/view.reset-password-form.php';
} else {
    // Show request form
    require_once __DIR__ . '/views/view.reset-password.php';
}

// Flush output buffer
ob_end_flush();
