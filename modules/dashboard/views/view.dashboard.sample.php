<?php
/**
 * Sample Dashboard View
 * 
 * This is a sample dashboard view that demonstrates how to use the include functions
 * for authenticated views. This file can be used as a template for creating new
 * authenticated views.
 */

// Include the file inclusion helper functions
require_once MODULES_PATH . '/common/functions/include_functions.php';

// Include header (true = authenticated)
include_header(true);
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Dashboard</h1>
            <p class="lead">Welcome to your dashboard.</p>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profile</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">View and edit your profile information.</p>
                    <a href="/profile" class="btn btn-primary">Go to Profile</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Marketplace</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Browse available NIL opportunities.</p>
                    <a href="/marketplace" class="btn btn-primary">Go to Marketplace</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Settings</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Manage your account settings.</p>
                    <a href="/settings" class="btn btn-primary">Go to Settings</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">This is where recent activity would be displayed.</p>
                    
                    <?php
                    // Example of including a component with data
                    $activity_data = [
                        'activities' => [
                            ['type' => 'profile_view', 'date' => '2025-02-24', 'description' => 'Your profile was viewed 12 times'],
                            ['type' => 'message', 'date' => '2025-02-23', 'description' => 'You received a new message'],
                            ['type' => 'deal', 'date' => '2025-02-22', 'description' => 'New deal opportunity available']
                        ]
                    ];
                    
                    // This would include a component if it exists, or display a default message if not
                    include_component('activity-list', $activity_data, '
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">Profile Views</h5>
                                    <small>Feb 24, 2025</small>
                                </div>
                                <p class="mb-1">Your profile was viewed 12 times</p>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">New Message</h5>
                                    <small>Feb 23, 2025</small>
                                </div>
                                <p class="mb-1">You received a new message</p>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">Deal Opportunity</h5>
                                    <small>Feb 22, 2025</small>
                                </div>
                                <p class="mb-1">New deal opportunity available</p>
                            </div>
                        </div>
                    ');
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer (true = authenticated)
include_footer(true);
?>
