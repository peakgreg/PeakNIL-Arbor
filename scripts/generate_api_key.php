<?php
require_once __DIR__ . '/../config/init.php';

function generateApiKey(): string {
    return bin2hex(random_bytes(32));
}

function saveApiKey(mysqli $db, string $apiKey, string $name, int $rateLimit = 1000): bool {
    $keyHash = hash('sha256', $apiKey);
    $stmt = $db->prepare("INSERT INTO api_keys (api_key_hash, name, rate_limit, is_active, created_at) VALUES (?, ?, ?, 1, NOW())");
    if (!$stmt) {
        error_log("Prepare failed: " . $db->error);
        return false;
    }

    $stmt->bind_param("ssi", $keyHash, $name, $rateLimit);
    $result = $stmt->execute();
    if (!$result) {
        error_log("Execute failed: " . $stmt->error);
        return false;
    }

    return true;
}

// Check if running from command line
if (php_sapi_name() === 'cli') {
    // Get name from command line argument or use default
    $name = $argv[1] ?? 'API Key ' . date('Y-m-d H:i:s');
    $rateLimit = (int)($argv[2] ?? 1000);

    // Generate and save new API key
    $apiKey = generateApiKey();
    if (saveApiKey($db, $apiKey, $name, $rateLimit)) {
        echo "API Key generated successfully!\n";
        echo "Name: $name\n";
        echo "Rate Limit: $rateLimit requests per hour\n";
        echo "API Key: $apiKey\n";
        echo "\nIMPORTANT: Store this key securely. It cannot be retrieved later.\n";
    } else {
        echo "Error generating API key\n";
    }
}
