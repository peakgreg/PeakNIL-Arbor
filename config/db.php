<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$dbConfig = [
    'host' => $_ENV['DB_HOST'],
    'name' => $_ENV['DB_NAME'],
    'user' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8mb4'
];

// Initialize global mysqli connection
try {
    // Create connection and store in both $db and $conn
    $db = $conn = mysqli_init();
    $db->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
    $db->ssl_set(NULL, NULL, NULL, NULL, NULL);

    if (!$db->real_connect(
        $dbConfig['host'],
        $dbConfig['user'],
        $dbConfig['password'],
        $dbConfig['name'],
        3306,
        NULL,
        MYSQLI_CLIENT_SSL
    )) {
        throw new Exception("MySQLi connection failed: " . mysqli_connect_error());
    }

    // Set charset
    $db->set_charset($dbConfig['charset']);

    // Make connections available globally
    $GLOBALS['db'] = $db;
    $GLOBALS['conn'] = $conn;

} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    die("Database connection error: " . $e->getMessage());
}
