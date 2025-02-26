# Module Creation Guide

This guide explains how to create new modules for the platform, including required files, directory structure, and router configuration.

## Module Structure

Each module must follow this standard directory structure:

```
modules/[module_name]/
├── [module_name].php          # Main module file
├── functions/                 # Module-specific functions
│   └── [module_name]_functions.php
└── views/                     # Module views/templates
    └── view.[page_name].php
```

### Required Files

1. **Main Module File** (`[module_name].php`):
   - Entry point for the module
   - Includes necessary configurations and functions
   - Handles routing to specific views
   - Example structure:
   ```php
   <?php
   require_once CONFIG_PATH . '/init.php';
   require_once MODULES_PATH . '/[module_name]/functions/[module_name]_functions.php';

   // Optional: Require authentication
   // require_auth();

   // Process any module-specific logic

   // Load the main view
   require_once __DIR__ . '/views/view.[module_name].php';
   ```

2. **Functions File** (`functions/[module_name]_functions.php`):
   - Contains module-specific functions
   - Follows naming convention: `functionName()`
   - Example:
   ```php
   <?php
   function getModuleData($conn, $params = []) {
       // Function implementation
   }
   ```

3. **View Files** (`views/view.[page_name].php`):
   - Contains HTML/PHP templates
   - Naming convention: `view.[page_name].php`
   - Can include multiple views for different pages/components

## Asset Organization

Module assets must be organized in the public directory:

```
html/assets/modules/[module_name]/
├── css/
│   └── [module_name].css
└── js/
    └── [module_name].js
```

## Router Configuration

To add a new module to the platform:

1. Open `html/index.php`
2. Add a new case to the main routing switch statement:
   ```php
   case '[module_name]':
       // Optional: Require authentication
       // require_auth();
       require_once MODULES_PATH . '/[module_name]/[module_name].php';
       break;
   ```

## Authentication

Modules can be:
- Public (no authentication required)
- Protected (requires authentication)

To make a module protected, add `require_auth();` at the start of the main module file or in the router case.

Example:
```php
case 'protected_module':
    require_auth();
    require_once MODULES_PATH . '/protected_module/protected_module.php';
    break;
```

## Best Practices

1. **Naming Conventions**:
   - Use lowercase for module names
   - Prefix functions with module name to avoid conflicts
   - Use descriptive view names

2. **File Organization**:
   - Keep module files self-contained within their directory
   - Use subdirectories for complex modules
   - Organize views logically

3. **Code Structure**:
   - Include necessary files at the top
   - Handle authentication early
   - Process logic before loading views
   - Keep views focused on presentation

4. **Security**:
   - Always validate user input
   - Use prepared statements for queries
   - Apply appropriate authentication checks

## Example: Creating a New Module

Here's an example of creating a "blog" module:

1. Create directory structure:
   ```
   modules/blog/
   ├── blog.php
   ├── functions/
   │   └── blog_functions.php
   └── views/
       ├── view.blog.php
       └── view.post.php
   ```

2. Create main module file (`blog.php`):
   ```php
   <?php
   require_once CONFIG_PATH . '/init.php';
   require_once MODULES_PATH . '/blog/functions/blog_functions.php';

   // Get posts
   $posts = getBlogPosts($conn);

   // Load view
   require_once __DIR__ . '/views/view.blog.php';
   ```

3. Create functions file (`blog_functions.php`):
   ```php
   <?php
   function getBlogPosts($conn) {
       // Implementation
   }
   ```

4. Update router in `html/index.php`:
   ```php
   case 'blog':
       require_once MODULES_PATH . '/blog/blog.php';
       break;
   ```

5. Create assets:
   ```
   html/assets/modules/blog/
   ├── css/
   │   └── blog.css
   └── js/
   └── blog.js
   ```

## Testing

After creating a new module:
1. Test the routing at `http://localhost:8000/[module_name]`
2. Verify all functions work as expected
3. Test authentication if implemented
4. Validate asset loading
5. Test any database interactions

## Common Issues

1. **404 Errors**: Check router configuration in `html/index.php`
2. **Missing Functions**: Verify all required files are included
3. **Authentication Issues**: Ensure `require_auth()` is properly placed
4. **Asset Loading**: Confirm correct paths in html/assets
