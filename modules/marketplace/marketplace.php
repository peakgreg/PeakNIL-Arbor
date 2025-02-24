<?php
// Include necessary files using defined paths
require_once CONFIG_PATH . '/init.php';
require_once MODULES_PATH . '/marketplace/functions/marketplace_functions.php';
require_once MODULES_PATH . '/common/functions/utility_functions.php';

// Check authentication
// require_auth();

/******************************************************************************/

// Determine if user is on the Marketplace homepage - if so then display custom main page collection
if (isset($_GET['page']) && $_GET['page'] === 'marketplace' && count($_GET) === 1) {
    $collection = 'collection_main';
    $order = 'random';
} else {
    $collection = null;
    $order = 'newest';
}

/******************************************************************************/

$params = [
    'sport' => $_GET['sport'] ?? null,
    'school' => $_GET['school'] ?? null,
    'order' => $order ?? 'newest', // Can be 'newest' or 'random'
    'limit' => $_GET['limit'] ?? 50, // Default to 50 if not specified
    'collection' => $collection ?? null, // Name of collection table to filter by
    'type' => $_GET['type'] ?? null // Service type ID from pricing table
];
$users = getAthleteCards($conn, $params);

/******************************************************************************/

// Select all of the active sports for scrolling menu
$sql = "SELECT * FROM sports WHERE active = 1 
        ORDER BY 
        sort IS NULL, sort ASC, id ASC";
$result = mysqli_query($conn, $sql);

// Set size and color of icons
$icon_size = "28px";
$icon_color = "#0E0E0E";

// Load the marketplace view
require_once __DIR__ . '/views/view.marketplace.php';