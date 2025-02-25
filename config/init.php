<?php
// Define root path based on environment
if (isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT'] === '/var/www/html') {
    // Production environment
    define('ROOT_PATH', '/var/www');
    error_log('Environment detected: PRODUCTION - ROOT_PATH set to: ' . '/var/www');
} else {
    // Development environment
    define('ROOT_PATH', dirname(__DIR__));  // This goes up one level from config/
    error_log('Environment detected: DEVELOPMENT - ROOT_PATH set to: ' . dirname(__DIR__));
}

// Define other paths relative to ROOT_PATH
define('CONFIG_PATH', ROOT_PATH . '/config');
define('MODULES_PATH', ROOT_PATH . '/modules');
define('AUTH_PATH', ROOT_PATH . '/auth');

// Log the resolved paths for debugging
error_log('Path resolution: CONFIG_PATH = ' . CONFIG_PATH);
error_log('Path resolution: MODULES_PATH = ' . MODULES_PATH);
error_log('Path resolution: AUTH_PATH = ' . AUTH_PATH);

// Load environment variables using Dotenv
require_once ROOT_PATH . '/vendor/autoload.php';

// Try to load .env file, but don't fail if it doesn't exist in production
try {
    $dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
    $dotenv->load();
} catch (Exception $e) {
    // In production, we might use environment variables set at the server level
    // so we don't want to fail if .env doesn't exist
    error_log("Warning: .env file could not be loaded: " . $e->getMessage());
    
    // Ensure critical environment variables exist
    if (!isset($_ENV['DB_HOST']) && !getenv('DB_HOST')) {
        die("Critical environment variables are missing. Please check your configuration.");
    }
}

// Core configuration and sessions first
require_once CONFIG_PATH . '/config.php';
require_once CONFIG_PATH . '/sessions.php';

// Database connection
require_once CONFIG_PATH . '/db.php';

// Common functions
require_once MODULES_PATH . '/common/functions/array_functions.php';
require_once MODULES_PATH . '/common/functions/email_functions.php';
require_once MODULES_PATH . '/common/functions/format_functions.php';
require_once MODULES_PATH . '/common/functions/notification_functions.php';
require_once MODULES_PATH . '/common/functions/security_functions.php';
require_once MODULES_PATH . '/common/functions/sms_functions.php';
require_once MODULES_PATH . '/common/functions/utility_functions.php';
require_once MODULES_PATH . '/common/functions/validation_functions.php';
require_once MODULES_PATH . '/common/helpers/string_helper.php';

// Auth
require_once AUTH_PATH . '/functions/login_functions.php';
require_once AUTH_PATH . '/middleware/auth_middleware.php';

// EOF
