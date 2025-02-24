<?php
/**
 * Load environment variables from .env file
 */
function load_env() {
    $env_file = dirname(__DIR__) . '/.env';
    if (file_exists($env_file)) {
        $lines = file($env_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '#') === 0) continue; // Skip comments
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            // Remove quotes if present
            if (strpos($value, '"') === 0 && strrpos($value, '"') === strlen($value) - 1) {
                $value = substr($value, 1, -1);
            }
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }
}

// Load environment variables
load_env();

/**
 * Application Configuration
 */

// Site Information
define('SITE_NAME', 'PeakNIL');
define('FULL_COMPANY_NAME', 'PeakNIL Technologies, Inc.');
define('COMPANY_ADDRESS', '6969 Glade Ave.');
define('COMPANY_CITY', 'Woodland Hills');
define('COMPANY_STATE', 'CA');
define('COMPANY_ZIP', '91367');
define('SITE_URL', 'https://www.peaknil.com');
define('SITE_EMAIL', 'contact@peaknil.com.com');

// Authentication
define('REQUIRE_EMAIL_VERIFICATION', true); // If true, users must verify email before using platform
define('LOGIN_REDIRECT_URL', '/marketplace'); // URL to redirect to after successful login

// URLS
define('ABOUT_URL', 'https://www.peaknil.com/about');
define('CONTACT_URL', 'https://www.peaknil.com/contact');
define('PRIVACY_URL', 'https://www.peaknil.com/privacy');
define('TERMS_URL', 'https://www.peaknil.com/terms');
define('FAQ_URL', 'https://www.peaknil.com/faq');
define('UNSUBSCRIBE_URL', 'https://www.peaknil.com/unsubscribe');

// Social Media Accounts
define('INSTAGRAM_URL', 'https://www.instagram.com/peak_nil');
define('TIKTOK_URL', 'https://www.tiktok.com/@peaknil');
define('X_URL', 'https://www.twitter.com/peaknil');
define('FACEBOOK_URL', 'https://www.facebook.com/peaknil');
define('YOUTUBE_URL', 'https://www.youtube.com/peaknil');

// Email Template Information
define('EMAIL_LOGO', 'https://cdn.peaknil.com/public/site/navbar-logo-blue-1.png');

// Security Settings
define('CSRF_TOKEN_LENGTH', 32);

// Login Security
define('MAX_LOGIN_ATTEMPTS', 3);        // Number of failed attempts before lockout
define('LOCKOUT_TIME', 900);            // Lockout duration in seconds (15 minutes)
define('ATTEMPT_WINDOW', 3600);         // Time window for counting attempts (1 hour)

// Session Settings
define('SESSION_LIFETIME', 1800);       // Session timeout in seconds (30 minutes)

/**
 * Environment Detection
 */
define('IS_DEVELOPMENT', in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1', 'localhost:8888']));
define('IS_PRODUCTION', !IS_DEVELOPMENT);

// Set error reporting based on environment
if (IS_DEVELOPMENT) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', false);
}

// API Settings
define('API_PATH', IS_DEVELOPMENT ? 'http://localhost:8888' : 'https://www.peaknil.com');
