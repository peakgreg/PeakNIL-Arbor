<?php
// --- Database Configuration ---
// IMPORTANT: Store these securely, not directly in the code for production.
// Consider environment variables or a config file outside the web root.
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'root';
$dbName = 'peaknil-planetscale';
$dbPort = 3306; // Default MySQL port

// --- Establish Connection (Needed early for escaping and execution) ---
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = null; // Initialize
$db_connection_error = null;
try {
    // Ensure you have the correct connection parameters, including SSL if required by PlanetScale
    $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $dbPort);
    mysqli_set_charset($conn, 'utf8mb4');
} catch (mysqli_sql_exception $e) {
    error_log("Database Connection Error: " . $e->getMessage());
    $db_connection_error = "Error: Could not connect to the database. Please check configuration.";
}

// --- Fetch Tables (Only if DB connection succeeded) ---
$tables = []; // Initialize tables array
$table_fetch_error = null;
if ($conn) {
    try {
        $result = mysqli_query($conn, "SHOW TABLES");
        if ($result) {
            while ($row = mysqli_fetch_row($result)) { $tables[] = $row[0]; }
            mysqli_free_result($result);
        }
    } catch (mysqli_sql_exception $e) {
        error_log("Error fetching tables: " . $e->getMessage());
        $table_fetch_error = "Error: Could not fetch table list.";
    }
} else { $table_fetch_error = "Cannot fetch tables: No database connection."; }


// --- Determine which columns to potentially display ---
$columns_to_display = [];
$column_load_error = null;

// Function to fetch columns for a given table
function get_table_columns($db_conn, $table_name) {
    if (!$db_conn || empty($table_name)) return null;
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $table_name)) { error_log("Invalid table name format requested in get_table_columns: " . $table_name); return null; }
    $columns = [];
     try {
        $sql = "SHOW COLUMNS FROM `" . mysqli_real_escape_string($db_conn, $table_name) . "`";
        $result = mysqli_query($db_conn, $sql);
         if ($result) { while ($row = mysqli_fetch_assoc($result)) { $columns[] = $row['Field']; } mysqli_free_result($result); return $columns; }
     } catch (mysqli_sql_exception $e) { error_log("Error fetching columns for table '" . $table_name . "': " . $e->getMessage()); return null; }
     return $columns;
}

// 1. Columns requested via GET parameter
$selectedTableForColumnsGET = isset($_GET['show_columns']) ? $_GET['show_columns'] : null;
if ($selectedTableForColumnsGET && is_array($tables) && in_array($selectedTableForColumnsGET, $tables)) {
    $fetched_columns = get_table_columns($conn, $selectedTableForColumnsGET);
    if ($fetched_columns !== null) { $columns_to_display[$selectedTableForColumnsGET] = $fetched_columns; }
    else if ($conn) { $column_load_error = "Error fetching columns for " . htmlspecialchars($selectedTableForColumnsGET) . "."; }
}

// 2. After POST, ensure tables involved in selections are prepared for display
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['columns']) && is_array($_POST['columns'])) {
    foreach (array_keys($_POST['columns']) as $tableName) {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) continue;
        if (isset($tables) && in_array($tableName, $tables) && !isset($columns_to_display[$tableName])) {
            $fetched_columns = get_table_columns($conn, $tableName);
             if ($fetched_columns !== null) { $columns_to_display[$tableName] = $fetched_columns; }
        }
    }
}


// --- Handle Form Submission (Build Query / Build & Execute) ---
$generatedQuery = '';
$showModalOnLoad = false;
$execution_results = null;
$execution_error = null;
$execution_headers = [];

