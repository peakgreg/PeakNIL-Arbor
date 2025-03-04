<?php
/**
 * System Logs Tool
 * 
 * Allows administrators to view system logs and activity
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
            <h1>System Logs</h1>
            <p class="text-muted">View system logs and activity</p>
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
                    <i class="fas fa-user-clock me-2"></i> User Activity
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-exclamation-triangle me-2"></i> Error Logs
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-shield-alt me-2"></i> Security Logs
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-envelope me-2"></i> Email Logs
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-sync me-2"></i> System Changes
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-cog me-2"></i> Log Settings
                </a>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Log Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-download me-2"></i> Export Logs
                        </button>
                        <button class="btn btn-outline-danger">
                            <i class="fas fa-trash me-2"></i> Clear Logs
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">User Activity Logs</h5>
                        <div class="d-flex">
                            <select class="form-select form-select-sm me-2" style="width: 150px;">
                                <option selected>All Actions</option>
                                <option>Login</option>
                                <option>Logout</option>
                                <option>Create</option>
                                <option>Update</option>
                                <option>Delete</option>
                            </select>
                            <div class="input-group" style="width: 200px;">
                                <input type="text" class="form-control form-control-sm" placeholder="Search logs...">
                                <button class="btn btn-sm btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Module</th>
                                    <th>IP Address</th>
                                    <th>Date/Time</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Placeholder data - would be populated from database -->
                                <tr>
                                    <td>1001</td>
                                    <td>admin@example.com</td>
                                    <td><span class="badge bg-primary">Login</span></td>
                                    <td>Authentication</td>
                                    <td>192.168.1.1</td>
                                    <td>2025-02-27 01:15:22</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1000</td>
                                    <td>john.doe@example.com</td>
                                    <td><span class="badge bg-success">Update</span></td>
                                    <td>User Management</td>
                                    <td>192.168.1.2</td>
                                    <td>2025-02-26 23:42:10</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>999</td>
                                    <td>jane.smith@example.com</td>
                                    <td><span class="badge bg-success">Create</span></td>
                                    <td>School Management</td>
                                    <td>192.168.1.3</td>
                                    <td>2025-02-26 22:18:45</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>998</td>
                                    <td>admin@example.com</td>
                                    <td><span class="badge bg-warning text-dark">Update</span></td>
                                    <td>System Settings</td>
                                    <td>192.168.1.1</td>
                                    <td>2025-02-26 21:05:33</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>997</td>
                                    <td>bob.johnson@example.com</td>
                                    <td><span class="badge bg-danger">Delete</span></td>
                                    <td>Content Management</td>
                                    <td>192.168.1.4</td>
                                    <td>2025-02-26 20:47:12</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>996</td>
                                    <td>jane.smith@example.com</td>
                                    <td><span class="badge bg-secondary">Logout</span></td>
                                    <td>Authentication</td>
                                    <td>192.168.1.3</td>
                                    <td>2025-02-26 19:30:05</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>995</td>
                                    <td>john.doe@example.com</td>
                                    <td><span class="badge bg-info">View</span></td>
                                    <td>Reports</td>
                                    <td>192.168.1.2</td>
                                    <td>2025-02-26 18:22:41</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>994</td>
                                    <td>admin@example.com</td>
                                    <td><span class="badge bg-success">Create</span></td>
                                    <td>User Management</td>
                                    <td>192.168.1.1</td>
                                    <td>2025-02-26 17:15:09</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>993</td>
                                    <td>bob.johnson@example.com</td>
                                    <td><span class="badge bg-primary">Login</span></td>
                                    <td>Authentication</td>
                                    <td>192.168.1.4</td>
                                    <td>2025-02-26 16:58:33</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>992</td>
                                    <td>jane.smith@example.com</td>
                                    <td><span class="badge bg-primary">Login</span></td>
                                    <td>Authentication</td>
                                    <td>192.168.1.3</td>
                                    <td>2025-02-26 16:45:22</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing 1-10 of 1,248 entries
                        </div>
                        <nav aria-label="Log pagination">
                            <ul class="pagination pagination-sm mb-0">
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
            
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Log Details</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Select a log entry from the table above to view its details here.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Log ID</label>
                                <div class="form-control bg-light">1001</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Date/Time</label>
                                <div class="form-control bg-light">2025-02-27 01:15:22</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">User</label>
                                <div class="form-control bg-light">admin@example.com</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">IP Address</label>
                                <div class="form-control bg-light">192.168.1.1</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Action</label>
                                <div class="form-control bg-light">Login</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-muted">Module</label>
                                <div class="form-control bg-light">Authentication</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">User Agent</label>
                        <div class="form-control bg-light">Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Additional Data</label>
                        <pre class="form-control bg-light" style="max-height: 150px; overflow-y: auto;">
{
  "status": "success",
  "session_id": "sess_12345abcde",
  "login_method": "password",
  "remember_me": true,
  "browser": "Chrome",
  "os": "macOS",
  "device": "Desktop"
}
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once MODULES_PATH . '/common/views/auth/view.footer.php'; ?>
