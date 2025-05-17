<?php
declare(strict_types=1);
require_once CONFIG_PATH . '/init.php';
error_log('Loading wallet module');

// Authentication check
require_auth();

// Module initialization
$action = $_GET['action'] ?? 'balance';

// Wallet module routing
switch ($action) {
    case 'balance':
        require_once MODULES_PATH . '/wallet/views/view.balance.php';
        break;
        
    case 'history':
        require_once MODULES_PATH . '/wallet/views/view.history.php';
        break;

    case 'settings':
        require_once MODULES_PATH . '/wallet/views/view.settings.php';
        break;
        
    default:
        http_response_code(404);
        require_once PUBLIC_PATH . '/errors/404.php';
        break;
}