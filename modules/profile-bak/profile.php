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
$responseData = json_decode($response, true);

// Initialize variables with default values
$profile = [];
$services = [];
$minPrice = 0;
$maxPrice = 0;
$formattedMinPrice = "0.00";
$formattedMaxPrice = "0.00";
$tagsArray = [];

// Check if the API response is valid and has the expected structure
if ($responseData && isset($responseData['data'])) {
    $profile = $responseData['data'];
    
    // Extract services if they exist
    if (isset($profile['services']) && is_array($profile['services'])) {
        $services = $profile['services'];
        
        // Initialize min and max prices
        $minPrice = PHP_INT_MAX; // Start with the highest possible integer
        $maxPrice = PHP_INT_MIN; // Start with the lowest possible integer
        
        // Loop through services to find min and max prices
        foreach ($services as $service) {
            if (isset($service['service_price'])) {
                $price = $service['service_price'];
                if ($price < $minPrice) {
                    $minPrice = $price;
                }
                if ($price > $maxPrice) {
                    $maxPrice = $price;
                }
            }
        }
        
        // Ensure we have valid min and max prices
        if ($minPrice === PHP_INT_MAX) $minPrice = 0;
        if ($maxPrice === PHP_INT_MIN) $maxPrice = 0;
        
        // Format the min and max prices for JavaScript
        $formattedMinPrice = formatPrice($minPrice);
        $formattedMaxPrice = formatPrice($maxPrice);
    }
    
    // Split the tags into an array if they exist
    if (isset($profile['tags']) && !empty($profile['tags'])) {
        $tagsArray = explode(' ', $profile['tags']);
    }
}

curl_close($ch);

// Load the profile view
require_once __DIR__ . '/views/view.profile2.php';
