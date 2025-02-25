<?php

// Database configuration - environment variables are now loaded in init.php
$dbConfig = [
    'host' => $_ENV['DB_HOST'] ?? getenv('DB_HOST'),
    'name' => $_ENV['DB_NAME'] ?? getenv('DB_NAME'),
    'user' => $_ENV['DB_USER'] ?? getenv('DB_USER'),
    'password' => $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD'),
    'port' => $_ENV['DB_PORT'] ?? getenv('DB_PORT') ?? 3306,
    'charset' => 'utf8mb4'
];

// Initialize global mysqli connection
try {
    // Create connection with SSL enabled and store in both $db and $conn
    $db = $conn = mysqli_init();
    $db->ssl_set(NULL, NULL, NULL, NULL, NULL);
    $db->real_connect(
        $dbConfig['host'],
        $dbConfig['user'],
        $dbConfig['password'],
        $dbConfig['name'],
        $dbConfig['port'], // Use port from config
        NULL, // No socket - force TCP connection
        MYSQLI_CLIENT_SSL | MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT // Enable SSL without strict cert verification
    );
    
    if ($db->connect_error) {
        throw new Exception("MySQLi connection failed: " . $db->connect_error);
    }
    
    // Set charset
    $db->set_charset($dbConfig['charset']);
    
    // Make connections available globally
    $GLOBALS['db'] = $db;
    $GLOBALS['conn'] = $conn;
    
} catch (Exception $e) {
    $error_message = $e->getMessage();
    $error_code = mysqli_connect_errno();
    
    // Log detailed error information
    error_log("Database connection error (Code: $error_code): $error_message");
    error_log("Database config: host=" . $dbConfig['host'] . ", port=" . $dbConfig['port'] . ", database=" . $dbConfig['name']);
    
    // Check for specific error conditions
    if (strpos($error_message, 'No such file or directory') !== false) {
        error_log("This error often occurs when trying to connect via socket instead of TCP. Ensure the host is a valid hostname or IP address.");
        die("Database connection error: Unable to connect to database server. Please check server configuration.");
    } elseif (strpos($error_message, 'Unknown host') !== false || strpos($error_message, 'Name or service not known') !== false) {
        error_log("The hostname could not be resolved. Check DNS configuration or use an IP address instead.");
        die("Database connection error: Unable to resolve database hostname. Please check network configuration.");
    } elseif (strpos($error_message, 'Connection refused') !== false) {
        error_log("The connection was refused. Ensure the database server is running and accepting connections on the specified port.");
        die("Database connection error: Connection refused. Please check that the database server is running.");
    } else {
        die("Database connection error: " . $error_message);
    }
}
