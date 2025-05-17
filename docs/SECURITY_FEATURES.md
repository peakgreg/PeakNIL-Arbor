# PeakNIL Security Features Documentation

This document provides a comprehensive overview of the security features implemented in the PeakNIL platform, including authentication, data protection, input validation, and best practices for maintaining security.

## Table of Contents

1. [Security Overview](#security-overview)
2. [Authentication Security](#authentication-security)
3. [Session Security](#session-security)
4. [CSRF Protection](#csrf-protection)
5. [XSS Protection](#xss-protection)
6. [SQL Injection Protection](#sql-injection-protection)
7. [Security Headers](#security-headers)
8. [Rate Limiting](#rate-limiting)
9. [API Security](#api-security)
10. [Password Security](#password-security)
11. [Email Security](#email-security)
12. [Logging and Monitoring](#logging-and-monitoring)
13. [Security Best Practices](#security-best-practices)
14. [Security Checklist](#security-checklist)

## Security Overview

The PeakNIL platform implements a comprehensive security strategy that addresses various aspects of web application security, including:

- **Authentication**: Secure user authentication with email verification
- **Session Management**: Secure session handling with timeout and fixation protection
- **CSRF Protection**: Cross-Site Request Forgery protection for forms and AJAX requests
- **XSS Protection**: Cross-Site Scripting protection through input sanitization and output escaping
- **SQL Injection Protection**: Prepared statements for all database queries
- **Security Headers**: HTTP security headers to protect against various attacks
- **Rate Limiting**: Protection against brute force and denial of service attacks
- **API Security**: Secure API access with API key authentication and rate limiting
- **Password Security**: Secure password storage with Bcrypt hashing
- **Email Security**: Secure email communication with logging and verification
- **Logging and Monitoring**: Comprehensive logging of security events and user activities

## Authentication Security

The platform implements a secure authentication system with the following features:

### User Registration

- Email verification required for new accounts
- Password complexity requirements enforced
- Username and email uniqueness verification
- Rate limiting for registration attempts
- CSRF protection for registration forms

### Login Process

- Secure login with email/password
- Rate limiting for login attempts
- Account lockout after failed attempts
- IP-based login restrictions
- CSRF protection for login forms
- Session regeneration on successful login

### Password Reset

- Secure password reset via email
- Time-limited reset tokens
- Rate limiting for reset attempts
- Email notification for password changes

### Email Verification

- Required email verification for new accounts
- Secure verification tokens
- Rate limiting for verification attempts
- Resend verification option with rate limiting

### Implementation Details

The authentication system is implemented in the following files:

- `auth/login.php`: Handles user login
- `auth/register.php`: Handles user registration
- `auth/logout.php`: Handles user logout
- `auth/reset-password.php`: Handles password reset
- `auth/verify-email.php`: Handles email verification
- `auth/functions/login_functions.php`: Contains login-related functions
- `auth/functions/register_functions.php`: Contains registration-related functions
- `auth/functions/password_functions.php`: Contains password-related functions
- `auth/middleware/auth_middleware.php`: Contains authentication middleware

Key security functions include:

```php
// Authenticate user with email and password
function authenticate_user($email, $password) {
    global $db;
    
    $sql = "SELECT id, uuid, email, password_hash, username FROM users WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    
    if (!$user) {
        return false;
    }
    
    $verify_result = verify_password($password, $user['password_hash']);
    
    if ($verify_result['valid']) {
        // Password rehashing if needed
        if ($verify_result['needs_upgrade']) {
            $new_hash = hash_password($password);
            $update_sql = "UPDATE users SET password_hash = ? WHERE id = ?";
            $update_stmt = $db->prepare($update_sql);
            $update_stmt->bind_param('si', $new_hash, $user['id']);
            $update_stmt->execute();
        }
        
        unset($user['password_hash']); // Don't include password hash in session
        return $user;
    }
    
    return false;
}

// Create user session after successful authentication
function create_user_session($user) {
    // Regenerate session ID to prevent session fixation
    regenerate_session();
    
    // Set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['uuid'] = $user['uuid'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['logged_in'] = true;
    
    // Log login activity
    log_activity($user['id'], 'log_in');
}
```

## Session Security

The platform implements secure session management with the following features:

### Session Configuration

- HTTPOnly flag enabled for session cookies
- Secure flag enabled in production environments
- Session cookies expire when browser closes
- Domain restricted to current domain only
- JavaScript access to session cookies prevented
- SameSite attribute set to Lax

### Session Handling

- Session timeout mechanism
- Session regeneration on login
- Session fixation protection
- Session destruction on logout
- IP binding for sessions
- User agent binding for sessions

### Implementation Details

Session security is implemented in the following files:

- `config/sessions.php`: Session configuration
- `modules/common/functions/security_functions.php`: Session security functions

Key security functions include:

```php
// Regenerate session ID to prevent session fixation attacks
function regenerate_session() {
    if (session_status() === PHP_SESSION_ACTIVE) {
        try {
            // Get current session data
            $session_data = $_SESSION;
            
            // Clear session data but keep the session
            session_unset();
            
            // Generate new session ID
            if (@session_regenerate_id(true)) {
                // Restore session data
                $_SESSION = $session_data;
                $_SESSION['LAST_ACTIVITY'] = time();
                return true;
            }
            
            // If regeneration failed, at least restore the data
            $_SESSION = $session_data;
            $_SESSION['LAST_ACTIVITY'] = time();
            
            // Log the failure but don't break the flow
            error_log("Session ID regeneration failed, but session data preserved");
            return true;
        } catch (Exception $e) {
            error_log("Session regeneration error: " . $e->getMessage());
            return false;
        }
    }
    return false;
}

// Check if the session has timed out
function check_session_timeout() {
    // If no last activity time is set, session has expired
    if (!isset($_SESSION['LAST_ACTIVITY'])) {
        return true;
    }
    
    // Check if session has expired
    if (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_LIFETIME) {
        // Session has expired, destroy it
        session_unset();
        session_destroy();
        return true;
    }
    
    // Update last activity time
    $_SESSION['LAST_ACTIVITY'] = time();
    return false;
}
```

## CSRF Protection

The platform implements Cross-Site Request Forgery (CSRF) protection with the following features:

### CSRF Token Generation

- Secure token generation using random bytes
- Token stored in session
- Token regenerated for each form

### CSRF Token Validation

- Token validation for all forms
- Token validation for AJAX requests
- Token comparison using constant-time comparison

### Implementation Details

CSRF protection is implemented in the following files:

- `modules/common/functions/security_functions.php`: CSRF protection functions

Key security functions include:

```php
// Generate a CSRF token and store it in the session
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(CSRF_TOKEN_LENGTH));
    }
    return $_SESSION['csrf_token'];
}

// Validate the CSRF token from the form submission
function validate_csrf_token($token) {
    if (!empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
        // Token is valid, remove it so it can't be reused
        unset($_SESSION['csrf_token']);
        return true;
    }
    return false;
}

// Generate HTML for CSRF token input field
function csrf_token_field() {
    $token = generate_csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}
```

## XSS Protection

The platform implements Cross-Site Scripting (XSS) protection with the following features:

### Input Sanitization

- All user input is sanitized
- HTML special characters are escaped
- Tags are stripped from input
- Input is trimmed of whitespace

### Output Escaping

- All output is escaped for the appropriate context
- HTML context escaping
- JavaScript context escaping
- CSS context escaping
- URL context escaping

### Content Security Policy

- Strict Content Security Policy headers
- Script source restrictions
- Style source restrictions
- Image source restrictions
- Font source restrictions
- Frame ancestor controls
- Form action restrictions

### Implementation Details

XSS protection is implemented in the following files:

- `modules/common/functions/security_functions.php`: XSS protection functions

Key security functions include:

```php
// Sanitizes input data to prevent XSS
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return $data;
}

// Escapes output for HTML context
function escape_output($output) {
    return htmlspecialchars($output, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

// Sets security headers
function set_security_headers() {
    if (!headers_sent()) {
        // Content Security Policy
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline'",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net",
            "img-src 'self' data: https://cdn.peaknil.com",
            "font-src 'self'",
            "frame-ancestors 'self'",
            "form-action 'self'",
            "base-uri 'self'",
            "object-src 'none'"
        ];
        header("Content-Security-Policy: " . implode("; ", $csp));
        
        // Additional security headers
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: SAMEORIGIN");
        header("X-XSS-Protection: 1; mode=block");
        header("Referrer-Policy: strict-origin-when-cross-origin");
    }
}
```

## SQL Injection Protection

The platform implements SQL Injection protection with the following features:

### Prepared Statements

- All database queries use prepared statements
- Parameter binding for all user input
- Type-specific parameter binding

### Input Validation

- All user input is validated before use in queries
- Type checking for numeric inputs
- Format validation for email, dates, etc.

### Error Handling

- Database errors are logged but not displayed to users
- Generic error messages for database errors
- Detailed error logging for debugging

### Implementation Details

SQL Injection protection is implemented throughout the codebase, with database queries using prepared statements and parameter binding. Example:

```php
// Example of a secure database query
function get_user_by_email($email) {
    global $db;
    
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}
```

## Security Headers

The platform implements security headers to protect against various attacks:

### Content Security Policy (CSP)

- Restricts sources of content
- Prevents XSS attacks
- Controls which resources can be loaded

### X-Content-Type-Options

- Prevents MIME type sniffing
- Forces browsers to use the declared content type

### X-Frame-Options

- Prevents clickjacking attacks
- Controls whether the page can be displayed in a frame

### X-XSS-Protection

- Enables browser's built-in XSS protection
- Blocks rendering of pages when XSS is detected

### Referrer-Policy

- Controls what information is sent in the Referer header
- Protects user privacy

### Strict-Transport-Security

- Forces browsers to use HTTPS
- Prevents protocol downgrade attacks

### Implementation Details

Security headers are implemented in the following files:

- `modules/common/functions/security_functions.php`: Security header functions

Key security functions include:

```php
// Sets security headers
function set_security_headers() {
    if (!headers_sent()) {
        // Content Security Policy
        $csp = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline'",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net",
            "img-src 'self' data: https://cdn.peaknil.com",
            "font-src 'self'",
            "frame-ancestors 'self'",
            "form-action 'self'",
            "base-uri 'self'",
            "object-src 'none'"
        ];
        header("Content-Security-Policy: " . implode("; ", $csp));
        
        // Additional security headers
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: SAMEORIGIN");
        header("X-XSS-Protection: 1; mode=block");
        header("Referrer-Policy: strict-origin-when-cross-origin");
        header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
    }
}
```

## Rate Limiting

The platform implements rate limiting to protect against brute force and denial of service attacks:

### Login Rate Limiting

- Limits the number of login attempts per IP address
- Implements account lockout after failed attempts
- Tracks login attempts in the database

### Registration Rate Limiting

- Limits the number of registration attempts per IP address
- Implements progressive delays between attempts
- Tracks registration attempts in the database

### Password Reset Rate Limiting

- Limits the number of password reset attempts per email
- Implements progressive delays between attempts
- Tracks password reset attempts in the database

### Email Verification Rate Limiting

- Limits the number of verification attempts per user
- Implements progressive delays between attempts
- Tracks verification attempts in the database

### Implementation Details

Rate limiting is implemented in the following files:

- `modules/common/functions/security_functions.php`: Rate limiting functions
- `auth/functions/register_functions.php`: Registration rate limiting

Key security functions include:

```php
// Records a failed login attempt
function record_login_attempt($email) {
    global $db;
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $current_time = date('Y-m-d H:i:s');
    
    $stmt = $db->prepare("INSERT INTO login_attempts (ip_address, email, attempt_time) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $ip, $email, $current_time);
    $stmt->execute();
    
    // Clean up old attempts
    cleanup_login_attempts();
}

// Checks if the current user is locked out due to too many failed attempts
function check_login_lockout($email) {
    global $db;
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $check_time = date('Y-m-d H:i:s', time() - ATTEMPT_WINDOW);
    
    // Count recent attempts
    $stmt = $db->prepare("
        SELECT COUNT(*) as attempt_count, MAX(attempt_time) as last_attempt 
        FROM login_attempts 
        WHERE (ip_address = ? OR email = ?) 
        AND attempt_time > ?
    ");
    $stmt->bind_param('sss', $ip, $email, $check_time);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    if ($result['attempt_count'] >= MAX_LOGIN_ATTEMPTS) {
        $last_attempt_time = strtotime($result['last_attempt']);
        $time_remaining = ($last_attempt_time + LOCKOUT_TIME) - time();
        
        if ($time_remaining > 0) {
            return [true, ceil($time_remaining / 60)];
        }
    }
    
    return [false, 0];
}
```

## API Security

The platform implements API security with the following features:

### API Key Authentication

- API key required for all API requests
- API keys stored as SHA-256 hashes in the database
- API keys can be deactivated at any time

### Rate Limiting

- Each API key has a configurable rate limit
- Limits are tracked per key in the database
- Exceeding limits returns 429 Too Many Requests

### Input Validation

- All API input parameters are strictly validated
- UUID format validation for IDs
- SQL injection protection via prepared statements
- XSS protection via proper output encoding

### Error Handling

- Standardized error responses
- Detailed error messages in development
- Sanitized error messages in production
- All errors are logged for monitoring

### Implementation Details

API security is implemented in the following files:

- `modules/api/Middleware/APIAuth.php`: API authentication middleware
- `modules/api/Core/Request.php`: Request validation
- `modules/api/Core/Response.php`: Response formatting

## Password Security

The platform implements password security with the following features:

### Password Hashing

- Bcrypt hashing algorithm
- Configurable cost factor
- Automatic rehashing when cost factor changes

### Password Complexity

- Minimum length requirement
- Requires uppercase and lowercase letters
- Requires numbers
- Requires special characters

### Password Storage

- Only password hashes stored in the database
- Original passwords never stored
- Password hashes never exposed in session or logs

### Implementation Details

Password security is implemented in the following files:

- `auth/functions/password_functions.php`: Password security functions

Key security functions include:

```php
// Hash a password using Bcrypt
function hash_password($password) {
    $options = [
        'cost' => 12  // Higher cost means more secure but slower
    ];
    
    $hash = password_hash($password, PASSWORD_BCRYPT, $options);
    
    // Verify the hash was created with Bcrypt
    $info = password_get_info($hash);
    if ($info['algoName'] !== 'bcrypt') {
        throw new Exception('Failed to create Bcrypt hash. Got ' . $info['algoName'] . ' instead.');
    }
    
    return $hash;
}

// Verify a password against a hash
function verify_password($password, $hash) {
    // Verify the password against the bcrypt hash
    $is_valid = password_verify($password, $hash);
    if ($is_valid) {
        $needs_rehash = needs_password_rehash($hash);
        return ['valid' => true, 'needs_upgrade' => $needs_rehash];
    }
    return ['valid' => false];
}

// Check if password needs rehashing
function needs_password_rehash($hash) {
    $options = [
        'cost' => 12
    ];
    
    return password_needs_rehash($hash, PASSWORD_BCRYPT, $options);
}
```

## Email Security

The platform implements email security with the following features:

### Email Verification

- Required email verification for new accounts
- Secure verification tokens
- Rate limiting for verification attempts

### Email Logging

- All emails are logged in the database
- Email status tracking
- Error message logging

### Email Templates

- Secure email templates
- HTML and plain text versions
- Proper encoding of email content

### Implementation Details

Email security is implemented in the following files:

- `modules/common/functions/email_functions.php`: Email functions
- `auth/functions/register_functions.php`: Email verification functions

Key security functions include:

```php
// Send an email using the template
function send_template_email($to, $subject, $title, $body, $from_name = '') {
    try {
        // Extract variables for template
        extract([
            'subject' => $subject,
            'title' => $title,
            'body' => $body
        ]);
        
        // Get template file
        ob_start();
        include dirname(__DIR__) . '/views/emails/template.php';
        $html_body = ob_get_clean();

        $mail = init_mailer();
        if (!$mail) {
            throw new Exception("Failed to initialize mailer");
        }

        if ($from_name) {
            $mail->FromName = $from_name;
        }

        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $html_body;
        $mail->AltBody = strip_tags($body);

        $success = $mail->send();
        
        // Log the email attempt
        $config = get_mail_config();
        log_email(
            $to,
            $config['from_address'],
            $from_name ?: $config['from_name'],
            $subject,
            $html_body,
            true,
            [],
            $success ? 'success' : 'failed',
            null
        );

        return $success;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        error_log("Error sending template email: " . $error_message);
        
        // Log the failed attempt
        $config = get_mail_config();
        log_email(
            $to,
            $config['from_address'],
            $from_name ?: $config['from_name'],
            $subject,
            $html_body ?? $body,
            true,
            [],
            'failed',
            $error_message
        );
        
        return false;
    }
}
```

## Logging and Monitoring

The platform implements logging and monitoring with the following features:

### Activity Logging

- User activities are logged in the database
- Login and logout events
- Profile updates
- Security-related actions

### Error Logging

- All errors are logged
- Error severity levels
- Error context information
- Error timestamps

### Email Logging

- All emails are logged in the database
- Email status tracking
- Error message logging

### Security Event Logging

- Security-related events are logged
- Failed login attempts
- Password reset requests
- Email verification attempts

### Implementation Details

Logging and monitoring are implemented in the following files:

- `modules/common/functions/security_functions.php`: Security logging functions
- `auth/functions/login_functions.php`: Login activity logging
- `modules/common/functions/email_functions.php`: Email logging functions

Key logging functions include:

```php
// Logs user activity to the database
function log_activity($user_id, $activity) {
    global $db;
    
    try {
        $stmt = $db->prepare("
            INSERT INTO activity_log (
                user_id,
                activity,
                ip_address,
                user_agent,
                additional_data
            ) VALUES (?, ?, ?, ?, ?)
        ");
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $additional_data = json_encode(['session_id' => session_id()]);
        
        $stmt->bind_param('issss', 
            $user_id, 
            $activity, 
            $ip,
            $ua,
            $additional_data
        );
        
        return $stmt->execute();
    } catch (mysqli_sql_exception $e) {
        error_log("Activity log error: " . $e->getMessage());
        return false;
    }
}
```

## Security Best Practices

The platform follows these security best practices:

### Input Validation

- Validate all user input
- Use type-specific validation
- Implement whitelist validation
- Validate on both client and server sides

### Output Encoding

- Encode all output for the appropriate context
- Use context-specific encoding functions
- Never trust user input in output

### Authentication and Authorization

- Implement strong authentication
- Use role-based access control
- Implement principle of least privilege
- Verify authorization for all actions

### Database Security

- Use prepared statements for all queries
- Implement proper error handling
- Use connection pooling
- Implement database user permissions

### File Security

- Validate file uploads
- Store files outside web root
- Implement proper file permissions
- Scan uploaded files for malware

### Error Handling

- Implement proper error handling
- Log errors but don't display them to users
- Use generic error messages in production
- Implement custom error pages

### Secure Configuration

- Use environment-specific configuration
- Store sensitive configuration in environment variables
- Implement proper file permissions
- Use secure defaults

### Code Security

- Follow secure coding practices
- Implement code reviews
- Use static code analysis
- Keep dependencies up to date

## Security Checklist

The platform implements the following security measures:

### Critical Priority
- [x] 1. Implement Password Security
  - [x] Add password hashing using PASSWORD_BCRYPT
  - [x] Implement password complexity requirements
  - [x] Complete password reset functionality
  - [x] Add password change verification

- [x] 2. Add CSRF Protection
  - [x] Implement CSRF token generation
  - [x] Add CSRF validation to all forms
  - [x] Include CSRF tokens in AJAX requests

- [x] 3. Enhance Session Security
  - [x] Add session timeout mechanism
  - [x] Implement session fixation protection
  - [x] Add rate limiting for login attempts

### High Priority
- [x] 4. Strengthen XSS Protection
  - [x] Implement output escaping across all views
  - [x] Add Content Security Policy headers
  - [x] Enable X-XSS-Protection header
  - [x] Sanitize all user inputs

- [x] 5. Ensure SQL Injection Protection
  - [x] Audit all queries for prepared statements
  - [x] Implement consistent input sanitization
  - [x] Add query logging for suspicious patterns

- [x] 6. Implement Account Security
  - [x] Add account lockout after failed attempts
  - [x] Implement progressive delays between attempts
  - [x] Add suspicious activity notifications
  - [ ] Implement two-factor authentication (planned)

### Medium Priority
- [x] 7. Add Security Headers
  - [x] Strict-Transport-Security
  - [x] X-Frame-Options
  - [x] X-Content-Type-Options
  - [x] Referrer-Policy

- [x] 8. Implement Comprehensive Logging
  - [x] Log authentication attempts
  - [x] Log password reset requests
  - [x] Log suspicious activities
  - [x] Set up log rotation and monitoring

- [x] 9. API Security Enhancements
  - [x] Implement API rate limiting
  - [x] Add API key authentication
  - [x] Add input validation for all endpoints
  - [x] Implement proper error handling

### Maintenance Tasks
- [ ] 10. Regular Security Maintenance
  - [ ] Update all dependencies
  - [ ] Review security measures
  - [ ] Implement security monitoring
  - [ ] Conduct security audits
  - [ ] Update security documentation
  - [ ] Schedule developer security training
