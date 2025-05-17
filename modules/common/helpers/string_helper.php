<?php

/**
 * Generates a UUID v4
 * 
 * @return string UUID v4 string
 */
function generate_uuid() {
    // Generate 16 random bytes
    $bytes = random_bytes(16);
    
    // Set version to 4 (random)
    $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
    // Set variant to RFC 4122
    $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);
    
    // Format bytes into UUID string
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
}
