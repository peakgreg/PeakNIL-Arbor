<?php
/**
 * School Management Tool
 * 
 * Allows administrators to manage schools, departments, and programs
 */

// Check permissions (placeholder - implement actual permission checking)
// In a real implementation, this would check if the user has the required permissions
$has_permission = true; // Placeholder

// If the user doesn't have permission, redirect to the workbench
if (!$has_permission) {
    header('Location: /workbench?action=overview');
    exit;
}

// Include header
require_once MODULES_PATH . '/common/views/auth/view.header.php';
?>

<?php require_once __DIR__ . '/view.workbench-nav.php'; ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>School Management</h1>
            <p class="text-muted">Manage schools, departments, and programs</p>
        </div>
        <div>
            <a href="/workbench?action=overview" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Workbench
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active">
                    <i class="fas fa-school me-2"></i> All Schools
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-plus-circle me-2"></i> Add New School
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-building me-2"></i> Departments
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-graduation-cap me-2"></i> Programs
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-map-marker-alt me-2"></i> School Locations
                </a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">All Schools</h5>
                        <div class="input-group" style="max-width: 300px;">
                            <input type="text" class="form-control" placeholder="Search schools...">
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
                                    <th>ID</th>
                                    <th>School Name</th>
                                    <th>Location</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Placeholder data - would be populated from database -->
                                <tr>
                                    <td>1</td>
                                    <td>Washington High School</td>
                                    <td>Chicago, IL</td>
                                    <td><span class="badge bg-primary">High School</span></td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Lincoln Elementary</td>
                                    <td>New York, NY</td>
                                    <td><span class="badge bg-info">Elementary</span></td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Jefferson Middle School</td>
                                    <td>Los Angeles, CA</td>
                                    <td><span class="badge bg-secondary">Middle School</span></td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-primary">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <nav aria-label="School pagination">
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
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">School Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="p-3">
                                <h3 class="text-primary">42</h3>
                                <p class="text-muted mb-0">Total Schools</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3">
                                <h3 class="text-success">36</h3>
                                <p class="text-muted mb-0">Active</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3">
                                <h3 class="text-warning">6</h3>
                                <p class="text-muted mb-0">Pending</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-success me-2">Added</span>
                                    <span>Lincoln Elementary</span>
                                </div>
                                <small class="text-muted">2 days ago</small>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-primary me-2">Updated</span>
                                    <span>Washington High School</span>
                                </div>
                                <small class="text-muted">3 days ago</small>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-warning text-dark me-2">Pending</span>
                                    <span>Jefferson Middle School</span>
                                </div>
                                <small class="text-muted">5 days ago</small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once MODULES_PATH . '/common/views/auth/view.footer.php'; ?>
