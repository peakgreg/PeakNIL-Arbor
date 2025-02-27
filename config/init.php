<?php
// Define root path using dirname to get parent directory of config
// define('ROOT_PATH', dirname(__DIR__));  // This goes up one level from config/

// Check if we're in the split directory structure (production)
if (file_exists('/var/www/public') && realpath(__DIR__) === '/var/www/config') {
    define('ROOT_PATH', '/var/www');  // Absolute path in production
    define('PUBLIC_PATH', '/var/www/public');
} else {
    define('ROOT_PATH', dirname(__DIR__));  // Relative path in development
    define('PUBLIC_PATH', ROOT_PATH . '/public');
}

// Define other paths relative to ROOT_PATH
define('CONFIG_PATH', ROOT_PATH . '/config');
define('MODULES_PATH', ROOT_PATH . '/modules');
define('AUTH_PATH', ROOT_PATH . '/auth');

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
