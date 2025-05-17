<?php
require_once CONFIG_PATH . '/init.php';
require_once MODULES_PATH . '/favorites/functions/favorites_functions.php';

global $db;

if ($request->get('page') == 'login' || !isset(['user'])) {
    // Authentication logic here
    switch ($page) {
        case 'athletes|brands|collectives|opportunities':
            require_once MODULES_PATH . '/favorites/views/view..favorites.php';
            break;
        case 'favorites':
        default:
            require_once MODULES_PATH . '/favorites/views/view.favorites.php';
            break;
    }
}

