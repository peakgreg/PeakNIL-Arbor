<?php
// Define root path using dirname to get parent directory of config
define('ROOT_PATH', dirname(__DIR__));  // This goes up one level from config/

// Define other paths relative to ROOT_PATH
define('CONFIG_PATH', ROOT_PATH . '/config');
define('MODULES_PATH', ROOT_PATH . '/modules');
define('AUTH_PATH', ROOT_PATH . '/auth');

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
