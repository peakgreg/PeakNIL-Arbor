# Universal File Inclusion System

## Overview

This document describes the implementation of a universal file inclusion system that provides robust fallback mechanisms for including files across all modules. This system addresses the path resolution issues in both development and production environments and provides a centralized approach to file inclusion.

## Problem Statement

The application was experiencing issues with file inclusion in the production environment due to differences in directory structure between development and production:

- In development, files are organized in a standard directory structure
- In production, files in `/public` are uploaded to `/var/www/html` and everything else to `/var/www`

This led to path resolution issues when including files, resulting in "file not found" errors.

## Solution

We implemented a universal file inclusion system with the following components:

1. **Core Inclusion Function**: A central `include_with_fallback` function that tries multiple paths and provides graceful degradation
2. **Path Generation**: A `generate_fallback_paths` function that creates a list of possible paths for a file
3. **Helper Functions**: Specialized functions for common includes like headers, footers, and components
4. **Default Content**: Fallback HTML content when files cannot be found

The system is implemented in `modules/common/functions/include_functions.php` and can be used across all modules.

## Implementation Details

### 1. Core Functions

#### include_with_fallback

This function is the heart of the system. It tries to include a file from a primary path, and if that fails, it tries a series of fallback paths. If all paths fail, it displays default content.

```php
function include_with_fallback($primary_path, $fallback_paths = [], $required = false, $default_content = '') {
    // Try primary path
    if (file_exists($primary_path)) {
        $required ? require_once $primary_path : include $primary_path;
        return true;
    }
    
    // Try fallback paths
    foreach ($fallback_paths as $path) {
        if (file_exists($path)) {
            $required ? require_once $path : include $path;
            return true;
        }
    }
    
    // Display default content if no file found
    if (!empty($default_content)) {
        echo $default_content;
    }
    
    return false;
}
```

#### generate_fallback_paths

This function generates a list of possible paths for a file, including:
- Absolute paths for production
- Relative paths based on the current file
- Cross-directory fallbacks (e.g., try public version if auth version not found)
- Backup file versions

```php
function generate_fallback_paths($file_path, $file_name) {
    $fallbacks = [];
    
    // Add absolute paths for production
    $fallbacks[] = '/var/www' . str_replace(ROOT_PATH, '', $file_path);
    $fallbacks[] = '/var/www/html' . str_replace(ROOT_PATH, '', $file_path);
    
    // Add more fallback paths...
    
    return $fallbacks;
}
```

### 2. Helper Functions

#### include_header and include_footer

These functions include the appropriate header or footer based on authentication status:

```php
function include_header($is_authenticated = false) {
    $type = $is_authenticated ? 'auth' : 'public';
    $file_name = 'view.header.php';
    $primary_path = MODULES_PATH . '/common/views/' . $type . '/' . $file_name;
    
    $fallback_paths = generate_fallback_paths($primary_path, $file_name);
    
    // Default minimal header if no file found
    $default_header = '...'; // Minimal HTML header
    
    return include_with_fallback($primary_path, $fallback_paths, false, $default_header);
}
```

#### include_component

This function includes a component with data:

```php
function include_component($component_name, $data = [], $default_content = '') {
    // Extract data into the current scope
    if (!empty($data) && is_array($data)) {
        extract($data);
    }
    
    $file_name = 'view.' . $component_name . '.php';
    $primary_path = MODULES_PATH . '/common/views/common/' . $file_name;
    
    $fallback_paths = generate_fallback_paths($primary_path, $file_name);
    
    return include_with_fallback($primary_path, $fallback_paths, false, $default_content);
}
```

#### include_module_view

This function includes a view from a specific module:

```php
function include_module_view($module_name, $view_name, $data = [], $default_content = '') {
    // Extract data into the current scope
    if (!empty($data) && is_array($data)) {
        extract($data);
    }
    
    $file_name = 'view.' . $view_name . '.php';
    $primary_path = MODULES_PATH . '/' . $module_name . '/views/' . $file_name;
    
    $fallback_paths = generate_fallback_paths($primary_path, $file_name);
    
    return include_with_fallback($primary_path, $fallback_paths, false, $default_content);
}
```

### 3. Usage Examples

#### Basic Usage in Views

```php
// Include the file inclusion helper functions
require_once MODULES_PATH . '/common/functions/include_functions.php';

// Include header based on authentication status
include_header(isset($_SESSION['uuid']));

// Your content here

// Include footer based on authentication status
include_footer(isset($_SESSION['uuid']));
```

#### Including Components with Data

```php
// Example of including a component with data
$activity_data = [
    'activities' => [
        ['type' => 'profile_view', 'date' => '2025-02-24', 'description' => 'Your profile was viewed 12 times'],
        // More activities...
    ]
];

// Include the component with data and a fallback
include_component('activity-list', $activity_data, '<div>Default activity list</div>');
```

## Benefits

1. **Centralized Logic**: All file inclusion logic is in one place, making it easier to maintain
2. **Consistent Fallbacks**: Every view gets the same robust fallback mechanisms
3. **Graceful Degradation**: Default minimal content when files can't be found
4. **Easy to Extend**: New helper functions can be added for other common includes
5. **Environment Agnostic**: Works in both development and production environments
6. **Simplified Views**: View files are cleaner and more focused on content

## Future Considerations

1. **Caching**: Add caching for file existence checks to improve performance
2. **Configuration**: Allow configuration of fallback paths and default content
3. **Error Reporting**: Enhance error reporting and logging for better debugging
4. **Template Engine**: Consider integrating with a template engine for more advanced features

## Conclusion

The universal file inclusion system provides a robust solution for including files across all modules in both development and production environments. It addresses the path resolution issues and provides graceful degradation when files cannot be found.

By using this system, developers can focus on creating content without worrying about file inclusion issues, and the application becomes more resilient to missing files and path resolution problems.
