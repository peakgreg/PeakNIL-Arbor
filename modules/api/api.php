<?php
// Get the requested URL and remove any query strings
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = trim($request_uri, '/');

// Split the URL into parts
$request_parts = explode('/', $request);

// Check if this is an API request
if ($request_parts[0] === 'api') {
    error_log('API Request URI: ' . $request_uri);
    error_log('API Request Parts: ' . print_r($request_parts, true));

    // Get API version and endpoint
    $version = $request_parts[1] ?? null;
    $endpoint = $request_parts[2] ?? null;

    error_log('API Version: ' . $version);
    error_log('API Endpoint: ' . $endpoint);

    if ($version && $endpoint) {
        // Construct the file path
        $file_path = MODULES_PATH . "/api/" . strtoupper($version) . "/Endpoints/" . ucfirst($endpoint) . "/api." . $endpoint . ".php";
        error_log('API File Path: ' . $file_path);
        error_log('API File Exists: ' . (file_exists($file_path) ? 'Yes' : 'No'));

        if (file_exists($file_path)) {
            require_once $file_path;
        } else {
            error_log('API endpoint not found: ' . $file_path);
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'code' => 404,
                'message' => 'API endpoint not found',
                'data' => [],
                'meta' => [
                    'version' => '1.0',
                    'timestamp' => time()
                ]
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'code' => 400,
            'message' => 'Invalid API request format',
            'data' => [],
            'meta' => [
                'version' => '1.0',
                'timestamp' => time()
            ]
        ]);
    }
} else {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'code' => 404,
        'message' => 'Not found',
        'data' => [],
        'meta' => [
            'version' => '1.0',
            'timestamp' => time()
        ]
    ]);
}
