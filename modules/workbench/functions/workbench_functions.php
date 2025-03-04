<?php
/**
 * Workbench Functions
 * 
 * Functions for the workbench module that provide tools for internal use
 * to manage different aspects of the website, schools, users, etc.
 */

/**
 * Get all available workbench tools
 * 
 * @return array Array of workbench tools with their details
 */
function get_workbench_tools() {
    // Define the workbench tools
    $tools = [
        [
            'id' => 'user-management',
            'name' => 'User Management',
            'description' => 'Manage users, roles, and permissions',
            'icon' => 'fa-users',
            'url' => '/workbench?action=user-management',
            'permissions' => ['admin', 'manager']
        ],
        [
            'id' => 'school-management',
            'name' => 'School Management',
            'description' => 'Manage schools, departments, and programs',
            'icon' => 'fa-school',
            'url' => '/workbench?action=school-management',
            'permissions' => ['admin', 'manager']
        ],
        [
            'id' => 'content-management',
            'name' => 'Content Management',
            'description' => 'Manage website content, pages, and media',
            'icon' => 'fa-file-alt',
            'url' => '/workbench?action=content-management',
            'permissions' => ['admin', 'content-editor']
        ],
        [
            'id' => 'system-settings',
            'name' => 'System Settings',
            'description' => 'Configure system settings and preferences',
            'icon' => 'fa-cogs',
            'url' => '/workbench?action=system-settings',
            'permissions' => ['admin']
        ],
        [
            'id' => 'reports',
            'name' => 'Reports & Analytics',
            'description' => 'View and generate reports and analytics',
            'icon' => 'fa-chart-bar',
            'url' => '/workbench?action=reports',
            'permissions' => ['admin', 'manager', 'analyst']
        ],
        [
            'id' => 'logs',
            'name' => 'System Logs',
            'description' => 'View system logs and activity',
            'icon' => 'fa-list',
            'url' => '/workbench?action=logs',
            'permissions' => ['admin', 'developer']
        ]
    ];
    
    return $tools;
}

/**
 * Get workbench tools accessible by the current user
 * 
 * @param int $user_id User ID (optional, defaults to current user)
 * @return array Array of workbench tools accessible by the user
 */
function get_user_workbench_tools($user_id = null) {
    // Get all workbench tools
    $all_tools = get_workbench_tools();
    
    // If no user ID is provided, use the current user
    if ($user_id === null && function_exists('get_current_user_id')) {
        $user_id = get_current_user_id();
    }
    
    // Get user roles (placeholder - implement actual role checking)
    // In a real implementation, this would check the user's roles from the database
    $user_roles = ['admin']; // Placeholder - assume admin for now
    
    // Filter tools based on user permissions
    $user_tools = array_filter($all_tools, function($tool) use ($user_roles) {
        // Check if the user has any of the required permissions
        foreach ($user_roles as $role) {
            if (in_array($role, $tool['permissions'])) {
                return true;
            }
        }
        return false;
    });
    
    return $user_tools;
}