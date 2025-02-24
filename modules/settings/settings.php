<?php
// Include necessary files using defined paths
require_once CONFIG_PATH . '/init.php';
require_once MODULES_PATH . '/settings/functions/settings_functions.php';

// Check authentication
require_auth();

// Process form submissions if any
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch($action) {
        case 'update_general':
            // Handle general settings update
            $result = update_general_settings($_POST);
            break;
            
        case 'update_security':
            // Handle security settings update
            $result = update_security_settings($_POST);
            break;
            
        default:
            $result = ['error' => 'Invalid action'];
    }
}

// Get current settings
$settings = get_user_settings();

// Load the appropriate view
$page = $_GET['page'] ?? 'general';

switch($page) {
    case 'security':
        require_once MODULES_PATH . '/settings/views/view.security.php';
        break;
        
    case 'general':
    default:
        require_once MODULES_PATH . '/settings/views/view.general.php';
        break;
}

// EOF