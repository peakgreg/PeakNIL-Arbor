<?php
/**
 * Workbench Navigation Menu
 * 
 * Navigation menu for the workbench module that allows users to quickly switch between tools
 */

// Get the current action from the URL
$current_action = isset($_GET['action']) ? $_GET['action'] : 'overview';

// Get workbench tools accessible by the current user
$tools = get_user_workbench_tools();

// Add the overview (dashboard) to the beginning of the tools array
array_unshift($tools, [
    'id' => 'overview',
    'name' => 'Dashboard',
    'description' => 'Workbench Dashboard',
    'icon' => 'fa-tachometer-alt',
    'url' => '/workbench?action=overview',
    'permissions' => ['admin', 'manager']
]);
?>

<div class="workbench-nav bg-light py-3 mb-4 border-bottom">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg p-0" style="background: transparent; box-shadow: none; border: none;">
            <h5 class="navbar-brand mb-0">Workbench</h5>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#workbenchNavbar" 
                    aria-controls="workbenchNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="workbenchNavbar" style="border: none; background: transparent;">
                <ul class="navbar-nav nav-pills ms-auto" style="font-size: 0.85rem;">
                    <?php foreach ($tools as $tool): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_action === $tool['id']) ? 'active text-white' : ''; ?>" 
                               href="<?php echo htmlspecialchars($tool['url']); ?>" 
                               title="<?php echo htmlspecialchars($tool['description']); ?>">
                                <i class="fas <?php echo htmlspecialchars($tool['icon']); ?> me-1"></i>
                                <span><?php echo htmlspecialchars($tool['name']); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
    </div>
</div>
