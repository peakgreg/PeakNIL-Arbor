<?php
// Include necessary files using defined paths
require_once CONFIG_PATH . '/init.php';
require_once MODULES_PATH . '/settings/functions/school_manager_functions.php';

// Check authentication
require_auth();

// Load the school manager overview view
require_once __DIR__ . '/views/view.school-manager.php';