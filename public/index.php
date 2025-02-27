<?php

error_log('Starting html/index.php');

// Load initialization
require_once __DIR__ . '/../config/init.php';

// Debug session state
error_log('Index.php - Session ID: ' . session_id());
error_log('Index.php - Session data: ' . print_r($_SESSION, true));

// Get the requested URL and remove any query strings
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = trim($request_uri, '/');

// Redirect logged-in users from root to login
if ($request === '' && isset($_SESSION['uuid'])) {
    header('Location: /login');
    exit;
}

error_log('Request URI: ' . $request_uri);

// Split the URL into parts
$request_parts = explode('/', $request);
$module = $request_parts[0] ?? '';
$action = $request_parts[1] ?? '';

// Main routing
switch ($module) {

    // Landing pages (public)
    case '':
        require_once MODULES_PATH . '/marketplace/marketplace.php';
        break;

    case 'marketplace':
        error_log('Accessing marketplace route');
        error_log('MODULES_PATH is: ' . MODULES_PATH);
        error_log('Full path being included: ' . MODULES_PATH . '/marketplace/marketplace.php');
        if (file_exists(MODULES_PATH . '/marketplace/marketplace.php')) {
            error_log('File exists');
        } else {
            error_log('File does not exist');
        }
        require_once MODULES_PATH . '/marketplace/marketplace.php';
        break;

    case 'landing':
        require_once MODULES_PATH . '/landing/landing.php';
        break;

    case 'about':
        require_once MODULES_PATH . '/landing/views/view.about.php';
        break;

    case 'contact':
        require_once MODULES_PATH . '/landing/views/view.contact.php';
        break;

    case 'profile':
        require_once MODULES_PATH . '/profile/profile.php';
        break;

    case 'services':
        require_once MODULES_PATH . '/landing/views/view.services.php';
        break;

    // API
    case 'api':
        require_once MODULES_PATH . '/api/api.php';
        break;


    // Auth routes
    case 'login':
        require_once AUTH_PATH . '/login.php';
        break;

    case 'register':
        require_once AUTH_PATH . '/register.php';
        break;

    case 'logout':
        require_once AUTH_PATH . '/logout.php';
        break;

    case 'reset-password':
        require_once AUTH_PATH . '/reset-password.php';
        break;

    case 'verify-email':
        error_log('Routing to verify-email');
        require_auth(true); // Skip verification check
        require_once AUTH_PATH . '/verify-email.php';
        break;

    case 'resend-verification':
        error_log('Routing to resend-verification');
        require_auth(true); // Skip verification check
        require_once AUTH_PATH . '/resend-verification.php';
        break;

    // Protected routes (require authentication)
    case 'dashboard':
        require_auth();
        require_once MODULES_PATH . '/dashboard/dashboard.php';
        break;

    case 'settings':
        require_auth();
        require_once MODULES_PATH . '/settings/settings.php';
        break;
    case 'wallet':
        require_auth();
        require_once MODULES_PATH . '/wallet/wallet.php';
        break;

    // Error handling
    default:
        http_response_code(404);
        require_once __DIR__ . '/errors/404.php';
        break;
}

// EOF
