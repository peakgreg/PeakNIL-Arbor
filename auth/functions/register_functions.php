<?php

require_once MODULES_PATH . '/common/helpers/string_helper.php';
require_once __DIR__ . '/password_functions.php';
require_once MODULES_PATH . '/common/functions/email_functions.php';

/**
 * Check if user can resend verification email
 * Implements rate limiting - only allows one attempt every 2 minutes
 * 
 * @param int $user_id User ID to check
 * @return array ['can_resend' => bool, 'wait_time' => int] Whether user can resend and seconds to wait if not
 */
function can_resend_verification($user_id) {
    global $db;
    
    // Get time difference in seconds since last attempt
    $query = "
        SELECT 
            TIMESTAMPDIFF(SECOND, attempted_at, NOW()) as seconds_since_attempt,
            attempted_at
        FROM verification_attempts 
        WHERE user_id = ? 
        ORDER BY attempted_at DESC 
        LIMIT 1
    ";
    if ($stmt = $db->prepare($query)) {
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $seconds_since_attempt = (int)$row['seconds_since_attempt'];
            $wait_time = 120 - $seconds_since_attempt;

            error_log(sprintf(
                "Rate limit check - Last attempt: %s, Seconds since attempt: %d, Wait time: %d seconds",
                $row['attempted_at'],
                $seconds_since_attempt,
                $wait_time
            ));
            
            $stmt->close();
            return [
                'can_resend' => $wait_time <= 0,
                'wait_time' => max(0, $wait_time)
            ];
        } else {
            $stmt->close();
            return ['can_resend' => true, 'wait_time' => 0];
        }
    } else {
        error_log("Database error preparing statement: " . $db->error);
        return ['can_resend' => false, 'wait_time' => 120];
    }
    
    if (!$result) {
        return ['can_resend' => true, 'wait_time' => 0];
    }
    
    $seconds_since_attempt = (int)$result['seconds_since_attempt'];
    $wait_time = 120 - $seconds_since_attempt;

    error_log(sprintf(
        "Rate limit check - Last attempt: %s, Seconds since attempt: %d, Wait time: %d seconds",
        $result['attempted_at'],
        $seconds_since_attempt,
        $wait_time
    ));
    
    return [
        'can_resend' => $wait_time <= 0,
        'wait_time' => max(0, $wait_time)
    ];
}

/**
 * Log a verification email attempt
 * 
 * @param int $user_id User ID making the attempt
 * @return bool Whether the attempt was logged successfully
 */
function log_verification_attempt($user_id) {
    global $db;
    
    try {
        $stmt = $db->prepare("
            INSERT INTO verification_attempts (user_id) 
            VALUES (?)
        ");
        
        $stmt->bind_param('i', $user_id);
        return $stmt->execute();
        
    } catch (Exception $e) {
        error_log("Error logging verification attempt: " . $e->getMessage());
        return false;
    }
}

/**
 * Generate a random 4-digit verification code
 * 
 * @return string 4-digit code
 */
function generate_verification_code() {
    // Generate as string to preserve leading zeros
    $code = '';
    for ($i = 0; $i < 4; $i++) {
        $code .= (string)mt_rand(0, 9);
    }
    return $code;
}

/**
 * Send email verification code to user
 * 
 * @param string $email User's email address
 * @param string $code Verification code
 * @param string $username User's username
 * @return bool Whether the email was sent successfully
 */
function send_verification_email($email, $code, $username) {
    $subject = 'Verify Your Email Address';
    $title = 'Email Verification Required';
    $verification_url = 'http://localhost:8000/verify-email?code=' . $code;
    
    $body = "Hello $username,<br><br>";
    $body .= "Thank you for registering. To complete your registration, please verify your email address using the following code:<br><br>";
    $body .= "<strong style='font-size: 24px;'>$code</strong><br><br>";
    $body .= "Or click the following link:<br>";
    $body .= "<a href='$verification_url'>$verification_url</a><br><br>";
    $body .= "If you did not create an account, please ignore this email.";
    
    return send_template_email($email, $subject, $title, $body);
}

/**
 * Validates registration input data
 * 
 * @param string $username
 * @param string $email
 * @param string $password
 * @param string $confirm_password
 * @return array Array of errors if validation fails, empty array if validation passes
 */
function validate_registration($username, $email, $password, $confirm_password) {
    $errors = [];
    
    // Validate username
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $errors['username'] = 'Username must be between 3 and 50 characters';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors['username'] = 'Username can only contain letters, numbers and underscores';
    }
    
    // Validate email
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    } elseif (strlen($email) > 255) {
        $errors['email'] = 'Email must not exceed 255 characters';
    }
    
    // Validate password
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $password)) {
        $errors['password'] = 'Password must contain at least one uppercase letter, one lowercase letter, and one number';
    }
    
    // Validate password confirmation
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match';
    }
    
    return $errors;
}

