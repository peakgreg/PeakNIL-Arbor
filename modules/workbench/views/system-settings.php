<?php
/**
 * System Settings Tool
 * 
 * Allows administrators to configure system settings and preferences
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
            <h1>System Settings</h1>
            <p class="text-muted">Configure system settings and preferences</p>
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
                    <i class="fas fa-sliders-h me-2"></i> General Settings
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-envelope me-2"></i> Email Settings
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-shield-alt me-2"></i> Security Settings
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-database me-2"></i> Database Settings
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-file-alt me-2"></i> File Storage
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-bell me-2"></i> Notifications
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fas fa-plug me-2"></i> Integrations
                </a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">General Settings</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted mb-3">Site Information</h6>
                            
                            <div class="mb-3">
                                <label for="site_name" class="form-label">Site Name</label>
                                <input type="text" class="form-control" id="site_name" value="School Management System">
                                <div class="form-text">The name of your website.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="site_description" class="form-label">Site Description</label>
                                <textarea class="form-control" id="site_description" rows="2">A comprehensive platform for managing schools, students, and educational resources.</textarea>
                                <div class="form-text">A brief description of your website.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="site_url" class="form-label">Site URL</label>
                                <input type="url" class="form-control" id="site_url" value="https://example.com">
                                <div class="form-text">The full URL of your website.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="admin_email" class="form-label">Admin Email</label>
                                <input type="email" class="form-control" id="admin_email" value="admin@example.com">
                                <div class="form-text">The main administrative email address.</div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted mb-3">Regional Settings</h6>
                            
                            <div class="mb-3">
                                <label for="timezone" class="form-label">Timezone</label>
                                <select class="form-select" id="timezone">
                                    <option value="UTC" selected>UTC</option>
                                    <option value="America/New_York">America/New_York</option>
                                    <option value="America/Chicago">America/Chicago</option>
                                    <option value="America/Denver">America/Denver</option>
                                    <option value="America/Los_Angeles">America/Los_Angeles</option>
                                    <option value="Europe/London">Europe/London</option>
                                    <option value="Europe/Paris">Europe/Paris</option>
                                    <option value="Asia/Tokyo">Asia/Tokyo</option>
                                </select>
                                <div class="form-text">Choose your local timezone.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="date_format" class="form-label">Date Format</label>
                                <select class="form-select" id="date_format">
                                    <option value="Y-m-d" selected>2025-02-27 (Y-m-d)</option>
                                    <option value="m/d/Y">02/27/2025 (m/d/Y)</option>
                                    <option value="d/m/Y">27/02/2025 (d/m/Y)</option>
                                    <option value="F j, Y">February 27, 2025 (F j, Y)</option>
                                </select>
                                <div class="form-text">Choose how dates should be displayed.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="time_format" class="form-label">Time Format</label>
                                <select class="form-select" id="time_format">
                                    <option value="H:i" selected>13:30 (24-hour)</option>
                                    <option value="h:i A">1:30 PM (12-hour)</option>
                                </select>
                                <div class="form-text">Choose how times should be displayed.</div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted mb-3">System Preferences</h6>
                            
                            <div class="mb-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="maintenance_mode">
                                <label class="form-check-label" for="maintenance_mode">Maintenance Mode</label>
                                <div class="form-text">When enabled, the site will show a maintenance page to visitors.</div>
                            </div>
                            
                            <div class="mb-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="debug_mode">
                                <label class="form-check-label" for="debug_mode">Debug Mode</label>
                                <div class="form-text">When enabled, detailed error messages will be displayed.</div>
                            </div>
                            
                            <div class="mb-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="user_registration" checked>
                                <label class="form-check-label" for="user_registration">Allow User Registration</label>
                                <div class="form-text">When enabled, new users can register on the site.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="items_per_page" class="form-label">Items Per Page</label>
                                <input type="number" class="form-control" id="items_per_page" value="20" min="5" max="100">
                                <div class="form-text">Number of items to display per page in listings.</div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-secondary me-2">Reset to Defaults</button>
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-info-circle text-primary fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Need help with system settings?</h5>
                            <p class="card-text mb-0">
                                Changing some settings may affect how the system operates. If you're unsure about any setting,
                                please refer to the <a href="/docs/system-settings" class="text-decoration-none">documentation</a> or
                                contact the <a href="/support" class="text-decoration-none">support team</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once MODULES_PATH . '/common/views/auth/view.footer.php'; ?>
