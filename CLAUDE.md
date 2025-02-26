# CLAUDE.md - Guidelines for the PeakNIL Platform

## Development Commands
- **MAMP Web Server**: Access via http://localhost:8888/test/ (default MAMP ports)
- **PHP Version**: 8.0+ required
- **Run Application**: Access through browser at MAMP URL endpoint
- **Validate PHP**: `php -l path/to/file.php` (lint single file)
- **Generate API Key**: `php scripts/generate_api_key.php`

## Code Style Guidelines
- **Module Structure**: Each module has main PHP file, functions/, and views/ directories
- **Naming Conventions**: snake_case for functions/files, camelCase for methods, PascalCase for classes
- **Imports**: Use require_once for files, namespaces for classes (PSR-4 autoloading)
- **Error Handling**: Return error arrays, use try/catch for DB operations, log errors with error_log()
- **Security**: Use prepared statements, validate inputs, regenerate sessions for auth flows
- **Documentation**: Use PHPDoc blocks with @param and @return tags for all functions
- **File Organization**: Follow established directory structure, put utilities in common/functions/
- **Database**: Use parameterized queries via prepared statements exclusively
- **Frontend**: Keep logic separate from presentation, use view files for display

## Environment Setup
### Development (MAMP)
- Uses MAMP local development environment
- All files in same directory structure
- No special permissions needed
- Access via http://localhost:8888/

### Production (EC2 Deployment)
- Access via http://3.133.107.107/
- Split directory structure for security:
  - `/var/www/html/` - Contains only public files (from /public directory)
  - `/var/www/` - Contains application code (everything else)
- Uses Composer with `--no-dev --classmap-authoritative` flags
- File permissions: 755 for directories, 644 for files
- Services: Apache2 with PHP-FPM
- Cache: Uses OPcache and APCu in production
- Deployed via GitHub Actions on push to main branch