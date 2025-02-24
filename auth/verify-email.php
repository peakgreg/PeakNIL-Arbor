<?php
// Start output buffering
ob_start();

require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/functions/register_functions.php';
require_once __DIR__ . '/functions/login_functions.php';
require_once __DIR__ . '/middleware/auth_middleware.php';

// Debug log
error_log('Verify-email.php - Session ID: ' . session_id());
error_log('Verify-email.php - Session data: ' . print_r($_SESSION, true));

// Check session state
if (!isset($_SESSION['uuid']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    error_log('Verify-email.php - Session invalid - redirecting to login');
    header('Location: /login');
    exit;
}

// Redirect if already verified
if (is_email_verified()) {
    error_log('Verify-email.php - Email already verified - redirecting to dashboard');
    header('Location: /dashboard');
    exit;
}

// Check if code is provided
$code = $_GET['code'] ?? $_POST['code'] ?? null;
$error = null;
$success = false;

// Get user's email for display
$stmt = $db->prepare("SELECT email FROM users WHERE uuid = ?");
if (!$stmt) {
    error_log("Prepare failed: " . $db->error);
    $error = "An error occurred. Please try again later.";
} else {
    $stmt->bind_param("s", $_SESSION['uuid']);
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        $error = "An error occurred. Please try again later.";
    } else {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $user_email = $user['email'] ?? '';
    }
    $stmt->close();
}

if ($code && !$error) {
    // Ensure code is exactly 4 digits
    if (!preg_match('/^[0-9]{4}$/', $code)) {
        $error = "Invalid verification code format. Please enter 4 digits.";
    } else {
        // Verify the code
        $stmt = $db->prepare("
            SELECT id 
            FROM users 
            WHERE email_confirmation_code = ? 
            AND email_verified = 0
            AND uuid = ?
        ");
        if (!$stmt) {
            error_log("Prepare failed: " . $db->error);
            $error = "An error occurred. Please try again later.";
        } else {
            $stmt->bind_param("ss", $code, $_SESSION['uuid']);
            if (!$stmt->execute()) {
                error_log("Execute failed: " . $stmt->error);
                $error = "An error occurred. Please try again later.";
            } else {
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                if ($user) {
                    // Update user as verified
                    $update = $db->prepare("
                        UPDATE users 
                        SET email_verified = 1,
                            email_confirmation_code = NULL 
                        WHERE id = ?
                    ");
                    if (!$update) {
                        error_log("Prepare failed: " . $db->error);
                        $error = "An error occurred. Please try again later.";
                    } else {
                        $update->bind_param("i", $user['id']);
                        if ($update->execute()) {
                            $success = true;
                            $_SESSION['email_verified'] = true;
                        } else {
                            error_log("Execute failed: " . $update->error);
                            $error = "Failed to verify email. Please try again.";
                        }
                        $update->close();
                    }
                } else {
                    $error = "Invalid verification code.";
                }
            }
            $stmt->close();
        }
    }
}

// Load the view
require_once __DIR__ . '/views/view.verify-email.php';

// Flush output buffer
ob_end_flush();
