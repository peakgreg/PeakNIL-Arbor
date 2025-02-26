<?php
/**
 * Password related functions with fallbacks for environments without Argon2id support
 */

/**
 * Hash a password using Argon2id or bcrypt
 * 
 * @param string $password The password to hash
 * @return string|false The hashed password or false on failure
 */
function hash_password($password) {
    // Check if Argon2id is available
    if (!defined('PASSWORD_ARGON2ID')) {
        error_log("Argon2id not available, using bcrypt");
        return password_hash($password, PASSWORD_BCRYPT);
    }
    
    $options = [
        'memory_cost' => 32768,
        'time_cost'   => 3,
        'threads'     => 2
    ];
    
    return password_hash($password, PASSWORD_ARGON2ID, $options);
}

/**
 * Verify a password against a hash
 * 
 * @param string $password The password to verify
 * @param string $hash The hash to verify against
 * @return array Array containing 'valid' boolean and 'needs_upgrade' boolean
 */
function verify_password($password, $hash) {
    // Log the hash type
    error_log("Password hash being verified: " . substr($hash, 0, 20) . "...");
    
    // Check if it's a bcrypt hash
    if (strpos($hash, '$2y$') === 0) {
        $is_valid = password_verify($password, $hash);
        if ($is_valid) {
            return ['valid' => true, 'needs_upgrade' => true];
        }
        return ['valid' => false];
    }
    
    // Check if it's an Argon2id hash
    if (strpos($hash, '$argon2id$') === 0) {
        // Check if Argon2id is available in this PHP build
        if (!defined('PASSWORD_ARGON2ID')) {
            error_log("WARNING: Argon2id hash detected but PASSWORD_ARGON2ID is not defined");
            // Try generic verification as a fallback
            $is_valid = password_verify($password, $hash);
            return ['valid' => $is_valid, 'needs_upgrade' => $is_valid];
        }
        
        // Standard verification
        $is_valid = password_verify($password, $hash);
        if ($is_valid) {
            $needs_rehash = false;
            if (defined('PASSWORD_ARGON2ID')) {
                $options = [
                    'memory_cost' => 32768,
                    'time_cost'   => 3,
                    'threads'     => 2
                ];
                $needs_rehash = password_needs_rehash($hash, PASSWORD_ARGON2ID, $options);
            }
            return ['valid' => true, 'needs_upgrade' => $needs_rehash];
        }
    }
    
    // Generic verification for unknown hash formats
    $is_valid = password_verify($password, $hash);
    return ['valid' => $is_valid, 'needs_upgrade' => $is_valid];
}

/**
 * Check if password needs rehashing
 * 
 * @param string $hash The hash to check
 * @return bool True if password needs rehashing, false otherwise
 */
function needs_password_rehash($hash) {
    // If Argon2id is not available, always return true to upgrade to bcrypt
    if (!defined('PASSWORD_ARGON2ID')) {
        return true;
    }
    
    $options = [
        'memory_cost' => 32768,
        'time_cost'   => 3,
        'threads'     => 2
    ];
    
    return password_needs_rehash($hash, PASSWORD_ARGON2ID, $options);
}
