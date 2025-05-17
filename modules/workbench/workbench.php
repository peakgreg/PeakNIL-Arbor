<?php
/**
 * Workbench Router
 * 
 * Routes requests to the appropriate workbench tool views
 */

// Include necessary files using defined paths
require_once CONFIG_PATH . '/init.php';
require_once __DIR__ . '/functions/workbench_functions.php';

// Check authentication
require_auth();

// Check for workbench access permission
if (!isset($_SESSION['workbench_access']) || $_SESSION['workbench_access'] !== 1) {
    // Redirect to dashboard if user doesn't have workbench access
    header('Location: /dashboard');
    exit;
}

// Get the requested action from the URL
$action = isset($_GET['action']) ? $_GET['action'] : 'overview';

// Log workbench access
// log_workbench_activity('access', 'workbench', ['action' => $action]);

// Route to the appropriate view based on the action
switch ($action) {
    case 'user-management':
        // User Management Tool
        require_once MODULES_PATH . '/workbench/views/user-management.php';
        break;

    case 'view-user':
        // System Settings Tool
        require_once __DIR__ . '/views/view-user.php';
        break;
        
    case 'school-management':
        // School Management Tool
        require_once __DIR__ . '/views/school-management.php';
        break;
        
    case 'content-management':
        // Content Management Tool
        require_once __DIR__ . '/views/content-management.php';
        break;
        
    case 'system-settings':
        // System Settings Tool
        require_once __DIR__ . '/views/system-settings.php';
        break;
        
    case 'reports':
        // Reports & Analytics Tool
        require_once __DIR__ . '/views/reports.php';
        break;
        
    case 'logs':
        // System Logs Tool
        require_once __DIR__ . '/views/logs.php';
        break;
        
    case 'overview':
    default:
        // Default to the workbench overview
        require_once __DIR__ . '/views/view.workbench.php';
        break;
}
