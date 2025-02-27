# Module Creation Guide

This guide explains how to create new modules for the platform, including required files, directory structure, and router configuration.

  - Ask the user to specify the name of the module.
  - Ask the user to specify the pages for the views and generate them in the
    `modules/[module_name]/views/` directory.
  - Naming convention for view pages: `view.[page_name].php`
  - Can include multiple views for different pages/components
  - Ask if the module will be public or private.
  - If the user requests that this page be 'private' or 'viewable only when 
    logged in' or an 'authentication page' or 'only visible when logged in' add 
    `require_auth();` to the router.


## Module Structure

Each module must follow this standard directory structure:

```
modules/[module_name]/
├── [module_name].php          # Main module file
├── functions/                 # Module-specific functions
│   └── [module_name]_functions.php
└── views/                     # Module views/templates
    ├── view.[page_name].php
    ├── view.[page_name].php
    └── view.[module_name].php
```

### Required Files
1. **Main Module File** (`[module_name].php`):
   - Entry point for the module
   - Includes necessary configurations and functions
   - Handles routing to specific views

    ```php
    <?php
    require_once CONFIG_PATH . '/init.php';
    require_once MODULES_PATH . '/[module_name]/functions/[module_name]_functions.php';
    global $db;

    // Optional: Require authentication
    // require_auth();

    // Process any module-specific logic

    // Load the view
    // Load the appropriate view
    $page = $_GET['view'] ?? '[module_name]';

    switch($page) {
      case '[page_name]':
          require_once MODULES_PATH . '/[module_name]/views/view.demo-page.php';
          break;
          
      case '[module_name]':
      default:
          require_once MODULES_PATH . '/[module_name]/views/view.[module_name].php';
          break;
    }
    ```

1. **Module View File** (`view.[page_name].php` or `view.[module_name].php`):

    - View file if page is protected.
    ```php
    <?php require_once MODULES_PATH . '/common/views/auth/view.header.php'; ?>
    <link rel="stylesheet" href="/assets/modules/[module_name]/css/[module_name].css">

    [module_name] or [page_name]

    <script type="text/javascript" src="/assets/modules/[module_name]/js/[module_name].js"></script>
    <?php require_once MODULES_PATH . '/common/views/auth/view.footer.php'; ?>
    ```

    - View file if page is public.
    ```php
    <?php require_once MODULES_PATH . '/common/views/public/view.header.php'; >
    <link rel="stylesheet" href="/assets/modules/[module_name]/css/[module_name].css">

    [module_name] or [page_name]

    <script type="text/javascript" src="/assets/modules/[module_name]/js/[module_name].js"></script>
    <?php require_once MODULES_PATH . '/common/views/public/view.footer.php'; >
    ```


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

To add a new module to the platform, if it is public.

1. Open `html/index.php`

2. Add a new case to the main routing switch statement. Do not remove anything, just amend the file:
    ```php
    case '[module_name]':
        require_once MODULES_PATH . '/[module_name]/[module_name].php';
        break;
    ```

or if protected.

2. To make a module protected, add `require_auth();` at the start of the main module file or in the router case.
Do not remove anything, just amend the file:

    ```php
    case '[module_name]':
        require_auth();
        require_once MODULES_PATH . '/[module_name]/[module_name].php';
        break;
    ```

## Best Practices

1. **Naming Conventions**:
   - Use lowercase for module names