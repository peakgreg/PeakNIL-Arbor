<?php
/**
 * Password related functions using Bcrypt
 */

/**
 * Hash a password using Bcrypt
 * 
 * @param string $password The password to hash
 * @return string|false The hashed password or false on failure
 */
function hash_password($password) {
    $options = [
        'cost' => 12  // Higher cost means more secure but slower
    ];
    
    $hash = password_hash($password, PASSWORD_BCRYPT, $options);
    
    // Verify the hash was created with Bcrypt
    $info = password_get_info($hash);
    if ($info['algoName'] !== 'bcrypt') {
        throw new Exception('Failed to create Bcrypt hash. Got ' . $info['algoName'] . ' instead.');
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
    
    // Verify the password against the bcrypt hash
    $is_valid = password_verify($password, $hash);
    if ($is_valid) {
        $needs_rehash = needs_password_rehash($hash);
        error_log("Bcrypt password verified successfully, needs_rehash: " . ($needs_rehash ? 'true' : 'false'));
        return ['valid' => true, 'needs_upgrade' => $needs_rehash];
    }
    error_log("Bcrypt password verification failed");
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
        'cost' => 12
    ];
    
    return password_needs_rehash($hash, PASSWORD_BCRYPT, $options);
}
