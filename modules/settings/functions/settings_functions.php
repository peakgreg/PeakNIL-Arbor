<?php
/**
 * Functions for handling user settings
 */

/**
 * Get all settings for the current user
 * 
 * @return array User settings
 */
function get_user_settings() {
    global $db;  // Assuming database connection is available
    
    $user_id = $_SESSION['user_id'] ?? 0;
    
    try {
        $stmt = $db->prepare("
            SELECT name, email, timezone, notifications 
            FROM user_settings 
            WHERE user_id = ?
        ");
        
        $stmt->execute([$user_id]);
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $settings ?: [
            'name' => '',
            'email' => '',
            'timezone' => 'UTC',
            'notifications' => false
        ];
    } catch (PDOException $e) {
        error_log("Error fetching user settings: " . $e->getMessage());
        return false;
    }
}

/**
 * Update general settings for user
 * 
 * @param array $data Posted form data
 * @return array Result with success or error message
 */
function update_general_settings($data) {
    global $db;
    
    $user_id = $_SESSION['user_id'] ?? 0;
    
    // Validate inputs
    if (empty($data['name'])) {
        return ['error' => 'Name is required'];
    }
    
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        return ['error' => 'Valid email is required'];
    }
    
    if (empty($data['timezone']) || !in_array($data['timezone'], DateTimeZone::listIdentifiers())) {
        return ['error' => 'Valid timezone is required'];
    }
    
    try {
        $stmt = $db->prepare("
            INSERT INTO user_settings (user_id, name, email, timezone, notifications)
            VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
                name = VALUES(name),
                email = VALUES(email),
                timezone = VALUES(timezone),
                notifications = VALUES(notifications)
        ");
        
        $notifications = isset($data['notifications']) ? 1 : 0;
        
        $stmt->execute([
            $user_id,
            $data['name'],
            $data['email'],
            $data['timezone'],
            $notifications
        ]);
        
        return ['success' => 'Settings updated successfully'];
    } catch (PDOException $e) {
        error_log("Error updating user settings: " . $e->getMessage());
        return ['error' => 'Failed to update settings'];
    }
}

/**
 * Get list of available timezones
 * 
 * @return array List of timezone identifiers
 */
function get_timezone_list() {
    return DateTimeZone::listIdentifiers(DateTimeZone::ALL);
}

/**
 * Validate timezone
 * 
 * @param string $timezone Timezone to validate
 * @return bool Whether timezone is valid
 */
function is_valid_timezone($timezone) {
    return in_array($timezone, DateTimeZone::listIdentifiers());
}


/**
 * Get user's security settings
 * 
 * @return array Security settings
 */
function get_security_settings() {
    global $db;
    
    $user_id = $_SESSION['user_id'] ?? 0;
    
    try {
        $stmt = $db->prepare("
            SELECT two_factor_enabled, last_password_change, 
                   login_notifications, recent_activity
            FROM user_security_settings 
            WHERE user_id = ?
        ");
        
        $stmt->execute([$user_id]);
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Get recent login activity
        $activity = get_recent_login_activity($user_id);
        
        return array_merge($settings ?: [
            'two_factor_enabled' => false,
            'last_password_change' => null,
            'login_notifications' => false
        ], ['recent_activity' => $activity]);
        
    } catch (PDOException $e) {
        error_log("Error fetching security settings: " . $e->getMessage());
        return false;
    }
}

/**
 * Update security settings
 * 
 * @param array $data Posted form data
 * @return array Result with success or error message
 */
function update_security_settings($data) {
    global $db;
    
    $user_id = $_SESSION['user_id'] ?? 0;
    
    try {
        // Update 2FA status if changing
        if (isset($data['enable_2fa'])) {
            $success = setup_2fa($user_id);
            if (!$success) {
                return ['error' => 'Failed to enable 2FA'];
            }
        }
        
        $stmt = $db->prepare("
            INSERT INTO user_security_settings 
                (user_id, two_factor_enabled, login_notifications)
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE 
                two_factor_enabled = VALUES(two_factor_enabled),
                login_notifications = VALUES(login_notifications)
        ");
        
        $two_factor = isset($data['enable_2fa']) ? 1 : 0;
        $notifications = isset($data['login_notifications']) ? 1 : 0;
        
        $stmt->execute([
            $user_id,
            $two_factor,
            $notifications
        ]);
        
        return ['success' => 'Security settings updated successfully'];
    } catch (PDOException $e) {
        error_log("Error updating security settings: " . $e->getMessage());
        return ['error' => 'Failed to update security settings'];
    }
}

/**
 * Change user password
 * 
 * @param array $data Password data
 * @return array Result with success or error message
 */
function change_password($data) {
    global $db;
    
    $user_id = $_SESSION['user_id'] ?? 0;
    
    // Validate inputs
    if (empty($data['current_password'])) {
        return ['error' => 'Current password is required'];
    }
    
    if (empty($data['new_password']) || strlen($data['new_password']) < 8) {
        return ['error' => 'New password must be at least 8 characters'];
    }
    
    if ($data['new_password'] !== $data['confirm_password']) {
        return ['error' => 'New passwords do not match'];
    }
    
    try {
        // Verify current password
        $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
        
        if (!password_verify($data['current_password'], $user['password'])) {
            return ['error' => 'Current password is incorrect'];
        }
        
        // Update password
        $stmt = $db->prepare("
            UPDATE users 
            SET password = ?, password_changed_at = CURRENT_TIMESTAMP 
            WHERE id = ?
        ");
        
        $new_password_hash = password_hash($data['new_password'], PASSWORD_DEFAULT);
        $stmt->execute([$new_password_hash, $user_id]);
        
        // Log the password change
        log_security_event($user_id, 'password_changed');
        
        return ['success' => 'Password updated successfully'];
    } catch (PDOException $e) {
        error_log("Error changing password: " . $e->getMessage());
        return ['error' => 'Failed to update password'];
    }
}

/**
 * Get recent login activity
 * 
 * @param int $user_id User ID
 * @return array Recent login attempts
 */
function get_recent_login_activity($user_id) {
    global $db;
    
    try {
        $stmt = $db->prepare("
            SELECT ip_address, user_agent, status, created_at
            FROM login_attempts
            WHERE user_id = ?
            ORDER BY created_at DESC
            LIMIT 5
        ");
        
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching login activity: " . $e->getMessage());
        return [];
    }
}

/**
 * Log security-related events
 * 
 * @param int $user_id User ID
 * @param string $event Event type
 * @param array $data Additional data
 */
function log_security_event($user_id, $event, $data = []) {
    global $db;
    
    try {
        $stmt = $db->prepare("
            INSERT INTO security_events 
                (user_id, event_type, event_data, ip_address) 
            VALUES (?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $user_id,
            $event,
            json_encode($data),
            $_SERVER['REMOTE_ADDR']
        ]);
    } catch (PDOException $e) {
        error_log("Error logging security event: " . $e->getMessage());
    }
}

// EOF