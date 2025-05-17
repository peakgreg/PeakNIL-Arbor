<?php
namespace API\Middleware;

use API\Core\Response;

class APIAuth {
    const VERSION = '1.0';
    const RATE_LIMIT = 1000; // Requests per hour
    
    public static function authenticate(\mysqli $conn) {
        // Get API Key from header
        $apiKey = $_SERVER['HTTP_X_API_KEY'] ?? null;
        
        if (!$apiKey) {
            error_log("API Error: No API key provided");
            Response::unauthorized('API key required')->send();
        }
        
        error_log("API Debug: Received key: " . $apiKey);
        
        // Validate API Key
        $keyHash = hash('sha256', $apiKey);
        error_log("API Debug: Key hash: " . $keyHash);
        
        $stmt = $conn->prepare("SELECT * FROM api_keys WHERE api_key_hash = ? AND is_active = TRUE");
        if (!$stmt) {
            error_log("API Error: Prepare failed: " . $conn->error);
            Response::serverError('Database error')->send();
        }
        
        $stmt->bind_param("s", $keyHash);
        if (!$stmt->execute()) {
            error_log("API Error: Execute failed: " . $stmt->error);
            Response::serverError('Database error')->send();
        }
        
        $result = $stmt->get_result();
        error_log("API Debug: Found rows: " . $result->num_rows);
        
        if ($result->num_rows === 0) {
            error_log("API Error: Invalid API key hash: " . $keyHash);
            Response::unauthorized('Invalid API key')->send();
        }
        
        $keyData = $result->fetch_assoc();
        
        // Check rate limit
        if ($keyData['requests_made'] >= $keyData['rate_limit']) {
            error_log("API Error: Rate limit exceeded for key: " . $keyHash);
            Response::error('Rate limit exceeded', 429)->send();
        }
        
        // Update request count
        $updateStmt = $conn->prepare("UPDATE api_keys SET requests_made = requests_made + 1 WHERE id = ?");
        if (!$updateStmt) {
            error_log("API Error: Update prepare failed: " . $conn->error);
            Response::serverError('Database error')->send();
        }
        
        $updateStmt->bind_param("i", $keyData['id']);
        if (!$updateStmt->execute()) {
            error_log("API Error: Update execute failed: " . $updateStmt->error);
            Response::serverError('Database error')->send();
        }
        
        return $keyData;
    }
}
