<?php
// Include necessary files using defined paths
require_once CONFIG_PATH . '/init.php';
require_once MODULES_PATH . '/settings/functions/settings_functions.php';

// Check authentication
require_auth();

// Load the messenger overview view
require_once __DIR__ . '/views/view.messenger.php';