$action = 'build'; // Default action
if (isset($_POST['build_and_execute'])) { $action = 'execute'; }
elseif (isset($_POST['build_query'])) { $action = 'build'; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'build' || $action === 'execute')) {

    // Retrieve all form data
    $selectedColumns = isset($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : [];
    $involvedTables = array_keys($selectedColumns); // Tables with selected columns
    $joins = isset($_POST['joins']) && is_array($_POST['joins']) ? $_POST['joins'] : [];
    $where_conditions = isset($_POST['where']) && is_array($_POST['where']) ? $_POST['where'] : [];
    $orderby_criteria = isset($_POST['orderby']) && is_array($_POST['orderby']) ? $_POST['orderby'] : [];
    $limit_count = isset($_POST['limit_count']) ? trim($_POST['limit_count']) : null;
    $limit_offset = isset($_POST['limit_offset']) ? trim($_POST['limit_offset']) : null;

    // --- Start Query Building ---
    if (!empty($selectedColumns) && !empty($involvedTables)) {
        $selectParts = []; $validBaseTables = [];
        foreach ($selectedColumns as $tableName => $cols) { if (!preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) continue; $validBaseTables[] = $tableName; if (!is_array($cols)) continue; foreach ($cols as $colName) { if (!preg_match('/^[a-zA-Z0-9_]+$/', $colName)) continue; $selectParts[] = $tableName . "." . $colName; } }

        if(empty($selectParts)) { $generatedQuery = "-- Error: No valid columns selected."; }
        else {
            $baseQuery = "SELECT\n  " . implode(",\n  ", $selectParts);
            $fromTable = $validBaseTables[0] ?? null;

             if(!$fromTable) { $generatedQuery = "-- Error: No valid base table found."; }
             else {
                $baseQuery .= "\nFROM\n  " . $fromTable;
                $joinedTables = [$fromTable]; // Keep track of tables in FROM/JOIN
                $joinClause = '';
                // --- JOIN Logic ---
                foreach($joins as $join) {
                    if (empty(trim($join['left_table'] ?? '')) || empty(trim($join['left_col'] ?? '')) || empty(trim($join['right_table'] ?? '')) || empty(trim($join['right_col'] ?? ''))) { continue; }
                    if (isset($join['type'], $join['left_table'], $join['left_col'], $join['right_table'], $join['right_col']) && in_array(strtoupper($join['type']), ['INNER', 'LEFT', 'RIGHT']) && preg_match('/^[a-zA-Z0-9_]+$/', $join['left_table']) && preg_match('/^[a-zA-Z0-9_]+$/', $join['left_col']) && preg_match('/^[a-zA-Z0-9_]+$/', $join['right_table']) && preg_match('/^[a-zA-Z0-9_]+$/', $join['right_col']) ) {
                        $tableToJoin = null; $onClause = '';
                        $leftColClean = $join['left_col']; $rightColClean = $join['right_col'];
                        if (in_array($join['left_table'], $joinedTables) && !in_array($join['right_table'], $joinedTables)) { $tableToJoin = $join['right_table']; $onClause = "ON " . $join['left_table'] . "." . $leftColClean . " = " . $join['right_table'] . "." . $rightColClean; if (!in_array($tableToJoin, $joinedTables)) $joinedTables[] = $tableToJoin; }
                        elseif (in_array($join['right_table'], $joinedTables) && !in_array($join['left_table'], $joinedTables)) { $tableToJoin = $join['left_table']; $onClause = "ON " . $join['right_table'] . "." . $rightColClean . " = " . $join['left_table'] . "." . $leftColClean; if (!in_array($tableToJoin, $joinedTables)) $joinedTables[] = $tableToJoin; }
                        else if (in_array($join['left_table'], $joinedTables) && in_array($join['right_table'], $joinedTables)) { $tableToJoin = $join['right_table']; $onClause = "ON " . $join['left_table'] . "." . $leftColClean . " = " . $join['right_table'] . "." . $rightColClean; }
                        if ($tableToJoin && $onClause) { $joinString = "\n" . strtoupper($join['type']) . " JOIN " . $tableToJoin; if (!str_contains($joinClause, $joinString . "\n  " . $onClause)) { $joinClause .= $joinString . "\n  " . $onClause; } else { $generatedQuery .= "\n-- Skipped duplicate JOIN: " . htmlspecialchars($joinString); } }
                        elseif (!$tableToJoin) { $generatedQuery .= "\n-- Warning: Cannot determine join structure for " . htmlspecialchars($join['left_table']) . "/" . htmlspecialchars($join['right_table']); }
                        else { $generatedQuery .= "\n-- Warning: Cannot construct ON clause for " . htmlspecialchars($join['left_table']) . "/" . htmlspecialchars($join['right_table']); }
                    } else { $generatedQuery .= "\n-- Skipped invalid JOIN definition (check names/types)."; }
                }
                $baseQuery .= $joinClause;

                // --- WHERE Logic ---
                $whereClauseForDisplay = ''; $whereClauseForPrepare = '';
                $whereBindTypes = ''; $whereBindValues = [];
                $where_parts_display = []; $where_parts_prepare = [];

                foreach ($where_conditions as $index => $condition) {
                    $column = $condition['column'] ?? null; if (empty(trim($column))) { continue; }
                    $connector = ($index > 0 && isset($condition['connector']) && in_array(strtoupper($condition['connector']), ['AND', 'OR'])) ? strtoupper($condition['connector']) : 'AND';
                    $operator = strtoupper($condition['operator'] ?? '='); $value = $condition['value'] ?? null;
                    $allowed_operators = ['=', '!=', '>', '<', '>=', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'IS NULL', 'IS NOT NULL'];
                    $valid_column = null; if (preg_match('/^[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)?$/', trim($column))) { $valid_column = trim($column); } else { $generatedQuery .= "\n-- Skipped invalid WHERE column format: " . htmlspecialchars($column); continue; }
                    if (!in_array($operator, $allowed_operators)) { $generatedQuery .= "\n-- Skipped invalid WHERE operator: " . htmlspecialchars($operator); continue; }
                    $condition_string_display = ''; $condition_string_prepare = ''; $escaper = ($conn) ? $conn : null;
                    if ($operator === 'IS NULL' || $operator === 'IS NOT NULL') { $condition_string_display = $valid_column . " " . $operator; $condition_string_prepare = $valid_column . " " . $operator; }
                    elseif ($value !== null || $operator === 'IN' || $operator === 'NOT IN') {
                         $formatted_value_display = ''; $placeholders_prepare = '';
                         if ($operator === 'IN' || $operator === 'NOT IN') {
                             $items = explode(',', $value ?? ''); $escaped_items_display = []; $placeholders = [];
                             foreach($items as $item) { $trimmed_item = trim($item); if ($trimmed_item !== '') { $escaped_items_display[] = "'" . ($escaper ? mysqli_real_escape_string($escaper, $trimmed_item) : $trimmed_item) . "'"; $placeholders[] = '?'; $whereBindTypes .= 's'; $whereBindValues[] = $trimmed_item; } }
                             if (!empty($escaped_items_display)) { $formatted_value_display = "(" . implode(', ', $escaped_items_display) . ")"; $placeholders_prepare = "(" . implode(', ', $placeholders) . ")"; }
                             else { $generatedQuery .= "\n-- Skipped WHERE with empty IN/NOT IN list for: " . htmlspecialchars($valid_column); continue; }
                         } else {
                            if ($value === null) { $generatedQuery .= "\n-- Skipped WHERE, missing value for operator " . $operator . " on: " . htmlspecialchars($valid_column); continue; }
                            $formatted_value_display = "'" . ($escaper ? mysqli_real_escape_string($escaper, $value) : $value) . "'"; $placeholders_prepare = "?";
                            $whereBindTypes .= is_numeric($value) ? (strpos($value, '.') === false ? 'i' : 'd') : 's'; $whereBindValues[] = $value;
                         }
                         $condition_string_display = $valid_column . " " . $operator . " " . $formatted_value_display; $condition_string_prepare = $valid_column . " " . $operator . " " . $placeholders_prepare;
                    } else { $generatedQuery .= "\n-- Skipped WHERE, missing value for operator " . $operator . " on: " . htmlspecialchars($valid_column); continue; }
                    if (count($where_parts_display) > 0) { $where_parts_display[] = $connector; $where_parts_prepare[] = $connector; }
                    $where_parts_display[] = $condition_string_display; $where_parts_prepare[] = $condition_string_prepare;
                }
                if (!empty($where_parts_display)) {
                    $whereClauseStringDisplay = ''; $whereClauseStringPrepare = '';
                    for ($i = 0; $i < count($where_parts_display); $i++) { $isConnector = in_array(strtoupper($where_parts_display[$i]), ['AND', 'OR']); $isAfterConnector = ($i > 0 && in_array(strtoupper($where_parts_display[$i-1]), ['AND', 'OR'])); $indent = $isAfterConnector ? "\n  " : ''; $spaceBefore = ($i > 0 && !$isConnector) ? ' ' : ''; $whereClauseStringDisplay .= $spaceBefore . ($isConnector ? '' : $indent) . $where_parts_display[$i] . ($isConnector ? ' ' : ''); $whereClauseStringPrepare .= $spaceBefore . ($isConnector ? '' : $indent) . $where_parts_prepare[$i] . ($isConnector ? ' ' : ''); }
                     $whereClauseForDisplay = "\nWHERE " . ltrim($whereClauseStringDisplay); $whereClauseForPrepare = "\nWHERE " . ltrim($whereClauseStringPrepare);
                }

                // --- ORDER BY Logic ---
                $orderByClause = ''; $orderby_parts = [];
                 foreach ($orderby_criteria as $criterion) { $column = $criterion['column'] ?? null; $direction = strtoupper($criterion['direction'] ?? 'ASC'); if ($column !== null && trim($column) !== '' && preg_match('/^[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)?$/', trim($column))) { if (!in_array($direction, ['ASC', 'DESC'])) { $direction = 'ASC'; } $orderby_parts[] = trim($column) . " " . $direction; } else if ($column !== null && trim($column) !== '') { $generatedQuery .= "\n-- Skipped invalid ORDER BY column format: " . htmlspecialchars($column); } } if (!empty($orderby_parts)) { $orderByClause = "\nORDER BY " . implode(', ', $orderby_parts); }

                // --- LIMIT Logic ---
                $limitClause = '';
                 if ($limit_count !== null && $limit_count !== '' && ctype_digit($limit_count) && (int)$limit_count > 0) { $valid_limit_count = (int)$limit_count; if ($limit_offset !== null && $limit_offset !== '' && ctype_digit($limit_offset)) { $valid_limit_offset = (int)$limit_offset; $limitClause = "\nLIMIT " . $valid_limit_offset . ", " . $valid_limit_count; } else { $limitClause = "\nLIMIT " . $valid_limit_count; } }

                // --- Finalize Query String for Display ---
                $generatedQuery = $baseQuery . $whereClauseForDisplay . $orderByClause . $limitClause . ";";

                // --- EXECUTION LOGIC ---
                if ($action === 'execute') {
                    if (!$conn) { $execution_error = "Database connection failed. Cannot execute query."; }
                    else {
                        $queryToPrepare = $baseQuery . $whereClauseForPrepare . $orderByClause . $limitClause; // No semicolon
                        try {
                            $stmt = mysqli_prepare($conn, $queryToPrepare);
                            if ($stmt === false) { throw new mysqli_sql_exception("Prepare failed: " . mysqli_error($conn)); }
                            if (!empty($whereBindValues)) { $bindArgs = [$whereBindTypes]; for ($i = 0; $i < count($whereBindValues); $i++) { $bindArgs[] = &$whereBindValues[$i]; } call_user_func_array([$stmt, 'bind_param'], $bindArgs); }
                            if (!mysqli_stmt_execute($stmt)) { throw new mysqli_sql_exception("Execute failed: " . mysqli_stmt_error($stmt)); }
                            $result = mysqli_stmt_get_result($stmt);
                            if ($result === false) { throw new mysqli_sql_exception("Getting result set failed: " . mysqli_stmt_error($stmt)); }
                            $fields = mysqli_fetch_fields($result); foreach ($fields as $field) { $execution_headers[] = $field->name; }
                            $execution_results = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            mysqli_free_result($result); mysqli_stmt_close($stmt);
                        } catch (mysqli_sql_exception $e) { $execution_error = "SQL Execution Error: " . $e->getMessage() . "\nQuery attempted (with placeholders): " . htmlspecialchars($queryToPrepare); error_log($execution_error); if (isset($stmt) && $stmt instanceof mysqli_stmt) { mysqli_stmt_close($stmt); } }
                    }
                } // End execution logic

                // Set flag to show modal only for 'build' action
                if ($action === 'build') {
                    if (!empty(trim($generatedQuery)) && !str_starts_with(trim($generatedQuery), '-- Error')) { $showModalOnLoad = true; }
                    else if (!empty(trim($generatedQuery))) { $showModalOnLoad = true; }
                }
             } // End else (valid base table)
        } // End else (valid select parts)
    } else { // No columns selected
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'build' || $action === 'execute')) {
             $generatedQuery = "-- Please select columns first.";
             if ($action === 'build') $showModalOnLoad = true;
             if ($action === 'execute') $execution_error = $generatedQuery;
        }
    }
    // --- End of Query Building / Execution ---
}

