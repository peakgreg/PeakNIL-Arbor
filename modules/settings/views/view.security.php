<?php
// Include header
require_once MODULES_PATH . '/common/views/auth/view.header.php';
?>

<div class="container">
    <header class="settings-header">
        <h1>Security Settings</h1>
    </header>

    <!-- Navigation tabs -->
    <nav class="settings-nav">
        <a href="/settings?page=general">General</a>
        <a href="/settings?page=security" class="active">Security</a>
    </nav>

    <!-- Display any messages -->
    <?php if (isset($result)): ?>
        <div class="alert <?php echo isset($result['error']) ? 'alert-error' : 'alert-success'; ?>">
            <?php echo $result['error'] ?? $result['success'] ?? ''; ?>
        </div>
    <?php endif; ?>

    <!-- Password Change Form -->
    <section class="settings-section">
        <h2>Change Password</h2>
        <form method="POST" action="/settings" class="settings-form">
            <input type="hidden" name="action" value="change_password">
            
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" 
                       id="current_password" 
                       name="current_password" 
                       required>
            </div>

            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" 
                       id="new_password" 
                       name="new_password" 
                       required>
                <small>Must be at least 8 characters long</small>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" 
                       id="confirm_password" 
                       name="confirm_password" 
                       required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Password</button>
            </div>
        </form>
    </section>

    <!-- Two-Factor Authentication -->
    <section class="settings-section">
        <h2>Two-Factor Authentication</h2>
        <form method="POST" action="/settings" class="settings-form">
            <input type="hidden" name="action" value="update_security">
            
            <div class="form-group">
                <label>
                    <input type="checkbox" 
                           name="enable_2fa" 
                           value="1"
                           <?php echo ($settings['two_factor_enabled'] ?? false) ? 'checked' : ''; ?>>
                    Enable Two-Factor Authentication
                </label>
                <small>
                    Adds an extra layer of security to your account by requiring a code 
                    from your phone in addition to your password.
                </small>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" 
                           name="login_notifications" 
                           value="1"
                           <?php echo ($settings['login_notifications'] ?? false) ? 'checked' : ''; ?>>
                    Email me about new or unusual login attempts
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Security Settings</button>
            </div>
        </form>
    </section>

    <!-- Recent Activity -->
    <section class="settings-section">
        <h2>Recent Login Activity</h2>
        <div class="activity-list">
            <?php if (!empty($settings['recent_activity'])): ?>
                <table class="activity-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>IP Address</th>
                            <th>Device</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($settings['recent_activity'] as $activity): ?>
                            <tr>
                                <td><?php echo htmlspecialchars(date('M j, Y g:i A', strtotime($activity['created_at']))); ?></td>
                                <td><?php echo htmlspecialchars($activity['ip_address']); ?></td>
                                <td><?php echo htmlspecialchars($activity['user_agent']); ?></td>
                                <td>
                                    <span class="status-badge <?php echo $activity['status'] === 'success' ? 'success' : 'failed'; ?>">
                                        <?php echo htmlspecialchars(ucfirst($activity['status'])); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No recent login activity</p>
            <?php endif; ?>
        </div>
    </section>
</div>

<!-- Include module-specific CSS/JS -->
<link href="/assets/modules/settings/css/settings.css" rel="stylesheet">
<script src="/assets/modules/settings/js/settings.js"></script>

<?php
// Include footer
require_once MODULES_PATH . '/common/views/auth/view.footer.php';
?>