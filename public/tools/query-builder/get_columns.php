<?php
// --- get_columns.php ---

header('Content-Type: application/json'); // Tell the browser we're sending JSON

// --- Database Configuration ---
// Reuse the same secure method as your main file (e.g., include a config)
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'root';
$dbName = 'peaknil-planetscale';
$dbPort = 3306;
// --- Input Validation ---
if (!isset($_GET['table']) || empty(trim($_GET['table']))) { // Also trim whitespace
    echo json_encode(['error' => 'Table name not specified.']);
    http_response_code(400); // Bad Request
    exit;
}
$tableName = trim($_GET['table']);

// **Strict validation:** ensure table name ONLY contains safe characters.
// This is CRUCIAL if not using backticks in the query below.
if (!preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) {
     echo json_encode(['error' => 'Invalid table name format. Only letters, numbers, and underscores are allowed.']);
     http_response_code(400); // Bad Request
     exit;
}


// --- Establish Connection ---
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    // Adjust SSL settings if needed for PlanetScale
    $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
    mysqli_set_charset($conn, 'utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log("get_columns.php DB Connection Error: " . $e->getMessage()); // Log detailed error
    echo json_encode(['error' => 'Database Connection Error']); // Generic error to client
    http_response_code(500); // Internal Server Error
    exit;
}

// --- Fetch Columns ---
$columns = [];
try {
    // **Removed backticks around table name in SHOW COLUMNS**
    // The table name is validated above with preg_match.
    // mysqli_real_escape_string is less critical here due to validation, but harmless as extra layer.
    $sql = "SHOW COLUMNS FROM " . mysqli_real_escape_string($conn, $tableName);
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $columns[] = $row['Field'];
        }
        mysqli_free_result($result);
        echo json_encode(['columns' => $columns]); // Success! Output JSON
    } else {
         // This else might not be reached if mysqli_query throws exception on error reporting setting
         error_log("get_columns.php: Failed to execute SHOW COLUMNS for table: " . $tableName);
         echo json_encode(['error' => 'Failed to retrieve column information.']);
         http_response_code(500); // Internal Server Error
    }

} catch (mysqli_sql_exception $e) {
    // Catch potential errors like "table doesn't exist"
    error_log("get_columns.php: Error fetching columns for table " . $tableName . ": " . $e->getMessage());
    // Provide a more specific error if possible, e.g., check error code for non-existent table
    if ($e->getCode() == 1146) { // Error code for "Table doesn't exist"
         echo json_encode(['error' => 'Table \'' . htmlspecialchars($tableName) . '\' does not exist.']);
         http_response_code(404); // Not Found
    } else {
         echo json_encode(['error' => 'Error fetching columns.']);
         http_response_code(500); // Internal Server Error
    }
} finally {
    // Ensure connection is always closed
    if (isset($conn) && $conn instanceof mysqli) {
         mysqli_close($conn);
    }
}

exit; // Important to prevent any further output
?>