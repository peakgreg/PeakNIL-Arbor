<?php require_once MODULES_PATH . '/common/views/auth/view.header.php'; ?>

<?php require_once __DIR__ . '/view.workbench-nav.php'; ?>

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h3>Workbench Portal</h3>
            <p class="lead">Welcome to the Workbench Portal. Select a tool to manage different aspects of the website.</p>
        </div>
    </div>

    <div class="row">
        <?php
        // Get workbench tools accessible by the current user
        $tools = get_user_workbench_tools();
        
        // Display each tool as a card
        foreach ($tools as $tool) {
            ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas <?php echo htmlspecialchars($tool['icon']); ?> fa-fw"></i>
                            </div>
                            <h5 class="card-title mb-0"><?php echo htmlspecialchars($tool['name']); ?></h5>
                        </div>
                        <p class="card-text"><?php echo htmlspecialchars($tool['description']); ?></p>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <a href="<?php echo htmlspecialchars($tool['url']); ?>" class="btn btn-outline-primary">
                            Access Tool <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        }
        
        // If no tools are available, display a message
        if (empty($tools)) {
            ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> You don't have access to any workbench tools. Please contact an administrator if you believe this is an error.
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-question-circle text-primary me-2"></i>
                        Need Help?
                    </h5>
                    <p class="card-text">
                        If you need assistance with any of the workbench tools, please refer to the 
                        <a href="/docs/workbench" class="text-decoration-none">documentation</a> or 
                        contact the <a href="/support" class="text-decoration-none">support team</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once MODULES_PATH . '/common/views/auth/view.footer.php'; ?>
