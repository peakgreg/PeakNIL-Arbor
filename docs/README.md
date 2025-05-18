# PeakNIL Platform - Codename Arbor
    
  - composer install --no-dev --optimize-autoloader
  - SSH:
    ssh -i /Users/gregoryjackson/Documents/GitHub/PeakNIL-Arbor/PeakNIL-Arbor.pem ec2-user@3.145.193.251

# Setup
  - Update .env file.

# Terminal Commands
  - Generate directory tree
    `tree -a --prune -I 'vendor|.git' > directory_tree.txt`

# Architecture 
  - Procedural Modular Architecture

# MySQL

# PeakNIL Platform Documentation

Welcome to the PeakNIL Platform documentation. This repository contains comprehensive documentation for the PeakNIL platform, a procedural modular PHP application for managing NIL (Name, Image, Likeness) deals, user profiles, and related functionality.

## Documentation Overview

This documentation has been organized to provide a comprehensive understanding of the PeakNIL platform architecture, components, and functionality. The documentation is divided into several sections, each focusing on a specific aspect of the platform.

### Core Documentation

- [**Documentation Index**](DOCUMENTATION_INDEX.md): Central reference point for all documentation
- [**Platform Overview**](PLATFORM_OVERVIEW.md): Comprehensive overview of the platform architecture, components, and functionality
- [**Database Schema**](DATABASE_SCHEMA.md): Detailed documentation of the database schema, including table structures and relationships
- [**Module System**](MODULE_SYSTEM.md): Documentation of the modular architecture, including module structure and functionality
- [**Security Features**](SECURITY_FEATURES.md): Overview of security features implemented in the platform
- [**API System**](API_SYSTEM.md): Documentation of the API system, including endpoints, authentication, and usage examples
- [**Server Configuration**](SERVER.md): Guide for setting up and configuring the server environment

## Platform Architecture

The PeakNIL platform follows a procedural modular architecture with the following key components:

- **Config**: Contains configuration files for the platform, including database connection, session management, and constants.
- **Modules**: Contains the platform's functionality organized into separate modules.
- **Auth**: Handles user authentication, registration, and session management.
- **Public**: Contains publicly accessible files and assets.
- **Database**: Contains database schema and relationship definitions.
- **Docs**: Contains documentation files.

The platform uses a PHP-based backend with a MySQL database. It follows a procedural programming paradigm with a modular structure, where each module handles a specific aspect of the platform's functionality.

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- MySQL database (PlanetScale)
- Apache web server
- Composer for PHP dependency management

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-repo/peaknil-platform.git
   ```

2. Install dependencies:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

3. Configure the environment:
   - Copy `.env.example` to `.env`
   - Update the `.env` file with your database credentials and other settings

4. Set up the database:
   ```bash
   mysql -u root -p user_auth < database/schema.sql
   ```

5. Start the development server:
   ```bash
   php -S 0.0.0.0:8888 -t public
   ```

6. Access the platform at `http://localhost:8888`

### Directory Structure

```
/
├── auth/                  # Authentication system
├── config/                # Configuration files
├── database/              # Database schema and seeds
├── docs/                  # Documentation
├── logs/                  # Log files
├── modules/               # Platform modules
├── public/                # Publicly accessible files
├── scripts/               # Utility scripts
├── storage/               # Storage for uploads and cache
├── vendor/                # Composer dependencies
├── .env                   # Environment variables
├── .gitignore             # Git ignore file
├── composer.json          # Composer configuration
└── README.md              # This file
```

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

For more information on the module system, see the [Module System Documentation](MODULE_SYSTEM.md).

## Database Schema

The database consists of multiple tables organized around the following key entities:

- Users and authentication
- User profiles and metadata
- Social media integration
- Business entities (brands, collectives)
- Content and assets
- Transactions and deals
- Schools and sports
- System functionality

For more information on the database schema, see the [Database Schema Documentation](DATABASE_SCHEMA.md).

## Security Features

The platform implements comprehensive security features:

- Authentication security with email verification
- Session security with timeout and fixation protection
- CSRF protection for forms and AJAX requests
- XSS protection through input sanitization and output escaping
- SQL injection protection with prepared statements
- Security headers to protect against various attacks
- Rate limiting for login attempts and API requests
- Password security with Bcrypt hashing

For more information on security features, see the [Security Features Documentation](SECURITY_FEATURES.md).

## API System

The platform provides a RESTful API for programmatic access to platform data and functionality:

- API key authentication
- Rate limiting
- CORS support for cross-origin requests
- Standardized request and response formats
- Comprehensive error handling
- Versioned endpoints

For more information on the API system, see the [API System Documentation](API_SYSTEM.md).

## Server Configuration

The platform is deployed on an EC2 PHP-Apache server with the following configuration:

- Apache web server
- PHP 8.2
- MySQL database (PlanetScale)
- SSL/TLS for secure connections

For more information on server configuration, see the [Server Configuration Documentation](SERVER.md).

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

## License

This project is proprietary and confidential. Unauthorized copying, distribution, or use is strictly prohibited.

## Acknowledgements

- [Bootstrap](https://getbootstrap.com/) - Frontend framework
- [PHPMailer](https://github.com/PHPMailer/PHPMailer) - Email sending library
- [Dotenv](https://github.com/vlucas/phpdotenv) - Environment variable management
