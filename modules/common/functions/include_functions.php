<?php
/**
 * File Inclusion Helper Functions
 * 
 * This file contains functions for including files with robust fallback mechanisms.
 * It provides a centralized approach to file inclusion that works across all modules
 * and handles both development and production environments.
 */

/**
 * Include a file with fallback options
 * 
 * @param string $primary_path Primary path to the file
 * @param array $fallback_paths Array of fallback paths to try if primary path fails
 * @param bool $required Whether to throw an error if file not found
 * @param string $default_content HTML content to display if file not found
 * @return bool Whether the file was successfully included
 */
function include_with_fallback($primary_path, $fallback_paths = [], $required = false, $default_content = '') {
    // Log the primary path
    error_log('Attempting to include file: ' . $primary_path);
    
    // Try primary path first
    if (file_exists($primary_path)) {
        error_log('SUCCESS: File found at: ' . $primary_path);
        $required ? require_once $primary_path : include $primary_path;
        return true;
    }
    
    // Try fallback paths
    foreach ($fallback_paths as $path) {
        error_log('Trying fallback path: ' . $path);
        if (file_exists($path)) {
            error_log('SUCCESS: File found at fallback path: ' . $path);
            $required ? require_once $path : include $path;
            return true;
        }
    }
    
    // If we get here, no file was found
    error_log('WARNING: File not found at any location. Primary: ' . $primary_path);
    
    // Log all attempted paths for debugging
    error_log('Attempted paths: ' . $primary_path . ', ' . implode(', ', $fallback_paths));
    
    // Output default content if provided
    if (!empty($default_content)) {
        echo $default_content;
    } elseif ($required) {
        // If required and no default content, throw an error
        trigger_error('Required file not found: ' . $primary_path, E_USER_ERROR);
    }
    
    return false;
}

/**
 * Generate common fallback paths for a file
 * 
 * @param string $file_path Original file path
 * @param string $file_name File name without path
 * @return array Array of possible fallback paths
 */
function generate_fallback_paths($file_path, $file_name) {
    $fallbacks = [];
    
    // Add absolute paths for production
    $fallbacks[] = '/var/www' . str_replace(ROOT_PATH, '', $file_path);
    $fallbacks[] = '/var/www/html' . str_replace(ROOT_PATH, '', $file_path);
    
    // Add path based on dirname
    $fallbacks[] = dirname($file_path) . '/' . $file_name;
    
    // Try to find the file in common directories
    if (strpos($file_path, '/auth/') !== false) {
        // Try public version if auth version not found
        $fallbacks[] = str_replace('/auth/', '/public/', $file_path);
        $fallbacks[] = '/var/www' . str_replace([ROOT_PATH, '/auth/'], ['', '/public/'], $file_path);
    } elseif (strpos($file_path, '/public/') !== false) {
        // Try auth version if public version not found
        $fallbacks[] = str_replace('/public/', '/auth/', $file_path);
        $fallbacks[] = '/var/www' . str_replace([ROOT_PATH, '/public/'], ['', '/auth/'], $file_path);
    }
    
    // Try common directory
    $fallbacks[] = MODULES_PATH . '/common/views/common/' . $file_name;
    $fallbacks[] = '/var/www/modules/common/views/common/' . $file_name;
    
    // Try backup files (e.g., view.nav.bak.php)
    $file_name_parts = pathinfo($file_name);
    if (isset($file_name_parts['filename']) && isset($file_name_parts['extension'])) {
        $backup_file_name = $file_name_parts['filename'] . '.bak.' . $file_name_parts['extension'];
        $fallbacks[] = dirname($file_path) . '/' . $backup_file_name;
        $fallbacks[] = '/var/www' . str_replace(ROOT_PATH, '', dirname($file_path)) . '/' . $backup_file_name;
    }
    
    return $fallbacks;
}

/**
 * Include header based on authentication status
 * 
 * @param bool $is_authenticated Whether the user is authenticated
 * @return bool Whether the header was successfully included
 */
function include_header($is_authenticated = false) {
    $type = $is_authenticated ? 'auth' : 'public';
    $file_name = 'view.header.php';
    $primary_path = MODULES_PATH . '/common/views/' . $type . '/' . $file_name;
    
    $fallback_paths = generate_fallback_paths($primary_path, $file_name);
    
    // Default minimal header if no file found
    $default_header = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PeakNIL</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div style="background:#f8f8f8;padding:15px;margin-bottom:20px;">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div><strong>PeakNIL</strong></div>
            <div>
                ' . ($is_authenticated ? 
                '<a href="/marketplace" style="margin-right:15px;text-decoration:none;color:#333;">Marketplace</a>
                <a href="/profile" style="margin-right:15px;text-decoration:none;color:#333;">Profile</a>
                <a href="/logout" style="text-decoration:none;color:#333;">Logout</a>' : 
                '<a href="/" style="margin-right:15px;text-decoration:none;color:#333;">Home</a>
                <a href="/login" style="text-decoration:none;color:#333;">Login</a>') . '
            </div>
        </div>
    </div>
    <main class="container py-4">
    ';
    
    return include_with_fallback($primary_path, $fallback_paths, false, $default_header);
}

