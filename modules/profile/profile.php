<?php
// Include necessary files using defined paths
require_once CONFIG_PATH . '/init.php';
require_once MODULES_PATH . '/profile/functions/profile_functions.php';

$api_key = getenv('PEAKNIL_KEY');

// Check if ID is provided
if (!isset($_GET['id'])) {
    header('Location: /404');
    exit;
}

$uuid = $_GET['id'];
$url = API_PATH . "/api/v1/profile?uuid=" . urlencode($uuid);

$ch = curl_init($url);

// Set headers and options
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'X-API-KEY: ' . $api_key, // Match case exactly from your terminal command
    ],
    CURLOPT_TIMEOUT => 15, // Increase timeout to 15 seconds
    CURLOPT_VERBOSE => true, // Enable verbose output for debugging
]);

$response = curl_exec($ch);
$profile = json_decode($response, true);

// Extract services
$services = $profile['data']['services'];
$profile = $profile['data'];

// Initialize min and max prices
$minPrice = PHP_INT_MAX; // Start with the highest possible integer
$maxPrice = PHP_INT_MIN; // Start with the lowest possible integer

// Loop through services to find min and max prices
foreach ($services as $service) {
    $price = $service['service_price'];
    if ($price < $minPrice) {
        $minPrice = $price;
    }
    if ($price > $maxPrice) {
        $maxPrice = $price;
    }
}

// Format the min and max prices for JavaScript
$formattedMinPrice = formatPrice($minPrice);
$formattedMaxPrice = formatPrice($maxPrice);

curl_close($ch);

// Split the tags into an array
$tagsArray = explode(' ', $profile['tags']);

// Load the profile view
require_once __DIR__ . '/views/view.profile3.php';