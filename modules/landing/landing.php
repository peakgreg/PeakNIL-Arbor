<?php
require_once CONFIG_PATH . '/init.php';
require_once MODULES_PATH . '/landing/functions/landing_functions.php';

// Load the appropriate view
$page = $_GET['page'] ?? '';

switch($page) {

    case '':
    default:
        require_once MODULES_PATH . '/landing/views/view.home.php';
        break;

    case 'contact':
        require_once MODULES_PATH . '/landing/views/view.contact.php';
        break;

    case 'about':
        require_once MODULES_PATH . '/landing/views/view.about.php';
        break;

      case 'services':
        require_once MODULES_PATH . '/landing/views/view.services.php';
        break;
        
}

// Load view
require_once MODULES_PATH . '/landing/views/view.home.php';

// EOF