/**
 * Include footer based on authentication status
 * 
 * @param bool $is_authenticated Whether the user is authenticated
 * @return bool Whether the footer was successfully included
 */
function include_footer($is_authenticated = false) {
    $type = $is_authenticated ? 'auth' : 'public';
    $file_name = 'view.footer.php';
    $primary_path = MODULES_PATH . '/common/views/' . $type . '/' . $file_name;
    
    $fallback_paths = generate_fallback_paths($primary_path, $file_name);
    
    // Default minimal footer if no file found
    $default_footer = '
    </main>
    <footer class="bg-light py-3 mt-5">
        <div class="container text-center">
            <p>&copy; ' . date('Y') . ' PeakNIL. All rights reserved.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    ';
    
    return include_with_fallback($primary_path, $fallback_paths, false, $default_footer);
}

/**
 * Include navigation based on authentication status
 * 
 * @param bool $is_authenticated Whether the user is authenticated
 * @return bool Whether the navigation was successfully included
 */
function include_navigation($is_authenticated = false) {
    $type = $is_authenticated ? 'auth' : 'public';
    $file_name = 'view.nav.php';
    $primary_path = MODULES_PATH . '/common/views/' . $type . '/' . $file_name;
    
    $fallback_paths = generate_fallback_paths($primary_path, $file_name);
    
    // Default minimal navigation if no file found
    $default_nav = '
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">PeakNIL</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    ' . ($is_authenticated ? 
                    '<li class="nav-item"><a class="nav-link" href="/marketplace">Marketplace</a></li>
                    <li class="nav-item"><a class="nav-link" href="/profile">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>' : 
                    '<li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>') . '
                </ul>
            </div>
        </div>
    </nav>
    ';
    
    return include_with_fallback($primary_path, $fallback_paths, false, $default_nav);
}

/**
 * Include a module view with fallback options
 * 
 * @param string $module_name Name of the module
 * @param string $view_name Name of the view without 'view.' prefix and '.php' suffix
 * @param array $data Data to extract into the view's scope
 * @param string $default_content HTML content to display if view not found
 * @return bool Whether the view was successfully included
 */
function include_module_view($module_name, $view_name, $data = [], $default_content = '') {
    // Extract data into the current scope
    if (!empty($data) && is_array($data)) {
        extract($data);
    }
    
    $file_name = 'view.' . $view_name . '.php';
    $primary_path = MODULES_PATH . '/' . $module_name . '/views/' . $file_name;
    
    $fallback_paths = generate_fallback_paths($primary_path, $file_name);
    
    // Add common module views as fallbacks
    $fallback_paths[] = MODULES_PATH . '/common/views/' . $file_name;
    $fallback_paths[] = '/var/www/modules/common/views/' . $file_name;
    
    // Default content if view not found
    if (empty($default_content)) {
        $default_content = '
        <div class="alert alert-warning">
            <h4>View Not Found</h4>
            <p>The requested view "' . htmlspecialchars($view_name) . '" in module "' . htmlspecialchars($module_name) . '" could not be found.</p>
        </div>
        ';
    }
    
    return include_with_fallback($primary_path, $fallback_paths, false, $default_content);
}

/**
 * Include a component with fallback options
 * 
 * @param string $component_name Name of the component without 'view.' prefix and '.php' suffix
 * @param array $data Data to extract into the component's scope
 * @param string $default_content HTML content to display if component not found
 * @return bool Whether the component was successfully included
 */
function include_component($component_name, $data = [], $default_content = '') {
    // Extract data into the current scope
    if (!empty($data) && is_array($data)) {
        extract($data);
    }
    
    $file_name = 'view.' . $component_name . '.php';
    $primary_path = MODULES_PATH . '/common/views/common/' . $file_name;
    
    $fallback_paths = generate_fallback_paths($primary_path, $file_name);
    
    // Default content if component not found
    if (empty($default_content)) {
        $default_content = '<!-- Component not found: ' . htmlspecialchars($component_name) . ' -->';
    }
    
    return include_with_fallback($primary_path, $fallback_paths, false, $default_content);
}
