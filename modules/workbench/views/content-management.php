<?php
/**
 * Content Management Tool
 * 
 * Allows administrators to manage website content, pages, and media
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
            <h1>Content Management</h1>
            <p class="text-muted">Manage website content, pages, and media</p>
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
                    <i class="fas fa-file-alt me-2"></i> Pages
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-newspaper me-2"></i> Articles
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-images me-2"></i> Media Library
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-th-large me-2"></i> Blocks
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-tags me-2"></i> Categories & Tags
                </a>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i> New Page
                        </button>
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-upload me-2"></i> Upload Media
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pages</h5>
                        <div class="input-group" style="max-width: 300px;">
                            <input type="text" class="form-control" placeholder="Search pages...">
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
                                    <th>Title</th>
                                    <th>URL</th>
                                    <th>Author</th>
                                    <th>Last Modified</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Placeholder data - would be populated from database -->
                                <tr>
                                    <td>Home</td>
                                    <td>/</td>
                                    <td>Admin</td>
                                    <td>2025-02-15</td>
                                    <td><span class="badge bg-success">Published</span></td>
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
                                    <td>About Us</td>
                                    <td>/about</td>
                                    <td>John Doe</td>
                                    <td>2025-02-10</td>
                                    <td><span class="badge bg-success">Published</span></td>
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
                                    <td>Contact</td>
                                    <td>/contact</td>
                                    <td>Jane Smith</td>
                                    <td>2025-02-05</td>
                                    <td><span class="badge bg-success">Published</span></td>
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
                                    <td>Services</td>
                                    <td>/services</td>
                                    <td>Admin</td>
                                    <td>2025-01-28</td>
                                    <td><span class="badge bg-warning text-dark">Draft</span></td>
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
                    
                    <nav aria-label="Page pagination">
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
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Content Analytics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="text-center p-3">
                                <h3 class="text-primary">24</h3>
                                <p class="text-muted mb-0">Total Pages</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="text-center p-3">
                                <h3 class="text-success">18</h3>
                                <p class="text-muted mb-0">Published</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="text-center p-3">
                                <h3 class="text-warning">6</h3>
                                <p class="text-muted mb-0">Drafts</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="text-center p-3">
                                <h3 class="text-info">142</h3>
                                <p class="text-muted mb-0">Media Items</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once MODULES_PATH . '/common/views/auth/view.footer.php'; ?>
