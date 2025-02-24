# Changelog

## Unreleased

### Added
- Added GitHub Actions workflow to test EC2 connection on push to main branch.

## [2025-02-24]
- Updated config/db.php to use SSL/TLS connection for PlanetScale with enhanced configuration
    - Modified mysqli connection to include MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, ssl_set, and MYSQLI_CLIENT_SSL
    - Ensured secure database connection to PlanetScale
    - Maintained existing error handling and charset settings

## [2025-02-03]
- Updated NIL services filter UI to dropdown style
    - Converted horizontal filters to dropdown-based layout
    - Added dynamic counter for selected filters
    - Improved dropdown interaction with click propagation handling
    - Maintained mobile responsiveness and filter functionality
    - Enhanced dropdown styling and spacing
    - Added visual feedback for selected filter counts

- Added customizable image height for service cards in NIL profile view
    - Implemented CSS variable for adjustable card image height
    - Default height set to 200px with ability to customize via --service-card-img-height
    - Maintained responsive design and image quality

- Enhanced service card styling in NIL profile view
    - Added smooth transitions and hover effects
    - Improved card borders and shadow styling
    - Added proper aspect ratio for service images
    - Enhanced typography with better readability
    - Added service category display
    - Implemented responsive design adjustments
    - Added elevation effect on hover for better interaction feedback

## [2025-02-02]
- Optimized service card heights in NIL profile view
    - Reduced padding and margins for more compact layout
    - Adjusted typography sizing for better space utilization
    - Removed automatic height stretching
    - Improved overall visual density of service grid

- Updated NIL services filter UI in profile view
    - Converted left column filters to horizontal row layout
    - Improved desktop filter visibility and usability
    - Maintained mobile-responsive design with modal
    - Enhanced filter section spacing and alignment
    - Added horizontal layout styles while preserving functionality

- Converted registration functions to mysqli
    - Updated can_resend_verification() to use mysqli prepared statements
    - Converted create_user() function with proper mysqli transaction handling
    - Implemented mysqli conversion for log_verification_attempt()
    - Maintained existing functionality while improving security:
        * Added proper error handling for all database operations
        * Used prepared statements for all queries
        * Implemented transaction rollback for error cases
        * Preserved rate limiting and validation logic
- Improved error handling and logging in registration process
    - Updated register.php to handle new error format from create_user()
    - Added more detailed logging throughout the registration process
    - Improved error messages displayed to users
- Fixed SQL syntax error in email logging function
    - Updated log_email() function in email_functions.php to use mysqli syntax
    - Replaced named placeholders with ? placeholders
    - Implemented proper parameter binding with bind_param()
    - Enhanced error handling and logging for email-related database operations
- Updated email verification process to use mysqli
    - Converted verify-email.php to use mysqli syntax instead of PDO
    - Replaced fetch() method with get_result() and fetch_assoc()
    - Updated parameter binding to use bind_param()
    - Added error checking for prepare() and execute() calls
    - Implemented proper statement object closure
- Note: Awaiting user verification of functionality before deployment

## Previous Changes
[The rest of the changelog remains unchanged]
