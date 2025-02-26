<?php
/**
 * Password related functions using Argon2id
 */

/**
 * Hash a password using Argon2id
 * 
 * @param string $password The password to hash
 * @return string|false The hashed password or false on failure
 */
function hash_password($password) {
    // Verify Argon2id is available
    if (!defined('PASSWORD_ARGON2ID')) {
        throw new Exception('Argon2id hashing algorithm is not available. PHP was not compiled with Argon2id support.');
    }
    
    $options = [
        'memory_cost' => 65536,    // 64MB in KB (recommended for web servers)
        'time_cost'   => 4,        // 4 iterations
        'threads'     => 3         // 3 parallel threads
    ];
    
    $hash = password_hash($password, PASSWORD_ARGON2ID, $options);
    
    // Verify the hash was created with Argon2id
    $info = password_get_info($hash);
    if ($info['algoName'] !== 'argon2id') {
        throw new Exception('Failed to create Argon2id hash. Got ' . $info['algoName'] . ' instead.');
    }
    
    return $hash;
}

/**
 * Verify a password against a hash
 * 
 * @param string $password The password to verify
 * @param string $hash The hash to verify against
 * @return array Array containing 'valid' boolean and 'needs_upgrade' boolean
 */
function verify_password($password, $hash) {
    // Log the hash type we're dealing with
    error_log("Password hash being verified: " . substr($hash, 0, 20) . "...");
    
    // Check if it's a bcrypt hash
    if (strpos($hash, '$2y$10$') === 0) {
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
    
    // It's an Argon2id hash (or at least should be)
    error_log("Assuming Argon2id hash");
    $is_valid = password_verify($password, $hash);
    if ($is_valid) {
        $needs_rehash = needs_password_rehash($hash, PASSWORD_ARGON2ID);
        error_log("Argon2id password verified successfully, needs_rehash: " . ($needs_rehash ? 'true' : 'false'));
        return ['valid' => true, 'needs_upgrade' => $needs_rehash];
    }
    error_log("Argon2id password verification failed");
    return ['valid' => false];
}

/**
 * Check if password needs rehashing
 * 
 * @param string $hash The hash to check
 * @return bool True if password needs rehashing, false otherwise
 */
function needs_password_rehash($hash) {
    $options = [
        'memory_cost' => 65536,    // 64MB in KB
        'time_cost'   => 4,        // 4 iterations
        'threads'     => 3         // 3 parallel threads
    ];
    
    return password_needs_rehash($hash, PASSWORD_ARGON2ID, $options);
}
