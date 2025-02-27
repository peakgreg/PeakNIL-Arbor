<?php
require_once __DIR__ . '/password_functions.php';

/**
 * Validates login credentials and returns any validation errors
 * 
 * @param string $email User's email
 * @param string $password User's password
 * @return array Array of validation errors, empty if none
 */
function validate_login($email, $password) {
    $errors = [];
    
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }
    
    return $errors;
}

/**
 * Attempts to authenticate a user with the given credentials
 * 
 * @param string $email User's email
 * @param string $password User's password
 * @return array|false Returns user data if successful, false if authentication fails
 */
function authenticate_user($email, $password) {
    global $db;
    
    $sql = "SELECT id, uuid, email, password_hash, username FROM users WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    
    if (!$user) {
        return false;
    }
    
    $verify_result = verify_password($password, $user['password_hash']);
    
    if ($verify_result['valid']) {
        error_log("Password verification successful");
        // Check if the password hash needs to be updated (e.g., if cost factor changed)
        if ($verify_result['needs_upgrade']) {
            error_log("Password hash needs upgrade, generating new Bcrypt hash");
            $new_hash = hash_password($password);
            error_log("New hash generated: " . substr($new_hash, 0, 20) . "...");
            
            $update_sql = "UPDATE users SET password_hash = ? WHERE id = ?";
            $update_stmt = $db->prepare($update_sql);
            if (!$update_stmt) {
                error_log("Failed to prepare update statement: " . $db->error);
                return false;
            }
            
            $update_stmt->bind_param('si', $new_hash, $user['id']);
            $result = $update_stmt->execute();
            if (!$result) {
                error_log("Failed to update password hash: " . $update_stmt->error);
            } else {
                error_log("Password hash updated successfully");
            }
        } else {
            error_log("Password hash is up to date");
        }
        
        unset($user['password_hash']); // Don't include password hash in session
        return $user;
    }
    
    return false;
}

/**
/**
 * Logs user activity to the database
 *
 * @param int $user_id User ID
 * @param string $activity Type of activity (log_in, log_out, etc.)
 * @return bool True if logged successfully, false otherwise
 */
function log_activity($user_id, $activity) {
    global $db;
    
    try {
        $stmt = $db->prepare("
            INSERT INTO activity_log (
                user_id,
                activity,
                ip_address,
                user_agent,
                additional_data
            ) VALUES (?, ?, ?, ?, ?)
        ");
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $additional_data = json_encode(['session_id' => session_id()]);
        
        $stmt->bind_param('issss', 
            $user_id, 
            $activity, 
            $ip,
            $ua,
            $additional_data
        );
        
        return $stmt->execute();
    } catch (mysqli_sql_exception $e) {
        error_log("Activity log error: " . $e->getMessage());
        return false;
    }
}

/**
 * Creates a new session for the authenticated user
 *
 * @param array $user User data to store in session
 * @return void
 */
function create_user_session($user) {
    // Regenerate session ID to prevent session fixation
    regenerate_session();
    
    // Set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['uuid'] = $user['uuid'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['logged_in'] = true;
    
    // Log login activity
    log_activity($user['id'], 'log_in');
}

/**
 * Logs out the current user by destroying their session
 *
 * @return void
 */
function logout_user() {
    // Store user_id before clearing session
    $user_id = $_SESSION['user_id'] ?? null;
    error_log("Logging out user ID: " . ($user_id ?? 'null'));
    
    // Clear all session data
    session_unset();
    
    // Destroy session and start a new one with a new ID
    session_destroy();
    session_start();
    session_regenerate_id(true);
    
    // Log logout activity after session is cleared
    if ($user_id) {
        error_log("Attempting to log logout activity for user ID: $user_id");
        $result = log_activity($user_id, 'log_out');
        error_log("Logout activity result: " . ($result ? 'success' : 'failed'));
    } else {
        error_log("No user ID found for logout activity");
    }
}

/**
 * Checks if a user is currently logged in
 * 
 * @return bool True if user is logged in, false otherwise
 */
function is_logged_in() {
    return isset($_SESSION['uuid']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}
