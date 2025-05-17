<?php
/**
 * User Management Tool
 * 
 * Allows administrators to manage users, roles, and permissions
 */

// Check permissions (placeholder - implement actual permission checking)
// In a real implementation, this would check if the user has the required permissions
$has_permission = true; // Placeholder

// If the user doesn't have permission, redirect to the workbench
if (!$has_permission) {
    header('Location: /workbench?action=overview');
    exit;
}

// Get Users
$sql = "SELECT id, uuid, first_name, last_name, role_id FROM user_profiles";
$result = $conn->query($sql);

// Include header
require_once MODULES_PATH . '/common/views/auth/view.header.php';
?>

<?php require_once __DIR__ . '/view.workbench-nav.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>User Management</h3>
            <p class="text-muted">Manage users, roles, and permissions</p>
        </div>
        <div>
            <a href="/workbench?action=overview" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Workbench
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-2">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active">
                    <i class="fas fa-users me-2"></i> All Users
                </a>
                <a href="#" class="list-group-item list-group-item-action" hidden>
                    <i class="fas fa-user-plus me-2"></i> Add New User
                </a>
                <a href="#" class="list-group-item list-group-item-action" hidden>
                    <i class="fas fa-user-tag me-2"></i> Roles & Permissions
                </a>
                <a href="#" class="list-group-item list-group-item-action" hidden>
                    <i class="fas fa-user-shield me-2"></i> User Verification
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-user-slash me-2"></i> Banned Users
                </a>
            </div>
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">All Users</h5>
                        <div class="input-group" style="max-width: 300px;">
                            <input type="text" class="form-control" placeholder="Search users...">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Placeholder data - would be populated from database -->
<?php
// Check if there are results
if ($result->num_rows > 0) {
    // Loop through each row of results
    while($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $row["first_name"] ?> <?= $row["last_name"] ?></td>

                                    <td><span class="badge bg-primary"><?= $row['role_id'] ?></span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href = "workbench?action=view-user&uuid=<?= $row['uuid'] ?>" type="button" class="btn btn-outline-primary">
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
    <?php }
} else {
    echo "0 results found";
}
?>
                            </tbody>
                        </table>
                    </div>
                    
                    <nav aria-label="User pagination">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once MODULES_PATH . '/common/views/auth/view.footer.php'; ?>
