<?php
require_once __DIR__ . "/../../../../../config/init.php";

use API\Core\Request;
use API\Core\Response;
use API\Middleware\APIAuth;
use API\V1\Controllers\ProfileController;

try {
    // Validate database connection
    global $db;
    if (!isset($db) || !($db instanceof mysqli)) {
        throw new Exception("Database connection not properly initialized");
    }

    // Authenticate request
    $keyData = APIAuth::authenticate($db);

    // Process request
    $request = new Request();
    $controller = new ProfileController();

    switch ($request->getMethod()) {
        case "GET":
            $controller->getProfile($request);
            break;
        default:
            Response::error("Method not allowed", 405)->send();
            break;
    }
} catch (Exception $e) {
    error_log("API Error: " . $e->getMessage());
    Response::error($e->getMessage(), $e->getCode() ?: 500)->send();
}
