# PeakNIL Platform Documentation Index

This document serves as a central reference point for all PeakNIL platform documentation. It provides links to detailed documentation on various aspects of the platform, including architecture, database schema, module system, security features, API system, and more.

## Core Documentation

| Document | Description |
|----------|-------------|
| [Platform Overview](PLATFORM_OVERVIEW.md) | Comprehensive overview of the PeakNIL platform architecture, components, and functionality |
| [Database Schema](DATABASE_SCHEMA.md) | Detailed documentation of the database schema, including table structures and relationships |
| [Module System](MODULE_SYSTEM.md) | Documentation of the modular architecture, including module structure and functionality |
| [Security Features](SECURITY_FEATURES.md) | Overview of security features implemented in the platform |
| [API System](API_SYSTEM.md) | Documentation of the API system, including endpoints, authentication, and usage examples |
| [Server Configuration](SERVER.md) | Guide for setting up and configuring the server environment |

## Additional Documentation

| Document | Description |
|----------|-------------|
| [README](README.md) | Basic setup instructions and terminal commands |
| [CHANGELOG](CHANGELOG.md) | History of changes to the platform |
| [TODO](TODO.md) | Planned improvements and features |
| [MODULES](MODULES.md) | Guide for creating new modules |
| [API](API.md) | API documentation and usage examples |
| [SECURITY](SECURITY.md) | Security analysis and checklist |
| [TERMINAL_COMMANDS](TERMINAL_COMMANDS.md) | Common terminal commands for managing the platform |

## Module-Specific Documentation

The platform includes various modules, each with its own functionality:

- **Core Modules**
  - Common Module: Shared functionality and views
  - API Module: API functionality

- **Authentication Modules**
  - Login
  - Registration
  - Password Reset
  - Email Verification

- **User-Facing Modules**
  - Dashboard Module: User dashboard
  - Profile Module: User profile management
  - Settings Module: User settings management
  - Wallet Module: Financial management
  - Marketplace Module: NIL deals and services
  - Landing Module: Public landing pages
  - Deals Module: NIL deal management

- **Business Modules**
  - Brands Module: Brand management
  - Collectives Module: NIL collective management

- **Experimental Modules**
  - Workbench Module: Development and testing
  - School Manager Module: School management
  - Parent Portal Module: Parent management
  - Data Services Module: Data management
  - Deal Builder Module: Deal creation
  - Campaign Builder Module: Campaign management
  - Recruiting Module: Recruitment management
  - Agency Module: Agency management
  - Financial Literacy Module: Financial education
  - Messenger Module: Communication system
  - Favorites Module: Favorite management

## Database Structure

The database consists of multiple tables organized around the following key entities:

- **Users and Authentication**
  - Users
  - Roles
  - Levels
  - Login Attempts
  - Verification Attempts
  - Banned Users

- **Profile and Metadata**
  - User Profiles
  - User Metadata
  - User Flags
  - User Addresses

- **Social Media**
  - User Social Media
  - Social Media Stats (Instagram, TikTok, X)

- **Business Entities**
  - Brands
  - Brands Users
  - Collectives
  - Collectives Users

- **Content and Assets**
  - Assets
  - Collection Main

- **Transactions**
  - Deals
  - Pricing

- **Schools and Sports**
  - Schools
  - Sports
  - Positions
  - Pro Sports

- **System**
  - Activity Log
  - Email Log
  - API Keys
  - Alert Messages
  - Landing Products
  - Services
  - Workbench Activity

## Security Features

The platform implements comprehensive security features:

- **Authentication Security**
  - Secure user registration with email verification
  - Password complexity requirements
  - Account lockout after failed attempts
  - IP-based login restrictions

- **Session Security**
  - Session timeout mechanism
  - Session regeneration on login
  - Session fixation protection
  - IP binding for sessions

- **CSRF Protection**
  - Secure token generation
  - Token validation for all forms
  - Token validation for AJAX requests

- **XSS Protection**
  - Input sanitization
  - Output escaping
  - Content Security Policy headers

- **SQL Injection Protection**
  - Prepared statements for all queries
  - Parameter binding for user input
  - Input validation

- **Security Headers**
  - Content-Security-Policy
  - X-Content-Type-Options
  - X-Frame-Options
  - X-XSS-Protection
  - Referrer-Policy
  - Strict-Transport-Security

## API System

The API provides programmatic access to platform data and functionality:

- **Authentication**
  - API key authentication
  - Rate limiting
  - CORS support

- **Endpoints**
  - Profile endpoint
  - School endpoint
  - Additional endpoints as needed

- **Integration**
  - PHP, Python, and JavaScript examples
  - Best practices for API usage

## Server Configuration

The platform is deployed on an EC2 PHP-Apache server:

- **Server Setup**
  - Apache web server
  - PHP 8.2
  - MySQL database (PlanetScale)
  - SSL/TLS for secure connections

- **Directory Structure**
  - `/var/www/public` for public files
  - `/var/www` for private files

- **Security Configuration**
  - Proper file permissions
  - Security group configuration
  - SSL certificate setup

## Development Guidelines

- **Coding Standards**
  - Follow procedural PHP style
  - Use mysqli for database queries
  - Document code with comments
  - Follow consistent naming conventions

- **Module Development**
  - Create modules following the standard structure
  - Implement proper authentication and security
  - Test thoroughly before deployment

- **Database Development**
  - No FOREIGN KEY constraints (PlanetScale)
  - Manage referential integrity in application code
  - Update schema files when making changes

- **Security Best Practices**
  - Validate all user input
  - Use prepared statements for queries
  - Implement CSRF protection for forms
  - Escape all output

## Deployment Process

1. Update code in development environment
2. Test thoroughly
3. Update documentation
4. Deploy to production:
   - Upload `/public` files to `/var/www/html`
   - Upload other files to `/var/www`
5. Verify deployment
6. Monitor for issues

## Support and Troubleshooting

For support or to report issues:
- Email: support@peaknil.com
- Documentation: https://docs.peaknil.com
- Status: https://status.peaknil.com
