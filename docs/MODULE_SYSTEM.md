# PeakNIL Module System Documentation

This document provides a comprehensive overview of the PeakNIL platform's modular architecture, including the purpose, structure, and functionality of each module.

## Table of Contents

1. [Module System Overview](#module-system-overview)
2. [Module Structure](#module-structure)
3. [Core Modules](#core-modules)
4. [Authentication Modules](#authentication-modules)
5. [User-Facing Modules](#user-facing-modules)
6. [Business Modules](#business-modules)
7. [Experimental Modules](#experimental-modules)
8. [System Modules](#system-modules)
9. [Module Development Guide](#module-development-guide)
10. [Best Practices](#best-practices)

## Module System Overview

The PeakNIL platform follows a procedural modular architecture, where functionality is organized into separate modules. Each module handles a specific aspect of the platform's functionality and is self-contained with its own functions and views.

The modular architecture provides several benefits:
- **Separation of concerns**: Each module focuses on a specific aspect of the platform
- **Code organization**: Code is organized into logical units
- **Maintainability**: Changes to one module don't affect others
- **Scalability**: New modules can be added without modifying existing ones
- **Reusability**: Common functionality can be shared across modules

## Module Structure

Each module follows a standard directory structure:

```
modules/[module_name]/
├── [module_name].php          # Main module file
├── functions/                 # Module-specific functions
│   └── [module_name]_functions.php
└── views/                     # Module views/templates
    └── view.[page_name].php
```

### Main Module File

The main module file (`[module_name].php`) serves as the entry point for the module and handles routing to specific views. It typically includes:

- Required files and configurations
- Authentication checks
- Module-specific logic
- Loading the appropriate view

Example:
```php
<?php
// Include necessary files
require_once CONFIG_PATH . '/init.php';
require_once MODULES_PATH . '/[module_name]/functions/[module_name]_functions.php';

// Check authentication if needed
require_auth();

// Process any module-specific logic

// Load the main view
require_once __DIR__ . '/views/view.[module_name].php';
```

### Functions Directory

The functions directory contains module-specific functions that implement the module's business logic. These functions are typically organized in a file named `[module_name]_functions.php`.

Example:
```php
<?php
/**
 * Get module data from the database
 * 
 * @param mysqli $conn Database connection
 * @param array $params Optional parameters
 * @return array Module data
 */
function get_module_data($conn, $params = []) {
    // Function implementation
}
```

### Views Directory

The views directory contains HTML/PHP templates for the module's user interface. These files are typically named `view.[page_name].php`.

Example:
```php
<?php require_once MODULES_PATH . '/common/views/auth/view.header.php'; ?>

<div class="container">
    <h1>Module Title</h1>
    <!-- Module content -->
</div>

<?php require_once MODULES_PATH . '/common/views/auth/view.footer.php'; ?>
```

## Core Modules

### Common Module

**Path**: `modules/common/`

**Purpose**: Provides shared functionality and views used across the platform.

**Key Components**:
- **Functions**:
  - `array_functions.php`: Array manipulation functions
  - `email_functions.php`: Email sending and logging functions
  - `format_functions.php`: Data formatting functions
  - `notification_functions.php`: User notification functions
  - `security_functions.php`: Security-related functions
  - `sms_functions.php`: SMS messaging functions
  - `utility_functions.php`: General utility functions
  - `validation_functions.php`: Data validation functions
- **Helpers**:
  - `string_helper.php`: String manipulation functions
- **Views**:
  - `auth/`: Views for authenticated pages (header, footer, navigation)
  - `public/`: Views for public pages
  - `common/`: Shared view components
  - `emails/`: Email templates

**Usage**: The common module is used by all other modules for shared functionality and consistent UI components.

### API Module

**Path**: `modules/api/`

**Purpose**: Provides API functionality for programmatic access to the platform.

**Key Components**:
- **Core**: Base classes for API functionality
- **Middleware**: Authentication, rate limiting, and CORS handling
- **V1**: API version 1 endpoints and controllers

**Usage**: The API module is used for integrating with external systems and providing data access to third-party applications.

## Authentication Modules

The authentication system is implemented in the `auth/` directory rather than as a module, but it interacts closely with the module system.

**Path**: `auth/`

**Key Components**:
- **Functions**:
  - `login_functions.php`: User login and session management
  - `password_functions.php`: Password hashing and verification
  - `register_functions.php`: User registration and verification
- **Middleware**:
  - `auth_middleware.php`: Authentication enforcement
- **Views**:
  - `view.login.php`: Login form
  - `view.register.php`: Registration form
  - `view.reset-password.php`: Password reset form
  - `view.verify-email.php`: Email verification page
  - `view.resend-verification.php`: Verification resend page

**Usage**: The authentication system is used for user registration, login, and session management.

## User-Facing Modules

### Dashboard Module

**Path**: `modules/dashboard/`

**Purpose**: Provides the main dashboard for authenticated users.

**Key Components**:
- **Main File**: `dashboard.php`
- **Views**: `view.dashboard.php`

**Usage**: The dashboard module is the main landing page for authenticated users, providing an overview of their account and quick access to key features.

### Profile Module

**Path**: `modules/profile/`

**Purpose**: Manages user profile information and display.

**Key Components**:
- **Main File**: `profile.php`
- **Functions**: `profile_functions.php`
- **Views**: 
  - `view.profile.php`: Profile display
  - `view.edit-profile.php`: Profile editing

**Usage**: The profile module allows users to view and edit their profile information, including personal details, social media links, and profile images.

### Settings Module

**Path**: `modules/settings/`

**Purpose**: Manages user settings and preferences.

**Key Components**:
- **Main File**: `settings.php`
- **Functions**: `settings_functions.php`
- **Views**:
  - `view.settings.php`: Main settings page
  - `view.security.php`: Security settings
  - `view.notifications.php`: Notification preferences

**Usage**: The settings module allows users to manage their account settings, security preferences, and notification options.

### Wallet Module

**Path**: `modules/wallet/`

**Purpose**: Manages user financial information and transactions.

**Key Components**:
- **Main File**: `wallet.php`
- **Functions**: `wallet_functions.php`
- **Views**: `view.wallet.php`

**Usage**: The wallet module allows users to manage their financial information, view transaction history, and perform financial operations.

### Marketplace Module

**Path**: `modules/marketplace/`

**Purpose**: Provides a marketplace for NIL deals and services.

**Key Components**:
- **Main File**: `marketplace.php`
- **Functions**: `marketplace_functions.php`
- **Views**: 
  - `view.marketplace.php`: Main marketplace page
  - `view.service.php`: Service details page

**Usage**: The marketplace module allows users to browse and purchase NIL deals and services.

### Landing Module

**Path**: `modules/landing/`

**Purpose**: Provides public landing pages for the platform.

**Key Components**:
- **Main File**: `landing.php`
- **Functions**: `landing_functions.php`
- **Views**:
  - `view.landing.php`: Main landing page
  - `view.about.php`: About page
  - `view.contact.php`: Contact page
  - `view.services.php`: Services page

**Usage**: The landing module provides public-facing pages for the platform, including the main landing page, about page, contact page, and services page.

### Deals Module

**Path**: `modules/deals/`

**Purpose**: Manages NIL deals between athletes and brands/collectives.

**Key Components**:
- **Main File**: `deals.php`
- **Functions**: `deals_functions.php`
- **Views**:
  - `view.deals.php`: Deals overview
  - `view.deal-details.php`: Deal details page

**Usage**: The deals module allows users to view, create, and manage NIL deals.

## Business Modules

### Brands Module

**Path**: `modules/brands/`

**Purpose**: Manages brand information and relationships.

**Key Components**:
- **Main File**: `brands.php`
- **Functions**: `brands_functions.php`
- **Views**:
  - `view.brands.php`: Brands overview
  - `view.brand-details.php`: Brand details page

**Usage**: The brands module allows users to view and manage brand information and relationships.

### Collectives Module

**Path**: `modules/collectives/`

**Purpose**: Manages NIL collective information and profiles.

**Key Components**:
- **Main File**: `collectives.php`
- **Functions**: `collectives_functions.php`
- **Views**:
  - `view.collectives.php`: Collectives overview
  - `view.collective-details.php`: Collective details page

**Usage**: The collectives module allows users to view and manage NIL collective information and profiles.

## Experimental Modules

### Workbench Module

**Path**: `modules/workbench/`

**Purpose**: Provides development and testing tools.

**Key Components**:
- **Main File**: `workbench.php`
- **Functions**: `workbench_functions.php`
- **Views**: `view.workbench.php`

**Usage**: The workbench module is used by developers for testing and development purposes. It requires special access permissions.

### School Manager Module

**Path**: `modules/school-manager/`

**Purpose**: Manages school information and configurations.

**Key Components**:
- **Main File**: `school-manager.php`
- **Functions**: `school-manager_functions.php`
- **Views**: `view.school-manager.php`

**Usage**: The school manager module allows administrators to manage school information and configurations.

### Parent Portal Module

**Path**: `modules/parent-portal/`

**Purpose**: Provides a portal for parents to manage their children's accounts.

**Key Components**:
- **Main File**: `parent-portal.php`
- **Functions**: `parent-portal_functions.php`
- **Views**: `view.parent-portal.php`

**Usage**: The parent portal module allows parents to manage their children's accounts and monitor their activities.

### Data Services Module

**Path**: `modules/data-services/`

**Purpose**: Provides data management and analysis tools.

**Key Components**:
- **Main File**: `data-services.php`
- **Functions**: `data-services_functions.php`
- **Views**: `view.data-services.php`

**Usage**: The data services module provides tools for data management and analysis.

### Deal Builder Module

**Path**: `modules/deal-builder/`

**Purpose**: Provides tools for creating and managing NIL deals.

**Key Components**:
- **Main File**: `deal-builder.php`
- **Functions**: `deal-builder_functions.php`
- **Views**: `view.deal-builder.php`

**Usage**: The deal builder module allows users to create and manage NIL deals with advanced options.

### Campaign Builder Module

**Path**: `modules/campaign-builder/`

**Purpose**: Provides tools for creating and managing marketing campaigns.

**Key Components**:
- **Main File**: `campaign-builder.php`
- **Functions**: `campaign-builder_functions.php`
- **Views**: `view.campaign-builder.php`

**Usage**: The campaign builder module allows users to create and manage marketing campaigns.

### Recruiting Module

**Path**: `modules/recruiting/`

**Purpose**: Manages athlete recruitment processes.

**Key Components**:
- **Main File**: `recruiting.php`
- **Functions**: `recruiting_functions.php`
- **Views**: `view.recruiting.php`

**Usage**: The recruiting module allows users to manage athlete recruitment processes.

### Agency Module

**Path**: `modules/agency/`

**Purpose**: Manages agency relationships and operations.

**Key Components**:
- **Main File**: `agency.php`
- **Functions**: `agency_functions.php`
- **Views**: `view.agency.php`

**Usage**: The agency module allows users to manage agency relationships and operations.

### Financial Literacy Module

**Path**: `modules/financial-literacy/`

**Purpose**: Provides financial education resources.

**Key Components**:
- **Main File**: `financial-literacy.php`
- **Functions**: `financial-literacy_functions.php`
- **Views**: `view.financial-literacy.php`

**Usage**: The financial literacy module provides financial education resources for users.

### Messenger Module

**Path**: `modules/messenger/`

**Purpose**: Provides messaging functionality between users.

**Key Components**:
- **Main File**: `messenger.php`
- **Functions**: `messenger_functions.php`
- **Views**: `view.messenger.php`

**Usage**: The messenger module allows users to send and receive messages.

### Favorites Module

**Path**: `modules/favorites/`

**Purpose**: Manages user favorites and bookmarks.

**Key Components**:
- **Main File**: `favorites.php`
- **Functions**: `favorites_functions.php`
- **Views**: `view.favorites.php`

**Usage**: The favorites module allows users to save and manage their favorite items.

## System Modules

### Test Module

**Path**: `modules/test/`

**Purpose**: Provides testing functionality for development.

**Key Components**:
- **Main File**: `test.php`
- **Functions**: `test_functions.php`
- **Views**: `view.test.php`

**Usage**: The test module is used for development and testing purposes.

## Module Development Guide

### Creating a New Module

To create a new module, follow these steps:

1. **Create the module directory structure**:
   ```
   modules/[module_name]/
   ├── [module_name].php
   ├── functions/
   │   └── [module_name]_functions.php
   └── views/
       └── view.[module_name].php
   ```

2. **Create the main module file**:
   ```php
   <?php
   // Include necessary files
   require_once CONFIG_PATH . '/init.php';
   require_once MODULES_PATH . '/[module_name]/functions/[module_name]_functions.php';

   // Check authentication if needed
   require_auth();

   // Process any module-specific logic

   // Load the main view
   require_once __DIR__ . '/views/view.[module_name].php';
   ```

3. **Create the functions file**:
   ```php
   <?php
   /**
    * Get module data from the database
    * 
    * @param mysqli $conn Database connection
    * @param array $params Optional parameters
    * @return array Module data
    */
   function get_module_data($conn, $params = []) {
       // Function implementation
   }
   ```

4. **Create the view file**:
   ```php
   <?php require_once MODULES_PATH . '/common/views/auth/view.header.php'; ?>

   <div class="container">
       <h1>Module Title</h1>
       <!-- Module content -->
   </div>

   <?php require_once MODULES_PATH . '/common/views/auth/view.footer.php'; ?>
   ```

5. **Add the module to the router**:
   Open `public/index.php` and add a new case to the main routing switch statement:
   ```php
   case '[module_name]':
       // Optional: Require authentication
       require_auth();
       require_once MODULES_PATH . '/[module_name]/[module_name].php';
       break;
   ```

6. **Create module assets**:
   ```
   public/assets/modules/[module_name]/
   ├── css/
   │   └── [module_name].css
   └── js/
       └── [module_name].js
   ```

### Module Testing

After creating a new module, test it thoroughly:

1. Test the routing at `http://localhost:8888/[module_name]`
2. Verify all functions work as expected
3. Test authentication if implemented
4. Validate asset loading
5. Test any database interactions

## Best Practices

### Naming Conventions

- Use lowercase for module names
- Prefix functions with module name to avoid conflicts
- Use descriptive view names

### File Organization

- Keep module files self-contained within their directory
- Use subdirectories for complex modules
- Organize views logically

### Code Structure

- Include necessary files at the top
- Handle authentication early
- Process logic before loading views
- Keep views focused on presentation

### Security

- Always validate user input
- Use prepared statements for queries
- Apply appropriate authentication checks
- Implement CSRF protection for forms

### Performance

- Optimize database queries
- Cache frequently accessed data
- Minimize external dependencies
- Use efficient algorithms and data structures

### Maintainability

- Document your code with comments
- Follow consistent coding standards
- Write modular, reusable functions
- Keep functions small and focused

### Testing

- Test all module functionality
- Verify error handling
- Test edge cases
- Ensure proper validation
