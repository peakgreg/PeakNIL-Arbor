<?php
/**
 * Database Schema Viewer
 * 
 * Displays all MySQL tables and their schema for reference.
 * Does not display any table content for security reasons.
 */

// Include necessary files
require_once '../config/init.php';

// Page title
$page_title = 'Database Schema Viewer';

// Function to get all tables
function getAllTables($conn) {
    $tables = [];
    $result = $conn->query("SHOW TABLES");
    
    if ($result) {
        while ($row = $result->fetch_row()) {
            $tables[] = $row[0];
        }
    }
    
    return $tables;
}

// Function to get table schema
function getTableSchema($conn, $table) {
    $schema = [];
    
    // Get columns
    $result = $conn->query("DESCRIBE `$table`");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $schema['columns'][] = $row;
        }
    }
    
    // Get indexes
    $result = $conn->query("SHOW INDEX FROM `$table`");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $schema['indexes'][] = $row;
        }
    }
    
    // Get create table statement
    $result = $conn->query("SHOW CREATE TABLE `$table`");
    if ($result && $row = $result->fetch_assoc()) {
        $schema['create_statement'] = $row['Create Table'];
    }
    
    return $schema;
}

// Get all tables
$tables = getAllTables($conn);

// Sort tables alphabetically
sort($tables);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }
        .table-container {
            margin-bottom: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .table-name {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border-left: 4px solid #0d6efd;
        }
        .schema-tabs {
            margin-bottom: 15px;
        }
        pre {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
        }
        .nav-tabs .nav-link {
            color: #495057;
        }
        .nav-tabs .nav-link.active {
            font-weight: bold;
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <h1 class="mb-4"><?= $page_title ?></h1>
        
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tables</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <?php foreach ($tables as $table): ?>
                            <a href="#table-<?= $table ?>" class="list-group-item list-group-item-action">
                                <?= $table ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <?php if (empty($tables)): ?>
                <div class="alert alert-info">
                    No tables found in the database.
                </div>
                <?php else: ?>
                    <?php foreach ($tables as $table): ?>
                    <div id="table-<?= $table ?>" class="table-container">
                        <h3 class="table-name"><?= $table ?></h3>
                        
                        <?php 
                        $schema = getTableSchema($conn, $table);
                        ?>
                        
                        <ul class="nav nav-tabs schema-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="columns-tab-<?= $table ?>" data-bs-toggle="tab" data-bs-target="#columns-<?= $table ?>" type="button" role="tab">
                                    Columns
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="indexes-tab-<?= $table ?>" data-bs-toggle="tab" data-bs-target="#indexes-<?= $table ?>" type="button" role="tab">
                                    Indexes
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="create-tab-<?= $table ?>" data-bs-toggle="tab" data-bs-target="#create-<?= $table ?>" type="button" role="tab">
                                    Create Statement
                                </button>
                            </li>
                        </ul>
                        
                        <div class="tab-content">
                            <!-- Columns Tab -->
                            <div class="tab-pane fade show active" id="columns-<?= $table ?>" role="tabpanel">
                                <?php if (isset($schema['columns']) && !empty($schema['columns'])): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Field</th>
                                                <th>Type</th>
                                                <th>Null</th>
                                                <th>Key</th>
                                                <th>Default</th>
                                                <th>Extra</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($schema['columns'] as $column): ?>
                                            <tr>
                                                <td><?= $column['Field'] ?></td>
                                                <td><?= $column['Type'] ?></td>
                                                <td><?= $column['Null'] ?></td>
                                                <td><?= $column['Key'] ?></td>
                                                <td><?= $column['Default'] !== null ? $column['Default'] : '<em>NULL</em>' ?></td>
                                                <td><?= $column['Extra'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php else: ?>
                                <div class="alert alert-warning">
                                    No column information available.
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Indexes Tab -->
                            <div class="tab-pane fade" id="indexes-<?= $table ?>" role="tabpanel">
                                <?php if (isset($schema['indexes']) && !empty($schema['indexes'])): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Key Name</th>
                                                <th>Column</th>
                                                <th>Non Unique</th>
                                                <th>Seq in Index</th>
                                                <th>Index Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($schema['indexes'] as $index): ?>
                                            <tr>
                                                <td><?= $index['Key_name'] ?></td>
                                                <td><?= $index['Column_name'] ?></td>
                                                <td><?= $index['Non_unique'] ?></td>
                                                <td><?= $index['Seq_in_index'] ?></td>
                                                <td><?= $index['Index_type'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php else: ?>
                                <div class="alert alert-warning">
                                    No index information available.
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Create Statement Tab -->
                            <div class="tab-pane fade" id="create-<?= $table ?>" role="tabpanel">
                                <?php if (isset($schema['create_statement'])): ?>
                                <pre><code><?= htmlspecialchars($schema['create_statement']) ?></code></pre>
                                <?php else: ?>
                                <div class="alert alert-warning">
                                    Create statement not available.
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll to table when clicking on sidebar link
        document.querySelectorAll('.list-group-item').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 20,
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
    </script>
</body>
</html>
