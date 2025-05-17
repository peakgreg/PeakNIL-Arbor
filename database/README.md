# Database Schema Documentation
A comprehensive user authentication and management system designed for scalability and security, optimized for PlanetScale.

## Core Tables Overview

### users
Primary table for user authentication and account management.
- Core authentication data (username, email, password)
- Email verification status and codes
- Account status tracking (active/inactive/banned)
- Security tokens and login tracking
- UUID for public references

Key features:
- Secure password hashing
- Email verification system
- Remember me functionality
- Timestamp tracking
- Unique constraints on critical fields

### user_profiles
Extended user information separate from authentication data.
- Personal information (name, DOB, etc.)
- Role and access management
- Profile customization options
- Contact information
- Profile/cover images
- Flexible additional data storage (JSON)

### user_metadata
Technical and system data about user accounts.
- Registration information (IP, user agent)
- Terms of service acceptance tracking
- Referral tracking
- System metadata
- Signup details

### user_flags
Boolean flags for user status and feature access.
- Account verification status
- Feature access flags
- Administrative flags
- Debug access control
- Import status tracking

### user_addresses
Comprehensive address management system.
- Multiple address types (Home, Work, Shipping)
- International address support
- Primary address flagging
- Full address components

### activity_log
System-wide activity tracking.
- User action logging
- Security event tracking
- IP and user agent logging
- Timestamp tracking
- Additional data storage (JSON)

### banned_users
Dedicated banned user tracking.
- Ban timestamps
- Ban reasons
- Administrative tracking
- Ban history

## Database Design Principles

1. **Separation of Concerns**
  - Authentication data separate from profile data
  - System metadata separate from user data
  - Activity logging separate from user states

2. **Security First**
  - No foreign key constraints (PlanetScale compatibility)
  - Proper indexing for performance
  - UUID usage for public references
  - Comprehensive activity logging

3. **Scalability**
  - Optimized table structure
  - Efficient indexing
  - JSON fields for flexible storage
  - PlanetScale-optimized design

4. **Maintainability**
  - Clear table purposes
  - Consistent naming conventions
  - Comprehensive timestamps
  - Well-documented schema

## Schema Organization
The schema is organized into individual .sql files in the `database/schema/` directory:

database/
├── schema/
│   ├── users.sql
│   ├── user_profiles.sql
│   ├── user_metadata.sql
│   ├── user_flags.sql
│   ├── user_addresses.sql
│   ├── activity_log.sql
│   └── banned_users.sql
└── schema.sql

## Usage Notes

### Timestamps
All tables include:
- `created_at`: Record creation timestamp
- `updated_at`: Last update timestamp

### UUIDs
- Used for public references
- Avoid exposing internal IDs
- Consistent across all related tables

### Indexing
- Primary keys on all tables
- Indexes on frequently queried fields
- Optimized for common queries

### PlanetScale Compatibility
- No foreign key constraints
- Optimized for distributed databases
- Follows PlanetScale best practices

## Best Practices

1. Always use prepared statements for queries
2. Use UUIDs for public references
3. Keep authentication data minimal
4. Log all significant activities
5. Use appropriate data types
6. Index frequently queried fields
7. Follow naming conventions
8. Document schema changes

## Future Considerations

1. Additional profile fields can be added via the `additional_data` JSON field
2. New feature flags can be added to `user_flags`
3. Activity logging can be expanded through `additional_data`
4. Address types can be extended in `user_addresses`

## Maintenance

To maintain database integrity:
1. Regularly review activity logs
2. Monitor table sizes
3. Optimize queries as needed
4. Review and update user flags
5. Clean up old/inactive records
6. Monitor banned users

## Security Considerations

1. Never expose internal IDs
2. Always use prepared statements
3. Log security-relevant activities
4. Monitor failed login attempts
5. Regular security audits
6. Proper password hashing