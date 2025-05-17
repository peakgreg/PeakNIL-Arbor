# PeakNIL Platform Overview

This document provides a comprehensive overview of the PeakNIL platform architecture, components, and functionality. It serves as a reference for understanding the platform's structure and features.

## Table of Contents

1. [Platform Architecture](#platform-architecture)
2. [Authentication System](#authentication-system)
3. [Database Structure](#database-structure)
4. [Module System](#module-system)
5. [Security Features](#security-features)
6. [Email System](#email-system)
7. [API System](#api-system)
8. [Routing System](#routing-system)
9. [Frontend Structure](#frontend-structure)
10. [Deployment](#deployment)
11. [Recent Changes](#recent-changes)
12. [Planned Improvements](#planned-improvements)

## Platform Architecture

The PeakNIL platform follows a procedural modular architecture with the following key components:

- **Config**: Contains configuration files for the platform, including database connection, session management, and constants.
- **Modules**: Contains the platform's functionality organized into separate modules.
- **Auth**: Handles user authentication, registration, and session management.
- **Public**: Contains publicly accessible files and assets.
- **Database**: Contains database schema and relationship definitions.
- **Docs**: Contains documentation files.

The platform uses a PHP-based backend with a MySQL database. It follows a procedural programming paradigm with a modular structure, where each module handles a specific aspect of the platform's functionality.

## Authentication System

The authentication system provides the following features:

- User registration with email verification
- Login with email/password
- Password reset functionality
- Session management with timeout
- Remember me functionality
- Logout capability
- Email verification resend option

Key authentication files:
- `auth/login.php`: Handles user login
- `auth/register.php`: Handles user registration
- `auth/logout.php`: Handles user logout
- `auth/reset-password.php`: Handles password reset
- `auth/verify-email.php`: Handles email verification
- `auth/resend-verification.php`: Handles resending verification emails
- `auth/functions/login_functions.php`: Contains login-related functions
- `auth/functions/register_functions.php`: Contains registration-related functions
- `auth/functions/password_functions.php`: Contains password-related functions
- `auth/middleware/auth_middleware.php`: Contains authentication middleware

The authentication system uses Bcrypt for password hashing and implements security measures like session regeneration, CSRF protection, and rate limiting for login attempts.

## Database Structure

The database consists of multiple tables organized around the following key entities:

- **Users**: Core user information and authentication details
- **User Profiles**: Detailed user profile information
- **User Flags**: User account flags and system statuses
- **User Metadata**: Additional user information and preferences
- **User Addresses**: User address information
- **User Social Media**: User social media account information
- **Activity Log**: Comprehensive activity logging system
- **Login Attempts**: Tracks user login attempts and security details
- **Verification Attempts**: Tracks user verification attempts and security details
- **Email Log**: Tracks email communication history
- **Banned Users**: Tracks banned users and ban details
- **API Keys**: Manages API keys for secure third-party access
- **Assets**: Comprehensive asset management system
- **Brands**: Stores information about brands/companies
- **Brands Users**: Manages relationships between brands and users
- **Collectives**: Manages NIL collectives information and profiles
- **Collectives Users**: Manages relationships between collectives and users
- **Deals**: Manages NIL deals between athletes and brands/collectives
- **Schools**: Manages school information and configurations
- **Sports**: Manages sport information and configurations
- **Positions**: Manages sport positions and abbreviations
- **Roles**: Manages different user roles
- **Levels**: Manages different user access levels

The database uses a relational model with relationships defined in the `database/relationships.json` file. The platform does not use FOREIGN KEY constraints, assuming PlanetScale as the database, and manages referential integrity through application code.

## Module System

The platform follows a modular architecture with each module handling a specific aspect of the platform's functionality. Each module follows a standard directory structure:

```
modules/[module_name]/
├── [module_name].php          # Main module file
├── functions/                 # Module-specific functions
│   └── [module_name]_functions.php
└── views/                     # Module views/templates
    └── view.[page_name].php
```

Key modules include:

- **Dashboard**: User dashboard and overview
- **Profile**: User profile management
- **Settings**: User settings management
- **Wallet**: Financial management
- **Deals**: NIL deal management
- **Marketplace**: Public marketplace
- **Landing**: Public landing pages
- **API**: API functionality
- **Common**: Shared functionality and views
- **Experimental Modules**:
  - Workbench: Development and testing
  - School Manager: School management
  - Parent Portal: Parent management
  - Data Services: Data management
  - Collectives: NIL collective management
  - Deal Builder: Deal creation
  - Campaign Builder: Campaign management
  - Recruiting: Recruitment management
  - Agency: Agency management
  - Financial Literacy: Financial education
  - Messenger: Communication system
  - Favorites: Favorite management

Each module is self-contained and includes its own functions and views. The main module file serves as the entry point and handles routing to specific views.

## Security Features

The platform implements various security features:

- **Password Security**:
  - Bcrypt password hashing
  - Password complexity requirements
  - Password rehashing when needed

- **CSRF Protection**:
  - CSRF token generation
  - CSRF validation for forms

- **Session Security**:
  - Session timeout mechanism
  - Session fixation protection
  - Session regeneration

- **XSS Protection**:
  - Input sanitization
  - Output escaping
  - Content Security Policy headers

- **Login Security**:
  - Login attempt tracking
  - Account lockout after failed attempts
  - IP-based login restrictions

- **Security Headers**:
  - Content-Security-Policy
  - X-Content-Type-Options
  - X-Frame-Options
  - X-XSS-Protection
  - Referrer-Policy

Security functions are primarily located in `modules/common/functions/security_functions.php`.

## Email System

The platform includes a comprehensive email system with the following features:

- Template-based emails
- Basic plain text emails
- HTML emails with alternative text
- Emails with attachments
- Email logging

Key email functions:
- `send_template_email()`: Sends an email using a template
- `send_email()`: Sends a basic email
- `send_html_email()`: Sends an HTML email
- `send_email_with_attachments()`: Sends an email with attachments
- `log_email()`: Logs email attempts to the database

The email system uses PHPMailer for sending emails and supports SMTP configuration. Email functions are located in `modules/common/functions/email_functions.php`.

## API System

The PeakNIL API provides programmatic access to platform data and functionality. It follows REST principles, uses JSON for data formatting, and implements secure authentication via API keys.

Key API features:
- API key authentication
- Rate limiting
- CORS protection
- Input validation
- Standardized error responses

The API follows a clean MVC architecture:
1. **Controllers**: Handle HTTP requests and responses
2. **Services**: Implement business logic
3. **Models**: Handle database interactions
4. **DTOs**: Format responses
5. **Middleware**: Handle authentication, rate limiting, and CORS

API endpoints include:
- `/api/v1/profile`: Retrieves user profile information
- `/api/v1/school`: Retrieves school information

The API is located in the `modules/api` directory.

## Routing System

The platform uses a simple routing system based on the URL path. The main routing logic is located in `public/index.php`.

The routing system handles:
- Public routes (landing pages, about, contact, etc.)
- Authentication routes (login, register, logout, etc.)
- Protected routes (dashboard, settings, profile, etc.)
- Error routes (404, 500, maintenance)

Protected routes require authentication, which is enforced by the `require_auth()` function in `auth/middleware/auth_middleware.php`.

## Frontend Structure

The frontend uses a combination of PHP templates, CSS, and JavaScript. Key frontend components include:

- **Header**: Contains the HTML head section with meta tags, CSS links, and other head elements
- **Footer**: Contains JavaScript includes and closing HTML tags
- **Navigation**: Contains the main navigation menu and sidebar
- **Views**: Contains the HTML templates for each page

The platform uses Bootstrap for styling and includes custom CSS for additional styling. JavaScript is used for interactive elements and AJAX requests.

## Deployment

The platform is deployed on an EC2 PHP-Apache server with the following configuration:

- Apache web server
- PHP 8.2
- MySQL database (PlanetScale)
- SSL/TLS for secure connections

The deployment process involves:
1. Setting up the server with Apache and PHP
2. Configuring the directory structure
3. Setting up permissions
4. Configuring security groups
5. Deploying the application code

In production, everything in the `/public` directory is uploaded to `/var/www/html`, and everything outside of `/public` is uploaded to `/var/www`.

## Recent Changes

Recent changes to the platform include:

- Updated NIL services filter UI to dropdown style
- Added customizable image height for service cards
- Enhanced service card styling
- Optimized service card heights
- Converted registration functions to mysqli
- Improved error handling and logging
- Fixed SQL syntax errors
- Updated email verification process to use mysqli

## Planned Improvements

Planned improvements for the platform include:

- **Security Enhancements**:
  - Two-factor authentication
  - Password security improvements
  - Login security enhancements
  - Session security improvements
  - Rate limiting

- **Feature Enhancements**:
  - Account activity tracking
  - User management improvements
  - Security header implementations

- **Monitoring & Logging**:
  - Security monitoring
  - Logging improvements

- **Documentation**:
  - Security documentation
  - User documentation

- **Other Improvements**:
  - Crawler detection
  - Custom email validation
  - Color extraction from images
  - AI agent integration
  - SEO improvements
