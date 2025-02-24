<?php
// Start output buffering
ob_start();

require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/functions/register_functions.php';

$error = null;
$success = false;

// Check if user is logged in
if (!isset($_SESSION['uuid'])) {
    header('Location: /login');
    exit;
}

// Get user's email
$stmt = $db->prepare("
    SELECT email, username, email_verified 
    FROM users 
    WHERE id = ?
");
$stmt->execute([$_SESSION['uuid']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: /login');
    exit;
}

// Check if already verified
if ($user['email_verified']) {
    header('Location: /dashboard');
    exit;
}

// Check rate limit
$rate_check = can_resend_verification($_SESSION['uuid']);
if (!$rate_check['can_resend']) {
    $minutes = ceil($rate_check['wait_time'] / 60);
    $seconds = $rate_check['wait_time'] % 60;
    $wait_message = $minutes > 0 ? 
        "$minutes minute" . ($minutes > 1 ? 's' : '') : 
        "$seconds second" . ($seconds > 1 ? 's' : '');
    $error = "Please wait $wait_message before requesting another verification email.";
} else {
    try {
        // Start transaction
        $db->beginTransaction();

        // Log the attempt first - this must happen before anything else
        if (!log_verification_attempt($_SESSION['uuid'])) {
            throw new Exception("Failed to log verification attempt");
        }

        // Generate new verification code
        $new_code = generate_verification_code();

        // Update user's verification code
        $update = $db->prepare("
            UPDATE users 
            SET email_confirmation_code = ? 
            WHERE id = ?
        ");

        if (!$update->execute([$new_code, $_SESSION['uuid']])) {
            throw new Exception("Failed to update verification code");
        }

        // Send new verification email
        if (!send_verification_email($user['email'], $new_code, $user['username'])) {
            throw new Exception("Failed to send verification email");
        }

        // If we got here, everything succeeded
        $db->commit();
        $success = true;

    } catch (Exception $e) {
        $db->rollBack();
        $error = $e->getMessage();
        error_log("Resend verification error: " . $e->getMessage());
    }
}

// Load the view
require_once __DIR__ . '/views/view.resend-verification.php';

// Flush output buffer
ob_end_flush();
