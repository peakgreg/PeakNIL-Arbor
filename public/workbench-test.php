<?php
// This is a test file to access the workbench module without authentication
// For development and testing purposes only

// Load initialization
require_once __DIR__ . '/../config/init.php';

// Set session variables to bypass authentication checks
$_SESSION['uuid'] = 'test-user';
$_SESSION['username'] = 'Test User';
$_SESSION['workbench_access'] = 1;
$_SESSION['experimental_access'] = 1;

// Set action parameter if not provided in the URL
if (!isset($_GET['action'])) {
    $_GET['action'] = 'overview';
}

// Include the workbench module
require_once MODULES_PATH . '/workbench/workbench.php';
