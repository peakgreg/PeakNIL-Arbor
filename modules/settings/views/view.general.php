<?php
// Include header
require_once MODULES_PATH . '/common/views/auth/view.header.php';
?>

<div class="container">
    <header class="settings-header">
        <h1>General Settings</h1>
    </header>

    <!-- Navigation tabs -->
    <nav class="settings-nav">
        <a href="/settings?page=general" class="active">General</a>
        <a href="/settings?page=security">Security</a>
    </nav>

    <!-- Display any messages -->
    <?php if (isset($result)): ?>
        <div class="alert <?php echo isset($result['error']) ? 'alert-error' : 'alert-success'; ?>">
            <?php echo $result['error'] ?? $result['success'] ?? ''; ?>
        </div>
    <?php endif; ?>

    <!-- Settings form -->
    <form method="POST" action="/settings" class="settings-form">
        <input type="hidden" name="action" value="update_general">
        
        <div class="form-group">
            <label for="name">Display Name</label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="<?php echo htmlspecialchars($settings['name'] ?? ''); ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="<?php echo htmlspecialchars($settings['email'] ?? ''); ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="timezone">Timezone</label>
            <select id="timezone" name="timezone">
                <?php foreach (get_timezone_list() as $tz): ?>
                    <option value="<?php echo htmlspecialchars($tz); ?>"
                            <?php echo ($settings['timezone'] ?? '') === $tz ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($tz); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" 
                       name="notifications" 
                       value="1"
                       <?php echo ($settings['notifications'] ?? false) ? 'checked' : ''; ?>>
                Receive email notifications
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>

<!-- Include module-specific CSS/JS -->
<link href="/assets/modules/settings/css/settings.css" rel="stylesheet">
<script src="/assets/modules/settings/js/settings.js"></script>

<?php
// Include footer
require_once MODULES_PATH . '/common/views/auth/view.footer.php';
?>