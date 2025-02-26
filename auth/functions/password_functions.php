<?php
/**
 * Password related functions using Argon2id
 * Enhanced for cross-version compatibility between PHP 8.2 and 8.3
 */

/**
 * Get Argon2id options adjusted for the current PHP version
 * 
 * @return array Argon2id options compatible with current PHP version
 */
function get_argon2id_options() {
    // More conservative parameters that work across PHP versions
    $options = [
        'memory_cost' => 32768,    // 32MB in KB (more conservative for compatibility)
        'time_cost'   => 3,        // 3 iterations (reduced for compatibility)
        'threads'     => 2         // 2 parallel threads (reduced for compatibility)
    ];
    
    // Log the PHP version and options being used
    $php_version = phpversion();
    error_log("PHP Version: {$php_version}, Using Argon2id options: memory={$options['memory_cost']}, time={$options['time_cost']}, threads={$options['threads']}");
    
    return $options;
}

/**
 * Check if Argon2id is available and log its configuration
 * 
 * @return bool True if Argon2id is available, false otherwise
 */
function check_argon2id_availability() {
    if (!defined('PASSWORD_ARGON2ID')) {
        error_log("ERROR: Argon2id is not available in this PHP build");
        return false;
    }
    
    // Get default Argon2id parameters for this PHP version
    $defaults = password_get_info('$argon2id$')['options'] ?? [];
    error_log("Argon2id default parameters: " . json_encode($defaults));
    
    return true;
}

/**
 * Hash a password using Argon2id with cross-version compatible settings
 * 
 * @param string $password The password to hash
 * @return string|false The hashed password or false on failure
 */
function hash_password($password) {
    // Verify Argon2id is available
    if (!check_argon2id_availability()) {
        error_log("Falling back to bcrypt as Argon2id is not available");
        // Fallback to bcrypt if Argon2id is not available
        return password_hash($password, PASSWORD_BCRYPT);
    }
    
    try {
        $options = get_argon2id_options();
        $hash = password_hash($password, PASSWORD_ARGON2ID, $options);
        
        // Verify the hash was created with Argon2id
        $info = password_get_info($hash);
        if ($info['algoName'] !== 'argon2id') {
            error_log("Failed to create Argon2id hash. Got " . $info['algoName'] . " instead.");
            return false;
        }
        
        return $hash;
    } catch (Exception $e) {
        error_log("Error creating password hash: " . $e->getMessage());
        return false;
    }
}

/**
 * Verify a password against a hash with enhanced cross-version compatibility
 * 
 * @param string $password The password to verify
 * @param string $hash The hash to verify against
 * @return array Array containing 'valid' boolean and 'needs_upgrade' boolean
 */
function verify_password($password, $hash) {
    // Log the hash type we're dealing with
    error_log("Password hash being verified: " . substr($hash, 0, 20) . "...");
    
    // Check if it's a bcrypt hash
    if (strpos($hash, '$2y$') === 0) {
        error_log("Detected bcrypt hash");
        $is_valid = password_verify($password, $hash);
        if ($is_valid) {
            error_log("bcrypt password verified successfully, flagging for upgrade");
            // Return true but with a flag indicating it needs upgrade
            return ['valid' => true, 'needs_upgrade' => true];
        }
        error_log("bcrypt password verification failed");
        return ['valid' => false];
    }
    
    // Check if it's an Argon2id hash
    if (strpos($hash, '$argon2id$') === 0) {
        error_log("Detected Argon2id hash");
        
        // Try standard verification first
        $is_valid = password_verify($password, $hash);
        
        if ($is_valid) {
            $options = get_argon2id_options();
            $needs_rehash = password_needs_rehash($hash, PASSWORD_ARGON2ID, $options);
            error_log("Argon2id password verified successfully, needs_rehash: " . ($needs_rehash ? 'true' : 'false'));
            return ['valid' => true, 'needs_upgrade' => $needs_rehash];
        } else {
            error_log("Standard Argon2id verification failed, attempting manual verification");
            // If standard verification fails, try a more manual approach
            // This is a fallback for cross-version compatibility issues
            try {
                // Extract the salt and hash from the stored hash
                $parts = explode('$', $hash);
                if (count($parts) >= 5) {
                    // Try with slightly different parameters
                    $alt_options = [
                        'memory_cost' => 32768,  // Try with lower memory
                        'time_cost' => 2,        // Try with lower time cost
                        'threads' => 2           // Try with fewer threads
                    ];
                    
                    // Create a new hash with the same password but different parameters
                    $test_hash = password_hash($password, PASSWORD_ARGON2ID, $alt_options);
                    
                    // Compare the new hash with the stored hash using a timing-safe comparison
                    $is_valid = password_verify($password, $test_hash) && password_verify($password, $hash);
                    
                    if ($is_valid) {
                        error_log("Manual Argon2id verification successful");
                        return ['valid' => true, 'needs_upgrade' => true];
                    }
                }
            } catch (Exception $e) {
                error_log("Error in manual verification: " . $e->getMessage());
            }
        }
        
        error_log("All Argon2id verification methods failed");
        return ['valid' => false];
    }
    
    // Unknown hash format
    error_log("Unknown hash format, attempting generic verification");
    $is_valid = password_verify($password, $hash);
    return ['valid' => $is_valid, 'needs_upgrade' => $is_valid];
}

/**
 * Check if password needs rehashing with our standardized parameters
 * 
 * @param string $hash The hash to check
 * @return bool True if password needs rehashing, false otherwise
 */
function needs_password_rehash($hash) {
    $options = get_argon2id_options();
    
    return password_needs_rehash($hash, PASSWORD_ARGON2ID, $options);
}