/**
 * Checks if username already exists
 * 
 * @param string $username
 * @return bool
 */
function username_exists($username) {
    global $db;
    
    $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows > 0;
}

/**
 * Checks if email already exists
 * 
 * @param string $email
 * @return bool
 */
function email_exists($email) {
    global $db;
    
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows > 0;
}

/**
 * Creates a new user account with associated records in related tables
 * 
 * @param string $username
 * @param string $email
 * @param string $password
 * @return array|false Array containing user_id and uuid if successful, false if failed
 */
function create_user($username, $email, $password) {
    global $db;
    
    if (!$db) {
        error_log("Database connection error in create_user()");
        return ['error' => 'Database connection failed'];
    }
    
    try {
        $uuid = generate_uuid();
        $hashed_password = hash_password($password);
        $created_at = date('Y-m-d H:i:s');
        $verification_code = generate_verification_code();
        $timestamp = time();
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? null;
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        
        // Use mysqli transaction methods
        $db->begin_transaction();
        
        try {
            // 1. Insert into users table
            $stmt_users = $db->prepare("
                INSERT INTO users (
                    uuid, username, email, password_hash, created_at, 
                    email_verified, email_confirmation_code
                ) VALUES (
                    ?, ?, ?, ?, ?, 
                    0, ?
                )
            ");
            
            if (!$stmt_users) {
                throw new Exception("Prepare statement failed for users table: " . $db->error);
            }
            
            $stmt_users->bind_param('ssssss', 
                $uuid, 
                $username, 
                $email, 
                $hashed_password, 
                $created_at, 
                $verification_code
            );
            
            if (!$stmt_users->execute()) {
                throw new Exception("Failed to insert user: " . $stmt_users->error);
            }
            
            $user_id = $db->insert_id;
            $stmt_users->close();
            
            // 2. Insert into user_flags table
            $stmt_flags = $db->prepare("
                INSERT INTO user_flags (
                    uuid, verified, imported, dynamic_pricing, 
                    deactivated, banned, workbench_access, debug_access
                ) VALUES (
                    ?, 0, 0, 0, 
                    0, 0, 0, 0
                )
            ");
            
            if (!$stmt_flags) {
                throw new Exception("Prepare statement failed for user_flags table: " . $db->error);
            }
            
            $stmt_flags->bind_param('s', $uuid);
            
            if (!$stmt_flags->execute()) {
                throw new Exception("Failed to insert user_flags: " . $stmt_flags->error);
            }
            $stmt_flags->close();
            
            // 3. Insert into user_metadata table
            $stmt_metadata = $db->prepare("
                INSERT INTO user_metadata (
                    uuid, ip_address, user_agent, signup_timestamp, 
                    accepted_terms_at, tos_version
                ) VALUES (
                    ?, ?, ?, ?, 
                    ?, 1
                )
            ");
            
            if (!$stmt_metadata) {
                throw new Exception("Prepare statement failed for user_metadata table: " . $db->error);
            }
            
            $stmt_metadata->bind_param('sssii', 
                $uuid, 
                $ip_address, 
                $user_agent, 
                $timestamp, 
                $timestamp
            );
            
            if (!$stmt_metadata->execute()) {
                throw new Exception("Failed to insert user_metadata: " . $stmt_metadata->error);
            }
            $stmt_metadata->close();
            
            // 4. Insert into user_profiles table
            $stmt_profiles = $db->prepare("
                INSERT INTO user_profiles (
                    uuid, access_level, role_id
                ) VALUES (
                    ?, 1, 1
                )
            ");
            
            if (!$stmt_profiles) {
                throw new Exception("Prepare statement failed for user_profiles table: " . $db->error);
            }
            
            $stmt_profiles->bind_param('s', $uuid);
            
            if (!$stmt_profiles->execute()) {
                throw new Exception("Failed to insert user_profiles: " . $stmt_profiles->error);
            }
            $stmt_profiles->close();
            
            // Log the verification code for debugging
            error_log("Generated verification code for $email: $verification_code");
            
            // Send verification email
            if (!send_verification_email($email, $verification_code, $username)) {
                throw new Exception("Failed to send verification email");
            }
            
            // Commit transaction
            $db->commit();
            return [
                'user_id' => $user_id,
                'uuid' => $uuid,
                'verification_code' => $verification_code // Add this for debugging
            ];
            
        } catch (Exception $e) {
            $db->rollback();
            error_log("User creation error: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    } catch (Exception $e) {
        error_log("Password hashing error: " . $e->getMessage());
        return ['error' => 'Password hashing failed'];
    }
}