// Close connection ONLY IF IT WAS OPENED SUCCESSFULLY
if (isset($conn) && $conn instanceof mysqli) {
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP MySQL Query Builder</title>
    <style>
        /* --- Base & Layout --- */
        * { box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; font-size: 14px; color: #343a40; }
        .container { padding: 20px; max-width: 1300px; margin: 0 auto; }
        .top-row, .middle-row { display: flex; flex-wrap: wrap; margin-bottom: 20px; gap: 20px; }
        .panel { border: 1px solid #dee2e6; padding: 20px; background-color: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border-radius: 6px; margin-bottom: 20px; }
        .top-row .panel, .middle-row .panel { margin-bottom: 0; }
        .tables { flex: 0 1 320px; min-width: 280px; }
        .columns { flex: 1 1 450px; min-width: 350px; }
        .joins, .where { width: 100%; }
        .order-by { flex: 2 1 400px; min-width: 320px; }
        .limit { flex: 1 1 260px; min-width: 240px; }
        .panel h2 { margin-top: 0; border-bottom: 1px solid #e9ecef; padding-bottom: 12px; font-size: 1.25em; color: #495057; font-weight: 600; }
        .panel p { font-size: 0.9em; color: #6c757d; margin-top: 5px; margin-bottom: 15px; }

        /* --- Tables & Columns --- */
        .tables ul { list-style: none; padding: 0; max-height: 450px; overflow-y: auto; }
        .tables li { margin-bottom: 0; padding: 6px 10px; border-bottom: 1px solid #f1f3f5; display: flex; justify-content: space-between; align-items: center; font-size: 0.95em; }
        .tables li:last-child { border-bottom: none; }
        .tables li span { word-break: break-all; padding-right: 10px; }
        .tables li button { font-size: 0.75em; padding: 3px 8px; margin-left: 10px; flex-shrink: 0; background-color: #e9ecef; color: #495057; border: 1px solid #ced4da; cursor: pointer; }
        .tables li button:hover { background-color: #dee2e6; }
        #dynamic-columns-area { max-height: 450px; overflow-y: auto; margin-top: 10px; padding-top: 5px; }
        .column-table-section { border: 1px solid #e9ecef; padding: 12px 15px; margin-top: 15px; background-color: #f8f9fa; border-radius: 4px; }
        .column-table-section h4 { margin: 0 0 12px 0; padding-bottom: 8px; border-bottom: 1px solid #dee2e6; font-size: 1em; font-weight: 600; display: flex; justify-content: space-between; align-items: center; }
        .column-header-buttons { display: flex; gap: 5px; } /* Container for buttons */
        .select-all-cols-btn, .unselect-all-cols-btn { font-size: 0.8em !important; padding: 2px 6px !important; background-color: #6c757d !important; color: white !important; border: none !important; }
        .select-all-cols-btn:hover, .unselect-all-cols-btn:hover { background-color: #5a6268 !important; }
        label { display: block; margin-bottom: 6px; font-size: 0.95em; cursor: pointer; line-height: 1.4; }
        label input[type="checkbox"] { margin-right: 8px; vertical-align: middle; width: 15px; height: 15px; }

        /* --- Definition Blocks (Join, Where, Order By) --- */
        .join-definition, .where-definition, .orderby-definition { border: 1px solid #e9ecef; padding: 12px; margin-bottom: 12px; background-color: #f8f9fa; font-size: 0.95em; border-radius: 4px; display: flex; flex-wrap: wrap; align-items: center; gap: 8px 12px; }
        /* Common select/input styles */
        .join-definition select, .join-definition input[type="text"],
        .where-definition select, .where-definition input[type="text"],
        .orderby-definition select, .orderby-definition input[type="text"] { padding: 6px 10px; border: 1px solid #ced4da; font-size: 0.95em; border-radius: 4px; background-color: #fff; line-height: 1.5; }
        /* Specific input sizing */
        .join-definition .join-table-select { flex: 1 1 150px; min-width: 120px; }
        .join-definition .join-col-select { flex: 1 1 150px; min-width: 120px; }
        .where-definition .where-connector { flex: 0 0 65px; }
        .where-definition .where-column-select { flex: 1 1 160px; }
        .where-definition .where-operator { flex: 0 0 110px; }
        .where-definition .where-value { flex: 1 1 160px; }
        .orderby-definition .orderby-column-select { flex: 1 1 180px; }
        .join-actions, .where-actions, .orderby-actions { margin-top: 15px; }

        /* --- Limit --- */
        .limit-controls { display: flex; flex-wrap: wrap; gap: 10px 20px; align-items: center; padding-top: 5px; }
        .limit-controls label { margin-right: 5px; font-weight: normal; font-size: 0.95em; margin-bottom: 0; }
        .limit-controls input[type="number"] { padding: 6px 10px; border: 1px solid #ced4da; border-radius: 4px; width: 100px; font-size: 0.95em; background-color: #fff; }

        /* --- Buttons & Common --- */
        .action-button { margin-right: 10px; margin-bottom: 5px; background-color: #6c757d; padding: 6px 12px; font-size: 0.9em; font-weight: normal; color: white; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.15s ease-in-out; }
        .action-button:hover { background-color: #5a6268; }
        #clearFormBtn { background-color: #fd7e14; border-color: #fd7e14;}
        #clearFormBtn:hover { background-color: #e67311; border-color: #e67311; }
        .build-button-container { text-align: center; padding: 15px 0 25px 0; display: flex; justify-content: center; gap: 15px; }
        button[type="submit"] { padding: 10px 20px; font-size: 1.05em; font-weight: 500; cursor: pointer; border: none; border-radius: 4px; transition: background-color 0.15s ease-in-out; color: white; }
        button#buildQueryBtn { background-color: #007bff; }
        button#buildQueryBtn:hover { background-color: #0069d9; }
        button#executeBtn { background-color: #28a745; }
        button#executeBtn:hover { background-color: #218838; }
        .remove-join-btn, .remove-where-btn, .remove-orderby-btn { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; margin-left: auto; font-size: 0.8em; padding: 3px 8px; order: 10; flex-shrink: 0; line-height: 1; cursor: pointer; }
        .remove-join-btn:hover, .remove-where-btn:hover, .remove-orderby-btn:hover { background-color: #f1b0b7;}
        .error-message { color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px 15px; border-radius: 4px; font-size: 0.9em; margin-top: 10px;}
        .info-message { color: #0c5460; background-color: #d1ecf1; border: 1px solid #bee5eb; padding: 10px 15px; border-radius: 4px; font-size: 0.9em; margin-top: 10px;}

        /* --- Results Area --- */
        #resultsPanel { margin-top: 20px; }
        #resultsContainer { max-height: 500px; overflow: auto; margin-top: 15px; border: 1px solid #dee2e6; border-radius: 4px; }
        #resultsTable { width: 100%; border-collapse: collapse; font-size: 0.9em; }
        #resultsTable th, #resultsTable td { padding: 8px 12px; border: 1px solid #dee2e6; text-align: left; vertical-align: top; white-space: nowrap; /* Prevent wrapping initially */ }
        #resultsTable td { white-space: normal; word-break: break-word; } /* Allow cell content to wrap */
        #resultsTable th { background-color: #e9ecef; font-weight: 600; position: sticky; top: 0; z-index: 1; }
        #resultsTable tr:nth-child(even) { background-color: #f8f9fa; }
        #resultsTable tr:hover { background-color: #e2e6ea; }
        #executionError { white-space: pre-wrap; font-family: monospace; }

        /* --- Modal Styles --- */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1000; display: none; backdrop-filter: blur(2px); }
        .modal { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; padding: 30px; border-radius: 6px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2); z-index: 1001; width: 90%; max-width: 800px; display: none; }
        .modal.visible, .modal-overlay.visible { display: block; }
        .modal-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e9ecef; padding-bottom: 15px; margin-bottom: 20px; }
        .modal-header h2 { margin: 0; font-size: 1.5em; font-weight: 600; color: #343a40; }
        .modal-close { background: none; border: none; font-size: 2em; line-height: 1; cursor: pointer; color: #adb5bd; padding: 0; }
        .modal-close:hover { color: #495057; }
        #modalQueryContent { background-color: #e9ecef; border: 1px solid #ced4da; padding: 15px; font-family: 'Courier New', Courier, monospace; white-space: pre-wrap; word-wrap: break-word; max-height: 65vh; overflow-y: auto; border-radius: 4px; font-size: 0.9em; color: #212529; }
    </style>
</head>
<body>

    <div class="container">
        <?php if($db_connection_error) echo '<p class="error-message">'.$db_connection_error.'</p>'; ?>

        <form method="POST" id="queryBuilderForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="top-row">
                <div class="panel tables">
                    <h2>Tables</h2>
                    <?php if(isset($table_fetch_error)) echo '<p class="error-message">'.$table_fetch_error.'</p>'; ?>
                    <ul>
                        <?php if (!empty($tables)) : ?>
                            <?php foreach ($tables as $table): ?>
                                <li>
                                    <span><?php echo htmlspecialchars($table); ?></span>
                                    <button type="button" class="action-button" onclick="fetchColumns('<?php echo htmlspecialchars(addslashes($table)); ?>')">Show Cols</button>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                             <li>No tables found or connection error.</li>
                        <?php endif; ?>
                    </ul>
                     <div id="table-load-error" class="error-message" style="<?php echo isset($column_load_error) ? '' : 'display: none;'; ?>">
                         <?php if(isset($column_load_error)) echo $column_load_error; ?>
                     </div>
                </div>

                <div class="panel columns">
                     <h2>Columns</h2>
                    <p>Click "Show Columns" on a table to select.</p>
                    <div id="dynamic-columns-area">
                        <?php
                        if (!empty($columns_to_display)):
                            foreach ($columns_to_display as $tableName => $tableColumns):
                                if (empty($tableColumns)) continue;
                        ?>
                            <div class="column-table-section" id="table-<?php echo htmlspecialchars($tableName); ?>">
                                <h4>
                                    <span><?php echo htmlspecialchars($tableName); ?></span>
                                    <div class="column-header-buttons">
                                        <button type="button" class="select-all-cols-btn action-button" onclick="selectAllColumns(this)">Select All</button>
                                        <button type="button" class="unselect-all-cols-btn action-button" onclick="unselectAllColumns(this)">Unselect All</button>
                                    </div>
                                </h4>
                                <?php foreach ($tableColumns as $column): ?>
                                    <label>
                                        <input type="checkbox"
                                               name="columns[<?php echo htmlspecialchars($tableName); ?>][]"
                                               value="<?php echo htmlspecialchars($column); ?>"
                                            <?php if (isset($_POST['columns'][$tableName]) && is_array($_POST['columns'][$tableName]) && in_array($column, $_POST['columns'][$tableName])) { echo ' checked'; } ?>>
                                        <?php echo htmlspecialchars($column); ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div><div class="panel joins">
                <h2>JOINs</h2>
                <p>Select tables and columns to join.</p>
                <div id="join-definitions-container">
                     <?php
                     $renderJoinsFromPost = ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['joins']) && is_array($_POST['joins']));
                     $joinsToRender = $renderJoinsFromPost ? $_POST['joins'] : [];
                     if (empty($joinsToRender)) { $joinsToRender[] = ['type'=>'INNER', 'left_table'=>'', 'left_col'=>'', 'right_table'=>'', 'right_col'=>'']; }
                     $joinCount = count($joinsToRender);

                     foreach ($joinsToRender as $index => $joinData) {
                         $type = isset($joinData['type']) ? htmlspecialchars($joinData['type']) : 'INNER';
                         $lt = isset($joinData['left_table']) ? htmlspecialchars($joinData['left_table']) : '';
                         $lc = isset($joinData['left_col']) ? htmlspecialchars($joinData['left_col']) : '';
                         $rt = isset($joinData['right_table']) ? htmlspecialchars($joinData['right_table']) : '';
                         $rc = isset($joinData['right_col']) ? htmlspecialchars($joinData['right_col']) : '';
                     ?>
                     <div class="join-definition" data-index="<?php echo $index; ?>">
                         <select name="joins[<?php echo $index; ?>][type]"> <option value="INNER" <?php if($type == 'INNER') echo 'selected'; ?>>INNER</option> <option value="LEFT" <?php if($type == 'LEFT') echo 'selected'; ?>>LEFT</option> <option value="RIGHT" <?php if($type == 'RIGHT') echo 'selected'; ?>>RIGHT</option> </select>
                         <span>T1:</span>
                         <select name="joins[<?php echo $index; ?>][left_table]" class="join-table-select" data-col-target="left_col_<?php echo $index; ?>">
                             <option value="">-- Select Table --</option>
                             <?php foreach($tables as $tbl): ?>
                                <option value="<?php echo htmlspecialchars($tbl); ?>" <?php if($lt == $tbl) echo 'selected'; ?>><?php echo htmlspecialchars($tbl); ?></option>
                             <?php endforeach; ?>
                         </select>
                         <span>C1:</span>
                         <select name="joins[<?php echo $index; ?>][left_col]" class="join-col-select" id="left_col_<?php echo $index; ?>">
                            <option value="">-- Select Table First --</option>
                            <?php // JS will populate and select $lc if needed ?>
                         </select>
                         <span>=</span>
                         <span>T2:</span>
                          <select name="joins[<?php echo $index; ?>][right_table]" class="join-table-select" data-col-target="right_col_<?php echo $index; ?>">
                             <option value="">-- Select Table --</option>
                             <?php foreach($tables as $tbl): ?>
                                <option value="<?php echo htmlspecialchars($tbl); ?>" <?php if($rt == $tbl) echo 'selected'; ?>><?php echo htmlspecialchars($tbl); ?></option>
                             <?php endforeach; ?>
                         </select>
                         <span>C2:</span>
                         <select name="joins[<?php echo $index; ?>][right_col]" class="join-col-select" id="right_col_<?php echo $index; ?>">
                            <option value="">-- Select Table First --</option>
                             <?php // JS will populate and select $rc if needed ?>
                         </select>
                         <button type="button" class="remove-join-btn" style="display: <?php echo $joinCount > 1 ? 'inline-block' : 'none'; ?>;">X</button>
                     </div>
                     <?php } ?>
                </div>
                <div class="join-actions"> <button type="button" id="add-join-btn" class="action-button">Add JOIN</button> </div>
            </div> <div class="panel where">
                 <h2>Filter Data (WHERE)</h2>
                <p>Define conditions to filter rows.</p>
                <div id="where-definitions-container">
                    <?php
                     $renderWhereFromPost = ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['where']) && is_array($_POST['where']));
                     $whereToRender = $renderWhereFromPost ? $_POST['where'] : [];
                     if (empty($whereToRender)) { $whereToRender[] = ['connector'=>'AND', 'column'=>'', 'operator'=>'=', 'value'=>'']; }
                     $whereCount = count($whereToRender);
                     foreach ($whereToRender as $index => $whereData) {
                         $whConnector = isset($whereData['connector']) ? strtoupper(htmlspecialchars($whereData['connector'])) : 'AND'; $whColumn = isset($whereData['column']) ? htmlspecialchars($whereData['column']) : ''; $whOperator = isset($whereData['operator']) ? htmlspecialchars($whereData['operator']) : '='; $whValue = isset($whereData['value']) ? htmlspecialchars($whereData['value']) : '';
                     ?>
                     <div class="where-definition" data-index="<?php echo $index; ?>">
                         <select name="where[<?php echo $index; ?>][connector]" class="where-connector" style="visibility: <?php echo $index === 0 ? 'hidden' : 'visible'; ?>;"> <option value="AND" <?php if($whConnector == 'AND') echo 'selected'; ?>>AND</option> <option value="OR" <?php if($whConnector == 'OR') echo 'selected'; ?>>OR</option> </select>
                         <select name="where[<?php echo $index; ?>][column]" class="where-column-select">
                             <option value="">-- Select Column --</option>
                             <?php // Options populated by JS, JS needs to select $whColumn ?>
                         </select>
                         <select name="where[<?php echo $index; ?>][operator]" class="where-operator"> <option value="=" <?php if($whOperator == '=') echo 'selected'; ?>>=</option> <option value="!=" <?php if($whOperator == '!=') echo 'selected'; ?>>!=</option> <option value=">" <?php if($whOperator == '>') echo 'selected'; ?>>&gt;</option> <option value="<" <?php if($whOperator == '<') echo 'selected'; ?>>&lt;</option> <option value=">=" <?php if($whOperator == '>=') echo 'selected'; ?>>&gt;=</option> <option value="<=" <?php if($whOperator == '<=') echo 'selected'; ?>>&lt;=</option> <option value="LIKE" <?php if($whOperator == 'LIKE') echo 'selected'; ?>>LIKE</option> <option value="NOT LIKE" <?php if($whOperator == 'NOT LIKE') echo 'selected'; ?>>NOT LIKE</option> <option value="IN" <?php if($whOperator == 'IN') echo 'selected'; ?>>IN (...)</option> <option value="NOT IN" <?php if($whOperator == 'NOT IN') echo 'selected'; ?>>NOT IN (...)</option> <option value="IS NULL" <?php if($whOperator == 'IS NULL') echo 'selected'; ?>>IS NULL</option> <option value="IS NOT NULL" <?php if($whOperator == 'IS NOT NULL') echo 'selected'; ?>>IS NOT NULL</option> </select>
                         <input type="text" name="where[<?php echo $index; ?>][value]" placeholder="Value(s)" value="<?php echo $whValue; ?>" class="where-value" style="display: <?php echo (strtoupper($whOperator) == 'IS NULL' || strtoupper($whOperator) == 'IS NOT NULL') ? 'none' : 'inline-block'; ?>;">
                         <button type="button" class="remove-where-btn" style="display: <?php echo $whereCount > 1 ? 'inline-block' : 'none'; ?>;">X</button>
                     </div>
                     <?php } ?>
                </div>
                <div class="where-actions"> <button type="button" id="add-where-btn" class="action-button">Add Condition</button> </div>
            </div> <div class="middle-row">
                <div class="panel order-by">
                    <h2>Sort By (ORDER BY)</h2>
                     <div id="orderby-definitions-container">
                        <?php
                         $renderOrderByFromPost = ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderby']) && is_array($_POST['orderby']));
                         $orderByToRender = $renderOrderByFromPost ? $_POST['orderby'] : [];
                         if (empty($orderByToRender)) { $orderByToRender[] = ['column'=>'', 'direction'=>'ASC']; }
                         $orderByCount = count($orderByToRender);
                         foreach ($orderByToRender as $index => $orderByData) { $obCol = isset($orderByData['column']) ? htmlspecialchars($orderByData['column']) : ''; $obDir = isset($orderByData['direction']) ? strtoupper(htmlspecialchars($orderByData['direction'])) : 'ASC'; ?>
                         <div class="orderby-definition" data-index="<?php echo $index; ?>">
                             <label>Column:</label>
                             <select name="orderby[<?php echo $index; ?>][column]" class="orderby-column-select">
                                 <option value="">-- Select Column --</option>
                                 <?php // Options populated by JS, JS needs to select $obCol ?>
                             </select>
                             <label>Direction:</label>
                             <select name="orderby[<?php echo $index; ?>][direction]"> <option value="ASC" <?php if($obDir == 'ASC') echo 'selected'; ?>>ASC</option> <option value="DESC" <?php if($obDir == 'DESC') echo 'selected'; ?>>DESC</option> </select>
                             <button type="button" class="remove-orderby-btn" style="display: <?php echo $orderByCount > 1 ? 'inline-block' : 'none'; ?>;">X</button>
                         </div>
                        <?php } ?>
                     </div>
                     <div class="orderby-actions"> <button type="button" id="add-orderby-btn" class="action-button">Add Sort Criterion</button> </div>
                </div> <div class="panel limit">
                     <h2>Limit Results</h2>
                    <div class="limit-controls"> <label for="limit_count">Rows:</label> <input type="number" id="limit_count" name="limit_count" min="1" step="1" placeholder="e.g., 10" value="<?php echo isset($_POST['limit_count']) ? htmlspecialchars($_POST['limit_count']) : ''; ?>"> <label for="limit_offset">Offset:</label> <input type="number" id="limit_offset" name="limit_offset" min="0" step="1" placeholder="e.g., 0" value="<?php echo isset($_POST['limit_offset']) ? htmlspecialchars($_POST['limit_offset']) : ''; ?>"> </div>
                </div> </div> <div class="build-button-container">
                <button type="submit" name="build_query" id="buildQueryBtn">Build Query</button>
                <button type="submit" name="build_and_execute" id="executeBtn">Build & Execute</button>
                <button type="button" id="clearFormBtn" class="action-button">Clear All</button> </div>

        </form>

        <?php if ($action === 'execute'): ?>
            <div class="panel" id="resultsPanel">
                <h2>Query Results</h2>
                <?php if ($execution_error): ?>
                    <div class="error-message"> <strong>Error Executing Query:</strong><br> <pre id="executionError"><?php echo htmlspecialchars($execution_error); ?></pre> </div>
                <?php elseif ($execution_results !== null): ?>
                    <?php if (empty($execution_results)): ?>
                        <p class="info-message">Query executed successfully, but returned no rows.</p>
                    <?php else: ?>
                        <div id="resultsContainer">
                            <table id="resultsTable">
                                <thead> <tr> <?php foreach ($execution_headers as $header): ?> <th><?php echo htmlspecialchars($header); ?></th> <?php endforeach; ?> </tr> </thead>
                                <tbody> <?php foreach ($execution_results as $row): ?> <tr> <?php foreach ($execution_headers as $header): ?> <td><?php echo htmlspecialchars($row[$header] ?? ''); ?></td> <?php endforeach; ?> </tr> <?php endforeach; ?> </tbody>
                            </table>
                        </div>
                        <p style="font-size: 0.9em; color: #6c757d; margin-top: 10px;">Returned <?php echo count($execution_results); ?> row(s).</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        </div> <div id="modalOverlay" class="modal-overlay <?php if ($showModalOnLoad) echo 'visible'; ?>"></div>
    <div id="queryModal" class="modal <?php if ($showModalOnLoad) echo 'visible'; ?>">
        <div class="modal-header">
            <h2>Generated SQL Query</h2>
            <button type="button" class="modal-close" aria-label="Close">&times;</button>
        </div>
        <div class="modal-body">
            <pre id="modalQueryContent"><?php echo htmlspecialchars($generatedQuery); ?></pre>
            <button type="button" id="copySqlBtn" class="action-button" style="margin-top: 15px; background-color: #17a2b8;">Copy SQL</button>
        </div>
    </div>

    <script>
        const availableTables = <?php echo json_encode($tables); ?>;
        // Store previously selected columns if repopulating from POST
        const initialJoinColumns = <?php
            $initialCols = [];
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['joins']) && is_array($_POST['joins'])) {
                foreach($_POST['joins'] as $index => $joinData) { $initialCols[$index] = ['left_col' => $joinData['left_col'] ?? null, 'right_col' => $joinData['right_col'] ?? null]; }
            } echo json_encode($initialCols);
         ?>;
         const initialWhereColumns = <?php
            $initialCols = [];
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['where']) && is_array($_POST['where'])) {
                foreach($_POST['where'] as $index => $whereData) { $initialCols[$index] = $whereData['column'] ?? null; }
            } echo json_encode($initialCols);
         ?>;
         const initialOrderByColumns = <?php
            $initialCols = [];
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderby']) && is_array($_POST['orderby'])) {
                foreach($_POST['orderby'] as $index => $orderByData) { $initialCols[$index] = $orderByData['column'] ?? null; }
            } echo json_encode($initialCols);
         ?>;
    </script>

    <script>
    // --- JavaScript ---
    // --- Get Element References ---
    const columnsArea = document.getElementById('dynamic-columns-area');
    const tableLoadError = document.getElementById('table-load-error');
    const joinsContainer = document.getElementById('join-definitions-container');
    const whereContainer = document.getElementById('where-definitions-container');
    const orderbyContainer = document.getElementById('orderby-definitions-container');
    const modal = document.getElementById('queryModal');
    const modalOverlay = document.getElementById('modalOverlay');
    const modalQueryContent = document.getElementById('modalQueryContent');
    const closeButton = modal?.querySelector('.modal-close');
    const addJoinBtn = document.getElementById('add-join-btn');
    const addWhereBtn = document.getElementById('add-where-btn');
    const addOrderByBtn = document.getElementById('add-orderby-btn');
    const clearFormBtn = document.getElementById('clearFormBtn');
    const limitCountInput = document.getElementById('limit_count');
    const limitOffsetInput = document.getElementById('limit_offset');
    const resultsPanel = document.getElementById('resultsPanel');
    const copySqlBtn = document.getElementById('copySqlBtn');

    // --- Define ALL Functions FIRST ---

    function escapeHtml(unsafe) { if (typeof unsafe !== 'string') return ''; return unsafe.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;"); }

    async function fetchColumns(tableName) {
        if (!tableLoadError || !columnsArea) return;
        tableLoadError.textContent = ''; tableLoadError.style.display = 'none';
        console.log(`Fetching columns for: ${tableName}`);
        const safeTableName = escapeHtml(tableName);
        const existingContainerId = `table-${safeTableName}`;
        if (document.getElementById(existingContainerId)) { console.log(`Columns for ${tableName} already loaded.`); return; }
        try {
            const response = await fetch(`get_columns.php?table=${encodeURIComponent(tableName)}`);
            if (!response.ok) { let e = `HTTP error! ${response.status}`; try { let d=await response.json(); if(d.error) e+=` - ${d.error}`; } catch(x){} throw new Error(e); }
            const data = await response.json();
            if (data.error) { throw new Error(data.error); }
            if (data.columns && Array.isArray(data.columns)) {
                displayColumns(tableName, data.columns);
                updateAllClauseColumnDropdowns(); // Update dropdowns after new columns are displayed
            } else { console.warn("Received non-array 'columns'", tableName, data); displayColumns(tableName, []); }
        } catch (error) {
            console.error("Fetch columns error:", error);
            tableLoadError.textContent = `Error for ${safeTableName}: ${error.message}`;
            tableLoadError.style.display = 'block';
        }
    }

    // Modified to add Select All / Unselect All buttons
    function displayColumns(tableName, columns) {
        if (!columnsArea) return;
        const safeTableName = escapeHtml(tableName);
        const containerId = `table-${safeTableName}`;
        if (document.getElementById(containerId)) { return; }
        const container = document.createElement('div'); container.id = containerId; container.className = 'column-table-section';
        const title = document.createElement('h4');
        const titleText = document.createElement('span'); titleText.textContent = safeTableName; title.appendChild(titleText);

        // Container for buttons
        const buttonContainer = document.createElement('div');
        buttonContainer.className = 'column-header-buttons';

        // Create and append Select All button
        const selectAllBtn = document.createElement('button');
        selectAllBtn.type = 'button'; selectAllBtn.className = 'select-all-cols-btn action-button';
        selectAllBtn.textContent = 'Select All'; selectAllBtn.onclick = function() { selectAllColumns(this); };
        buttonContainer.appendChild(selectAllBtn);

        // Create and append Unselect All button
        const unselectAllBtn = document.createElement('button');
        unselectAllBtn.type = 'button'; unselectAllBtn.className = 'unselect-all-cols-btn action-button';
        unselectAllBtn.textContent = 'Unselect All'; unselectAllBtn.onclick = function() { unselectAllColumns(this); }; // Attach new handler
        buttonContainer.appendChild(unselectAllBtn);

        title.appendChild(buttonContainer); // Add button container to title
        container.appendChild(title);

        if (columns.length === 0) { const p = document.createElement('p'); p.style.fontSize = '0.9em'; p.style.color = '#666'; p.textContent = '(No columns found)'; container.appendChild(p); }
        else { columns.forEach(column => { const safeColumnName = escapeHtml(column); const label = document.createElement('label'); const checkbox = document.createElement('input'); checkbox.type = 'checkbox'; checkbox.name = `columns[${tableName}][]`; checkbox.value = safeColumnName; label.appendChild(checkbox); label.appendChild(document.createTextNode(` ${safeColumnName}`)); container.appendChild(label); }); }
        columnsArea.appendChild(container);
    }

    // Select All function
    function selectAllColumns(button) { const section = button.closest('.column-table-section'); if (section) { const checkboxes = section.querySelectorAll('input[type="checkbox"]'); checkboxes.forEach(cb => { cb.checked = true; }); } }

    // Unselect All function
    function unselectAllColumns(button) { const section = button.closest('.column-table-section'); if (section) { const checkboxes = section.querySelectorAll('input[type="checkbox"]'); checkboxes.forEach(cb => { cb.checked = false; }); } }


    // --- Clause Column Dropdown Logic ---
    function getActiveColumns() {
        const activeCols = new Set(); // Use a Set to avoid duplicates easily
        columnsArea?.querySelectorAll('.column-table-section').forEach(section => {
            const tableId = section.id;
            const tableNameMatch = tableId.match(/^table-(.+)/);
            if (tableNameMatch && tableNameMatch[1]) {
                const tableName = tableNameMatch[1];
                 section.querySelectorAll('label input[type="checkbox"]').forEach(checkbox => {
                     const colName = checkbox?.value;
                     if(colName) {
                         // Add table.column format
                         activeCols.add(`${tableName}.${colName}`);
                     }
                 });
            }
        });
        // Also include columns from tables used in JOINs, even if not explicitly shown/selected
        joinsContainer?.querySelectorAll('.join-table-select').forEach(select => {
            const tableName = select.value;
            if (tableName) {
                // Find corresponding column section if it exists
                const columnSection = columnsArea?.querySelector(`#table-${tableName}`);
                if(columnSection) {
                    columnSection.querySelectorAll('label input[type="checkbox"]').forEach(checkbox => {
                         const colName = checkbox?.value;
                         if(colName) activeCols.add(`${tableName}.${colName}`);
                    });
                }
                // If section doesn't exist, we could potentially fetch columns here,
                // but for now, rely on "Show Columns" being clicked first.
            }
        });

        console.log("Active columns for dropdowns:", Array.from(activeCols));
        return Array.from(activeCols).sort(); // Return sorted array
    }

    function populateClauseColumnDropdown(selectElement, selectedValue = null) {
        if (!selectElement) return;
        const currentVal = selectedValue || selectElement.value; // Preserve current value
        selectElement.innerHTML = '<option value="">-- Select Column --</option>';
        const activeColumns = getActiveColumns();
        if (activeColumns.length === 0) {
            selectElement.innerHTML = '<option value="">-- Show Columns First --</option>';
            return;
        }
        activeColumns.forEach(col => {
            const option = document.createElement('option');
            option.value = col;
            option.textContent = col;
            if (currentVal === col) { option.selected = true; }
            selectElement.appendChild(option);
        });
    }

    function updateAllClauseColumnDropdowns() {
        console.log("Updating all WHERE/ORDER BY column dropdowns...");
        const activeColumns = getActiveColumns(); // Get the list once

        whereContainer?.querySelectorAll('.where-column-select').forEach(select => {
            const currentVal = select.value; // Preserve selection
            select.innerHTML = '<option value="">-- Select Column --</option>';
            if (activeColumns.length === 0) { select.innerHTML = '<option value="">-- Show Columns First --</option>'; return; }
            activeColumns.forEach(col => {
                const option = document.createElement('option');
                option.value = col; option.textContent = col;
                if (currentVal === col) { option.selected = true; }
                select.appendChild(option);
            });
        });

        orderbyContainer?.querySelectorAll('.orderby-column-select').forEach(select => {
             const currentVal = select.value; // Preserve selection
             select.innerHTML = '<option value="">-- Select Column --</option>';
             if (activeColumns.length === 0) { select.innerHTML = '<option value="">-- Show Columns First --</option>'; return; }
             activeColumns.forEach(col => {
                const option = document.createElement('option');
                option.value = col; option.textContent = col;
                if (currentVal === col) { option.selected = true; }
                select.appendChild(option);
            });
        });
    }
    // --- End Clause Column Dropdown Logic ---


    function findMaxIndex(container, namePrefix) { let m = -1; if(!container) return m; container.querySelectorAll(`[name^="${namePrefix}["]`)?.forEach(el => { const x = el.name.match(/\[(\d+)\]/); if (x && parseInt(x[1]) > m) { m = parseInt(x[1]); } }); return m; }

    function createDefaultBlock(type, index) {
        switch(type) {
            case 'join': return createDefaultJoinBlock(index);
            case 'where': return createDefaultWhereBlock(index);
            case 'orderby': return createDefaultOrderByBlock(index);
            default: console.error("Unknown block type for createDefaultBlock:", type); return null;
        }
    }

    function addDefinitionBlock(container, namePrefix, createDefaultBlockFn) {
        if (!container) { console.error(`Cannot add definition, container for ${namePrefix} not found.`); return; }
        const newIndex = findMaxIndex(container, namePrefix) + 1;
        const newBlock = createDefaultBlockFn(newIndex);
        if (!newBlock) { console.error(`Cannot create default ${namePrefix} block.`); return; }
        container.appendChild(newBlock);
        // Populate column dropdowns for new WHERE/ORDER BY blocks immediately
        if (namePrefix === 'where') { populateClauseColumnDropdown(newBlock.querySelector('.where-column-select')); }
        if (namePrefix === 'orderby') { populateClauseColumnDropdown(newBlock.querySelector('.orderby-column-select')); }
        updateDefinitionBlockUI(container, namePrefix);
    }

    function removeDefinitionBlock(button, namePrefix, containerIdOrNode, createDefaultBlockFn) {
        const targetContainer = (typeof containerIdOrNode === 'string') ? document.getElementById(containerIdOrNode) : containerIdOrNode;
        if (!targetContainer) { console.error(`Cannot remove definition, container for ${namePrefix} not found.`); return; }
        const blockToRemove = button.closest(`.${namePrefix}-definition`);
        if (blockToRemove) {
            blockToRemove.remove();
            const remainingBlocks = targetContainer.querySelectorAll(`.${namePrefix}-definition`);
            if (remainingBlocks.length === 0) { targetContainer.appendChild(createDefaultBlockFn(0)); }
            updateDefinitionBlockUI(targetContainer, namePrefix);
        } else { console.warn("Could not find parent block to remove for", namePrefix); }
    }

    function updateDefinitionBlockUI(container, namePrefix) {
        if (!container) return;
        const allBlocks = container.querySelectorAll(`.${namePrefix}-definition`);
        allBlocks.forEach((block, index) => {
            // Update data-index attribute
            block.setAttribute('data-index', index);
            // Update name attributes for all inputs/selects within the block
            block.querySelectorAll('[name]').forEach(el => {
                 if (el.name) {
                     el.name = el.name.replace(/\[\d+\]/, `[${index}]`);
                 }
            });
             // Update IDs and data-col-target for JOIN column selects
             if (namePrefix === 'join') {
                 const leftColSelect = block.querySelector('.join-col-select[id^="left_col_"]');
                 const rightColSelect = block.querySelector('.join-col-select[id^="right_col_"]');
                 const leftTableSelect = block.querySelector('.join-table-select[data-col-target^="left_col_"]');
                 const rightTableSelect = block.querySelector('.join-table-select[data-col-target^="right_col_"]');
                 if(leftColSelect) leftColSelect.id = `left_col_${index}`;
                 if(rightColSelect) rightColSelect.id = `right_col_${index}`;
                 if(leftTableSelect) leftTableSelect.dataset.colTarget = `left_col_${index}`;
                 if(rightTableSelect) rightTableSelect.dataset.colTarget = `right_col_${index}`;
             }

            // Update remove button visibility and onclick
            const removeBtn = block.querySelector(`.remove-${namePrefix}-btn`);
            if (removeBtn) {
                removeBtn.style.display = (allBlocks.length > 1) ? 'inline-block' : 'none';
                // Re-attach onclick to ensure correct index/container reference after potential re-indexing
                 removeBtn.onclick = function() { removeDefinitionBlock(this, namePrefix, container.id, createDefaultBlock); };
            }

            // Special UI rules
            if (namePrefix === 'where') {
                const connector = block.querySelector('.where-connector');
                if (connector) { connector.style.visibility = (index === 0) ? 'hidden' : 'visible'; }
                const operatorSelect = block.querySelector('.where-operator');
                if(operatorSelect) { toggleWhereValueInput(operatorSelect); }
            }
             if (namePrefix === 'join') {
                 const leftColSelect = block.querySelector('.join-col-select[name*="[left_col]"]');
                 const rightColSelect = block.querySelector('.join-col-select[name*="[right_col]"]');
                 const leftTableSelect = block.querySelector('.join-table-select[name*="[left_table]"]');
                 const rightTableSelect = block.querySelector('.join-table-select[name*="[right_table]"]');
                 if(leftColSelect) leftColSelect.disabled = !leftTableSelect || !leftTableSelect.value;
                 if(rightColSelect) rightColSelect.disabled = !rightTableSelect || !rightTableSelect.value;
             }
        });
    }

    // --- Specific Create Default Block Functions ---
    // Updated to use correct removeDefinitionBlock call with container ID string
    function createDefaultJoinBlock(index) {
        const d = document.createElement('div'); d.className = 'join-definition'; d.setAttribute('data-index', index);
        let tableOptions = '<option value="">-- Select Table --</option>'; availableTables.forEach(tbl => { tableOptions += `<option value="${escapeHtml(tbl)}">${escapeHtml(tbl)}</option>`; });
        d.innerHTML = `<select name="joins[${index}][type]"><option value="INNER">INNER</option><option value="LEFT">LEFT</option><option value="RIGHT">RIGHT</option></select> <span>T1:</span> <select name="joins[${index}][left_table]" class="join-table-select" data-col-target="left_col_${index}">${tableOptions}</select> <span>C1:</span> <select name="joins[${index}][left_col]" class="join-col-select" id="left_col_${index}" disabled><option value="">-- Select Table First --</option></select> <span>=</span> <span>T2:</span> <select name="joins[${index}][right_table]" class="join-table-select" data-col-target="right_col_${index}">${tableOptions}</select> <span>C2:</span> <select name="joins[${index}][right_col]" class="join-col-select" id="right_col_${index}" disabled><option value="">-- Select Table First --</option></select> <button type="button" class="remove-join-btn" style="display: none;">X</button>`;
        d.querySelectorAll('.join-table-select').forEach(sel => { sel.addEventListener('change', handleJoinTableChange); });
        const removeBtn = d.querySelector('.remove-join-btn'); if(removeBtn) { removeBtn.onclick = function() { removeDefinitionBlock(this, 'join', 'join-definitions-container', createDefaultJoinBlock); }; }
        return d;
    }
    function createDefaultWhereBlock(index) { const d = document.createElement('div'); d.className = 'where-definition'; d.setAttribute('data-index', index); d.innerHTML = `<select name="where[${index}][connector]" class="where-connector" style="visibility: ${index === 0 ? 'hidden' : 'visible'};"><option value="AND" selected>AND</option><option value="OR">OR</option></select> <select name="where[${index}][column]" class="where-column-select"><option value="">-- Select Column --</option></select> <select name="where[${index}][operator]" class="where-operator"><option value="=" selected>=</option><option value="!=">!=</option><option value=">">&gt;</option><option value="<">&lt;</option><option value=">=">&gt;=</option><option value="<=">&lt;=</option><option value="LIKE">LIKE</option><option value="NOT LIKE">NOT LIKE</option><option value="IN">IN (...)</option><option value="NOT IN">NOT IN (...)</option><option value="IS NULL">IS NULL</option><option value="IS NOT NULL">IS NOT NULL</option></select> <input type="text" name="where[${index}][value]" placeholder="Value(s)" class="where-value"> <button type="button" class="remove-where-btn" style="display: none;">X</button>`; const opSelect = d.querySelector('.where-operator'); if(opSelect) { opSelect.addEventListener('change', function() { toggleWhereValueInput(this); }); } const removeBtn = d.querySelector('.remove-where-btn'); if(removeBtn) { removeBtn.onclick = function() { removeDefinitionBlock(this, 'where', 'where-definitions-container', createDefaultWhereBlock); }; } return d; }
    function createDefaultOrderByBlock(index) { const d = document.createElement('div'); d.className = 'orderby-definition'; d.setAttribute('data-index', index); d.innerHTML = `<label>Column:</label> <select name="orderby[${index}][column]" class="orderby-column-select"><option value="">-- Select Column --</option></select> <label>Direction:</label> <select name="orderby[${index}][direction]"><option value="ASC" selected>ASC</option><option value="DESC">DESC</option></select> <button type="button" class="remove-orderby-btn" style="display: none;">X</button>`; const removeBtn = d.querySelector('.remove-orderby-btn'); if(removeBtn) { removeBtn.onclick = function() { removeDefinitionBlock(this, 'orderby', 'orderby-definitions-container', createDefaultOrderByBlock); }; } return d; }

    // --- Specific WHERE UI Logic ---
    function toggleWhereValueInput(operatorSelect) { const definitionDiv = operatorSelect.closest('.where-definition'); const valueInput = definitionDiv?.querySelector('.where-value'); if (!valueInput) return; const selectedOp = operatorSelect.value.toUpperCase(); valueInput.style.display = (selectedOp === 'IS NULL' || selectedOp === 'IS NOT NULL') ? 'none' : 'inline-block'; if (valueInput.style.display === 'none') { valueInput.value = ''; } }

     // --- Specific JOIN Column Population Logic ---
    async function populateJoinColumnSelect(tableSelectElement, initialValue = null) {
        const selectedTable = tableSelectElement.value;
        const targetColSelectId = tableSelectElement.dataset.colTarget; // Use data attribute to find target ID
        const colSelect = document.getElementById(targetColSelectId); // Get the specific target
        if (!colSelect) { console.error("Target column select not found:", targetColSelectId); return; }
        colSelect.innerHTML = '<option value="">Loading...</option>'; colSelect.disabled = true;
        if (!selectedTable) { colSelect.innerHTML = '<option value="">-- Select Table First --</option>'; return; }
        try {
            const response = await fetch(`get_columns.php?table=${encodeURIComponent(selectedTable)}`);
            if (!response.ok) { throw new Error(`HTTP error ${response.status}`); }
            const data = await response.json(); if (data.error) { throw new Error(data.error); }
            if (data.columns && Array.isArray(data.columns)) {
                colSelect.innerHTML = '<option value="">-- Select Column --</option>';
                data.columns.forEach(column => { const safeColName = escapeHtml(column); const option = document.createElement('option'); option.value = safeColName; option.textContent = safeColName; if (initialValue && safeColName === initialValue) { option.selected = true; } colSelect.appendChild(option); });
                colSelect.disabled = false;
            } else { colSelect.innerHTML = '<option value="">-- No Columns Found --</option>'; }
        } catch (error) { console.error("Error populating columns for JOIN:", error); colSelect.innerHTML = '<option value="">-- Error Loading --</option>'; colSelect.disabled = true; }
    }

    // Event handler for table select change in JOIN block
    function handleJoinTableChange(event) { populateJoinColumnSelect(event.target); }

    // --- Modal Logic ---
    function showModal() { if(modal && modalOverlay) { modalOverlay.classList.add('visible'); modal.classList.add('visible'); } }
    function hideModal() { if(modal && modalOverlay) { modalOverlay.classList.remove('visible'); modal.classList.remove('visible'); } }

    // --- Copy to Clipboard ---
    function copySqlToClipboard() { if (modalQueryContent) { const queryText = modalQueryContent.textContent || modalQueryContent.innerText; navigator.clipboard.writeText(queryText).then(() => { if (copySqlBtn) { const originalText = copySqlBtn.textContent; copySqlBtn.textContent = 'Copied!'; setTimeout(() => { if(copySqlBtn) copySqlBtn.textContent = originalText; }, 1500); } }).catch(err => { console.error('Failed to copy SQL: ', err); alert('Failed to copy SQL to clipboard.'); }); } }


    // --- Attach Event Listeners ---
    document.addEventListener('DOMContentLoaded', () => {
        console.log("DOM fully loaded.");

        // Get elements again inside DOMContentLoaded
        const currentAddJoinBtn = document.getElementById('add-join-btn');
        const currentAddWhereBtn = document.getElementById('add-where-btn');
        const currentAddOrderByBtn = document.getElementById('add-orderby-btn');
        const currentClearFormBtn = document.getElementById('clearFormBtn');
        const currentCloseButton = modal?.querySelector('.modal-close');
        const currentModalOverlay = document.getElementById('modalOverlay');
        const currentCopySqlBtn = document.getElementById('copySqlBtn');

        // Attach Add buttons
        if(currentAddJoinBtn) { currentAddJoinBtn.addEventListener('click', () => addDefinitionBlock(joinsContainer, 'join', createDefaultJoinBlock)); } else { console.warn("Add Join button not found"); }
        if(currentAddWhereBtn) { currentAddWhereBtn.addEventListener('click', () => addDefinitionBlock(whereContainer, 'where', createDefaultWhereBlock)); } else { console.warn("Add Where button not found"); }
        if(currentAddOrderByBtn) { currentAddOrderByBtn.addEventListener('click', () => addDefinitionBlock(orderbyContainer, 'orderby', createDefaultOrderByBlock)); } else { console.warn("Add OrderBy button not found"); }

        // Attach Modal close listeners
        if(currentCloseButton) { currentCloseButton.addEventListener('click', hideModal); } else { console.warn("Modal close button not found"); }
        if(currentModalOverlay) { currentModalOverlay.addEventListener('click', hideModal); } else { console.warn("Modal overlay not found"); }

        // Attach Copy button listener
        if(currentCopySqlBtn) { currentCopySqlBtn.addEventListener('click', copySqlToClipboard); } else { console.warn("Copy SQL button not found"); }


        // Attach Clear button listener
        if(currentClearFormBtn) {
            currentClearFormBtn.addEventListener('click', function() {
                console.log("Clearing form completely...");
                // Function to reset a definition section to one default block
                function resetDefinitionArea(container, namePrefix, createDefaultBlockFn) { if(!container) return; container.innerHTML = ''; container.appendChild(createDefaultBlockFn(0)); updateDefinitionBlockUI(container, namePrefix); }
                // Reset areas
                if (columnsArea) { columnsArea.innerHTML = ''; } // Clear dynamic columns
                if (tableLoadError) { tableLoadError.textContent = ''; tableLoadError.style.display = 'none'; }
                resetDefinitionArea(joinsContainer, 'join', createDefaultJoinBlock);
                resetDefinitionArea(whereContainer, 'where', createDefaultWhereBlock);
                resetDefinitionArea(orderbyContainer, 'orderby', createDefaultOrderByBlock);
                // Reset LIMITs
                const currentLimitCountInput = document.getElementById('limit_count');
                const currentLimitOffsetInput = document.getElementById('limit_offset');
                if (currentLimitCountInput) currentLimitCountInput.value = '';
                if (currentLimitOffsetInput) currentLimitOffsetInput.value = '';
                // Clear results area
                 const currentResultsPanel = document.getElementById('resultsPanel');
                 if(currentResultsPanel) { const h2 = currentResultsPanel.querySelector('h2'); currentResultsPanel.innerHTML = ''; if(h2) currentResultsPanel.appendChild(h2); } // Keep H2
                console.log("Form fully cleared.");
            });
            console.log("Attached: clearFormBtn");
        } else { console.warn("Could not find clearFormBtn on DOM load"); }

        // --- Initial UI setup ---
        console.log("Running initial UI setup...");
        // Populate initial WHERE/ORDER BY dropdowns based on currently displayed columns
        updateAllClauseColumnDropdowns();
        // Select initial values passed from PHP
        whereContainer?.querySelectorAll('.where-definition').forEach(block => {
            const index = block.dataset.index;
            const colSelect = block.querySelector('.where-column-select');
            // Check if initialWhereColumns[index] exists before trying to access it
            if (colSelect && initialWhereColumns && initialWhereColumns[index] !== undefined && initialWhereColumns[index] !== null ) {
                 // Attempt to find and select the option
                 const optionToSelect = colSelect.querySelector(`option[value="${escapeHtml(initialWhereColumns[index])}"]`);
                 if (optionToSelect) {
                     colSelect.value = initialWhereColumns[index];
                 } else {
                     console.warn(`Initial WHERE column value "${initialWhereColumns[index]}" not found in dropdown for index ${index}`);
                 }
            }
        });
        orderbyContainer?.querySelectorAll('.orderby-definition').forEach(block => {
            const index = block.dataset.index;
            const colSelect = block.querySelector('.orderby-column-select');
             // Check if initialOrderByColumns[index] exists before trying to access it
             if (colSelect && initialOrderByColumns && initialOrderByColumns[index] !== undefined && initialOrderByColumns[index] !== null ) {
                 const optionToSelect = colSelect.querySelector(`option[value="${escapeHtml(initialOrderByColumns[index])}"]`);
                 if (optionToSelect) {
                    colSelect.value = initialOrderByColumns[index];
                 } else {
                     console.warn(`Initial ORDER BY column value "${initialOrderByColumns[index]}" not found in dropdown for index ${index}`);
                 }
            }
        });

        updateDefinitionBlockUI(joinsContainer, 'join');
        updateDefinitionBlockUI(whereContainer, 'where');
        updateDefinitionBlockUI(orderbyContainer, 'orderby');

        // Add initial event listeners for operator changes in WHERE blocks rendered by PHP
         whereContainer?.querySelectorAll('.where-operator')?.forEach(select => {
            select.addEventListener('change', function() { toggleWhereValueInput(this); });
         });

         // Add initial event listeners for table changes and remove buttons in blocks rendered by PHP
         joinsContainer?.querySelectorAll('.join-definition')?.forEach(joinBlock => {
             const index = joinBlock.dataset.index;
             // Table Select Listeners
             joinBlock.querySelectorAll('.join-table-select').forEach(select => {
                 select.addEventListener('change', handleJoinTableChange);
                 if(select.value) { // If a table is already selected (from PHP/POST)
                     console.log("Triggering initial column population for:", select.value, "Index:", index);
                     let initialColValue = null;
                     if (initialJoinColumns && initialJoinColumns[index] !== undefined) { // Check index exists
                         const side = select.dataset.colTarget.startsWith('left') ? 'left_col' : 'right_col';
                         initialColValue = initialJoinColumns[index][side];
                     }
                     populateJoinColumnSelect(select, initialColValue);
                 }
             });
             // Remove Button Listener
             const removeBtn = joinBlock.querySelector('.remove-join-btn');
             if(removeBtn && !removeBtn.getAttribute('listener-attached')) {
                 removeBtn.onclick = function() { removeDefinitionBlock(this, 'join', 'join-definitions-container', createDefaultJoinBlock); };
                 removeBtn.setAttribute('listener-attached', 'true');
             }
         });
         whereContainer?.querySelectorAll('.where-definition .remove-where-btn')?.forEach(removeBtn => {
             if(!removeBtn.getAttribute('listener-attached')) {
                 removeBtn.onclick = function() { removeDefinitionBlock(this, 'where', 'where-definitions-container', createDefaultWhereBlock); };
                 removeBtn.setAttribute('listener-attached', 'true');
             }
         });
         orderbyContainer?.querySelectorAll('.orderby-definition .remove-orderby-btn')?.forEach(removeBtn => {
              if(!removeBtn.getAttribute('listener-attached')) {
                 removeBtn.onclick = function() { removeDefinitionBlock(this, 'orderby', 'orderby-definitions-container', createDefaultOrderByBlock); };
                 removeBtn.setAttribute('listener-attached', 'true');
             }
         });


         console.log("Initial UI setup complete.");
     }); // End DOMContentLoaded

    </script>

</body>
</html>