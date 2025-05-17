<?php
require_once __DIR__ . '/../config/init.php';

try {
    global $db;
    
    // Create api_keys table
    $createTable = "
    CREATE TABLE IF NOT EXISTS `api_keys` (
        `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        `api_key_hash` VARCHAR(64) NOT NULL COMMENT 'SHA-256 hash of the API key',
        `name` VARCHAR(255) NOT NULL COMMENT 'Name/description of the API key',
        `is_active` TINYINT(1) NOT NULL DEFAULT 1,
        `rate_limit` INT UNSIGNED NOT NULL DEFAULT 1000 COMMENT 'Requests per hour limit',
        `requests_made` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Number of requests made in current hour',
        `last_request` TIMESTAMP NULL DEFAULT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `api_key_hash` (`api_key_hash`),
        INDEX `idx_is_active` (`is_active`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";
    
    if (!$db->query($createTable)) {
        throw new Exception("Error creating table: " . $db->error);
    }
    
    // Insert test API key
    $testKey = 'test-api-key-123';
    $keyHash = hash('sha256', $testKey);
    
    $insertKey = "
    INSERT INTO `api_keys` (`api_key_hash`, `name`, `is_active`, `rate_limit`, `requests_made`) 
    VALUES (?, 'Test API Key', 1, 1000, 0)
    ON DUPLICATE KEY UPDATE 
    name = VALUES(name), 
    is_active = VALUES(is_active), 
    rate_limit = VALUES(rate_limit)
    ";
    
    $stmt = $db->prepare($insertKey);
    if (!$stmt) {
        throw new Exception("Error preparing statement: " . $db->error);
    }
    
    $stmt->bind_param('s', $keyHash);
    if (!$stmt->execute()) {
        throw new Exception("Error executing statement: " . $stmt->error);
    }
    
    echo "API setup completed successfully.\n";
    echo "Test API Key: " . $testKey . "\n";
    echo "Key Hash: " . $keyHash . "\n";
    
    $stmt->close();
    
} catch (Exception $e) {
    die("Error setting up API: " . $e->getMessage() . "\n");
}
