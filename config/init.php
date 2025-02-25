<?php
// Enhanced environment detection and path resolution
error_log('Starting path resolution...');
error_log('DOCUMENT_ROOT = ' . ($_SERVER['DOCUMENT_ROOT'] ?? 'not set'));
error_log('Script filename = ' . ($_SERVER['SCRIPT_FILENAME'] ?? 'not set'));

// Try to detect production environment
$is_production = false;
$production_root_path = '/var/www';

// Method 1: Check DOCUMENT_ROOT
if (isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT'] === '/var/www/html') {
    $is_production = true;
    error_log('Production detected via DOCUMENT_ROOT');
}
// Method 2: Check if we're in a typical EC2 path structure
elseif (isset($_SERVER['SCRIPT_FILENAME']) && strpos($_SERVER['SCRIPT_FILENAME'], '/var/www/html/') === 0) {
    $is_production = true;
    error_log('Production detected via SCRIPT_FILENAME');
}
// Method 3: Check for existence of typical production directories
elseif (file_exists('/var/www/html') && is_dir('/var/www/html')) {
    $is_production = true;
    error_log('Production detected via directory existence check');
}

// Set ROOT_PATH based on environment
if ($is_production) {
    // Try different possible root paths in production
    $possible_paths = [
        '/var/www',
        '/var/www/html/..',
        dirname($_SERVER['DOCUMENT_ROOT'] ?? ''),
        dirname(dirname($_SERVER['SCRIPT_FILENAME'] ?? ''))
    ];
    
    $root_path_found = false;
    
    foreach ($possible_paths as $path) {
        if (empty($path)) continue;
        
        // Check if this path contains the modules directory
        if (file_exists($path . '/modules') && is_dir($path . '/modules')) {
            define('ROOT_PATH', $path);
            $root_path_found = true;
            error_log('PRODUCTION - ROOT_PATH set to: ' . $path . ' (modules directory found)');
            break;
        }
    }
    
    // If no valid path found, use the default production path
    if (!$root_path_found) {
        define('ROOT_PATH', $production_root_path);
        error_log('PRODUCTION - ROOT_PATH set to default: ' . $production_root_path . ' (no modules directory found)');
    }
} else {
    // Development environment
    define('ROOT_PATH', dirname(__DIR__));  // This goes up one level from config/
    error_log('DEVELOPMENT - ROOT_PATH set to: ' . dirname(__DIR__));
}

// Define other paths relative to ROOT_PATH
define('CONFIG_PATH', ROOT_PATH . '/config');
define('MODULES_PATH', ROOT_PATH . '/modules');
define('AUTH_PATH', ROOT_PATH . '/auth');

// Log the resolved paths for debugging
error_log('Path resolution: ROOT_PATH = ' . ROOT_PATH);
error_log('Path resolution: CONFIG_PATH = ' . CONFIG_PATH);
error_log('Path resolution: MODULES_PATH = ' . MODULES_PATH);
error_log('Path resolution: AUTH_PATH = ' . AUTH_PATH);

// Verify critical paths exist
error_log('Verifying critical paths...');
if (!file_exists(MODULES_PATH)) {
    error_log('WARNING: MODULES_PATH does not exist: ' . MODULES_PATH);
} else {
    error_log('MODULES_PATH exists: ' . MODULES_PATH);
}

// Check for the specific header file that's causing issues
$header_file_path = MODULES_PATH . '/common/views/public/view.header.php';
if (!file_exists($header_file_path)) {
    error_log('WARNING: Header file does not exist: ' . $header_file_path);
} else {
    error_log('Header file exists: ' . $header_file_path);
}

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
