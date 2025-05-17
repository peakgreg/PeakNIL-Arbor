<?php
/**
 * Reports & Analytics Tool
 * 
 * Allows administrators to view and generate reports and analytics
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
            <h1>Reports & Analytics</h1>
            <p class="text-muted">View and generate reports and analytics</p>
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
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-users me-2"></i> User Reports
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-school me-2"></i> School Reports
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-chart-line me-2"></i> Performance Analytics
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-file-export me-2"></i> Export Reports
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-cog me-2"></i> Report Settings
                </a>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Quick Reports</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-users me-2"></i> Active Users
                        </button>
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-school me-2"></i> School Summary
                        </button>
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-chart-pie me-2"></i> System Usage
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Dashboard Overview</h5>
                        <div>
                            <select class="form-select form-select-sm">
                                <option selected>Last 30 days</option>
                                <option>Last 7 days</option>
                                <option>Last 90 days</option>
                                <option>This year</option>
                                <option>Custom range</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <div class="display-4 text-primary mb-2">1,248</div>
                                    <div class="text-muted">Total Users</div>
                                    <div class="small text-success mt-2">
                                        <i class="fas fa-arrow-up me-1"></i> 12% increase
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <div class="display-4 text-success mb-2">42</div>
                                    <div class="text-muted">Active Schools</div>
                                    <div class="small text-success mt-2">
                                        <i class="fas fa-arrow-up me-1"></i> 5% increase
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <div class="display-4 text-info mb-2">8,547</div>
                                    <div class="text-muted">Page Views</div>
                                    <div class="small text-success mt-2">
                                        <i class="fas fa-arrow-up me-1"></i> 18% increase
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <div class="display-4 text-warning mb-2">86%</div>
                                    <div class="text-muted">User Engagement</div>
                                    <div class="small text-success mt-2">
                                        <i class="fas fa-arrow-up me-1"></i> 3% increase
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h6 class="text-uppercase text-muted mb-3">User Activity Trend</h6>
                            <div class="bg-light p-3 rounded" style="height: 300px;">
                                <div class="text-center text-muted py-5">
                                    <i class="fas fa-chart-line fa-3x mb-3"></i>
                                    <p>Chart visualization would appear here</p>
                                    <p class="small">Showing user activity over time</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-uppercase text-muted mb-3">User Distribution</h6>
                            <div class="bg-light p-3 rounded" style="height: 300px;">
                                <div class="text-center text-muted py-5">
                                    <i class="fas fa-chart-pie fa-3x mb-3"></i>
                                    <p>Chart visualization would appear here</p>
                                    <p class="small">Showing user role distribution</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-uppercase text-muted mb-3">Recent Activity</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>User</th>
                                            <th>Action</th>
                                            <th>Module</th>
                                            <th>Date/Time</th>
                                            <th>IP Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>admin@example.com</td>
                                            <td>Login</td>
                                            <td>Authentication</td>
                                            <td>2025-02-27 01:15:22</td>
                                            <td>192.168.1.1</td>
                                        </tr>
                                        <tr>
                                            <td>john.doe@example.com</td>
                                            <td>Update Profile</td>
                                            <td>User Management</td>
                                            <td>2025-02-26 23:42:10</td>
                                            <td>192.168.1.2</td>
                                        </tr>
                                        <tr>
                                            <td>jane.smith@example.com</td>
                                            <td>Add School</td>
                                            <td>School Management</td>
                                            <td>2025-02-26 22:18:45</td>
                                            <td>192.168.1.3</td>
                                        </tr>
                                        <tr>
                                            <td>admin@example.com</td>
                                            <td>System Settings Update</td>
                                            <td>System Settings</td>
                                            <td>2025-02-26 21:05:33</td>
                                            <td>192.168.1.1</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end">
                                <a href="#" class="btn btn-sm btn-outline-primary">View All Activity</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Generate Custom Report</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="report_type" class="form-label">Report Type</label>
                                <select class="form-select" id="report_type">
                                    <option selected>User Activity</option>
                                    <option>School Performance</option>
                                    <option>System Usage</option>
                                    <option>Content Analytics</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="date_range" class="form-label">Date Range</label>
                                <select class="form-select" id="date_range">
                                    <option selected>Last 30 days</option>
                                    <option>Last 7 days</option>
                                    <option>Last 90 days</option>
                                    <option>This year</option>
                                    <option>Custom range</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="format" class="form-label">Format</label>
                                <select class="form-select" id="format">
                                    <option selected>PDF</option>
                                    <option>Excel</option>
                                    <option>CSV</option>
                                    <option>HTML</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="include_charts" class="form-label">Include Charts</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="include_charts" checked>
                                    <label class="form-check-label" for="include_charts">Include visual charts in report</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-secondary me-2">Reset</button>
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once MODULES_PATH . '/common/views/auth/view.footer.php'; ?>
