# PeakNIL Database Schema Documentation

This document provides a comprehensive overview of the PeakNIL platform's database schema, including table structures, relationships, and data models.

## Table of Contents

1. [Database Overview](#database-overview)
2. [Core User Tables](#core-user-tables)
3. [Authentication Tables](#authentication-tables)
4. [Profile and Metadata Tables](#profile-and-metadata-tables)
5. [Social Media Tables](#social-media-tables)
6. [Business Entity Tables](#business-entity-tables)
7. [Content and Asset Tables](#content-and-asset-tables)
8. [Transaction Tables](#transaction-tables)
9. [School and Sports Tables](#school-and-sports-tables)
10. [System Tables](#system-tables)
11. [Table Relationships](#table-relationships)
12. [Database Design Considerations](#database-design-considerations)

## Database Overview

The PeakNIL platform uses a MySQL database with a relational model. The database does not use FOREIGN KEY constraints, assuming PlanetScale as the database, and manages referential integrity through application code.

The database schema is organized around several key entities:
- Users and authentication
- User profiles and metadata
- Social media integration
- Business entities (brands, collectives)
- Content and assets
- Transactions and deals
- Schools and sports
- System functionality

## Core User Tables

### Users Table

The `users` table stores core user information and authentication details.

```sql
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Username of the user.',
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Users email address.',
  `email_verified` tinyint(1) DEFAULT '0' COMMENT 'Has the user confirmed their email address.',
  `email_confirmation_code` int DEFAULT NULL COMMENT 'Email confirmation code.',
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Users password.',
  `status` enum('active','inactive','banned') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`)
)
```

### Roles Table

The `roles` table defines user roles within the system.

```sql
CREATE TABLE `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'References ''role_id'' in ''user_profiles'' table.',
  PRIMARY KEY (`id`)
)
```

### Levels Table

The `levels` table manages different user access levels.

```sql
CREATE TABLE `levels` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `level` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
)
```

## Authentication Tables

### Login Attempts Table

The `login_attempts` table tracks user login attempts and security details.

```sql
CREATE TABLE `login_attempts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempt_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ip_email` (`ip_address`,`email`),
  KEY `idx_attempt_time` (`attempt_time`)
)
```

### Verification Attempts Table

The `verification_attempts` table tracks user verification attempts and security details.

```sql
CREATE TABLE `verification_attempts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `attempted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_last_attempt` (`user_id`,`attempted_at`)
)
```

### Banned Users Table

The `banned_users` table tracks banned users and ban details.

```sql
CREATE TABLE `banned_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `uuid` char(36) NOT NULL,
  `banned_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `banned_by` int unsigned DEFAULT NULL,
  `reason` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `banned_by` (`banned_by`)
)
```

## Profile and Metadata Tables

### User Profiles Table

The `user_profiles` table stores detailed user profile information.

```sql
CREATE TABLE `user_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) DEFAULT NULL COMMENT 'UUID of user.',
  `first_name` varchar(50) DEFAULT NULL COMMENT 'First name of user.',
  `middle_name` varchar(50) DEFAULT NULL COMMENT 'Middle name of user.',
  `last_name` varchar(50) DEFAULT NULL COMMENT 'Last name of user.',
  `date_of_birth` date DEFAULT NULL COMMENT 'DOB of user.',
  `access_level` int unsigned DEFAULT '1' COMMENT 'User access level.',
  `role_id` tinyint unsigned DEFAULT '1' COMMENT 'Role of the user.',
  `us_citizen` tinyint(1) DEFAULT '0' COMMENT 'Citizenship status.',
  `gender` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Gender of user.',
  `phone_number` varchar(20) DEFAULT NULL COMMENT 'Phone number of user.',
  `profile_image_id` bigint unsigned DEFAULT NULL COMMENT 'Profile image ID.',
  `cover_image_id` bigint unsigned DEFAULT NULL COMMENT 'Cover image ID.',
  `profile_description` text,
  `referral_code` varchar(12) DEFAULT NULL COMMENT 'Users referral code.',
  `additional_data` json DEFAULT NULL COMMENT 'Additional flexible attributes.',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `level_id` tinyint DEFAULT NULL,
  `position_id` int DEFAULT NULL,
  `sport_id` int DEFAULT NULL,
  `school_id` int DEFAULT NULL,
  `team_id` int DEFAULT NULL,
  `tags` text,
  `card_id` int DEFAULT NULL,
  `verified` tinyint(1) DEFAULT '0',
  `school_association` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
)
```

### User Metadata Table

The `user_metadata` table stores additional user information and preferences.

```sql
CREATE TABLE `user_metadata` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `uuid` char(36) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `signup_timestamp` int DEFAULT NULL,
  `accepted_terms_at` int DEFAULT NULL,
  `tos_version` int DEFAULT '1',
  `referred_by` varchar(12) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
)
```

### User Flags Table

The `user_flags` table tracks user account flags and system statuses.

```sql
CREATE TABLE `user_flags` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `uuid` char(36) NOT NULL,
  `verified` tinyint(1) DEFAULT '0',
  `imported` tinyint(1) DEFAULT '0',
  `dynamic_pricing` tinyint(1) DEFAULT '0',
  `deactivated` tinyint(1) DEFAULT '0',
  `banned` tinyint(1) DEFAULT '0',
  `workbench_access` tinyint(1) DEFAULT '0',
  `debug_access` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
)
```

### User Addresses Table

The `user_addresses` table manages user address information.

```sql
CREATE TABLE `user_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `uuid` char(36) NOT NULL,
  `address_type` enum('Hometown','Home_Current','Work','Shipping') DEFAULT 'Home_Current',
  `street_address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `is_primary` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
)
```

## Social Media Tables

### User Social Media Table

The `user_social_media` table tracks user social media account information.

```sql
CREATE TABLE `user_social_media` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `instagram_username` varchar(255) DEFAULT NULL,
  `x_username` varchar(255) DEFAULT NULL,
  `tiktok_username` varchar(255) DEFAULT NULL,
  `facebook_username` varchar(255) DEFAULT NULL,
  `linkedin_username` varchar(255) DEFAULT NULL,
  `youtube_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)
```

### Social Media Stats Tables

The platform includes several tables for tracking social media statistics:

```sql
CREATE TABLE `social_media_stats_instagram` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `follower_count` int unsigned DEFAULT NULL,
  `following_count` int unsigned DEFAULT NULL,
  `media_count` int DEFAULT NULL,
  `recorded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `error` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
)

CREATE TABLE `social_media_stats_tiktok` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `follower_count` int unsigned DEFAULT NULL,
  `following_count` int unsigned DEFAULT NULL,
  `verified` tinyint DEFAULT NULL,
  `signature` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `heart` int DEFAULT NULL,
  `heart_count` int DEFAULT NULL,
  `video_count` int DEFAULT NULL,
  `friend_count` int DEFAULT NULL,
  `recorded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `error` tinyint DEFAULT '0',
  PRIMARY KEY (`id`)
)

CREATE TABLE `social_media_stats_x` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `follower_count` int unsigned DEFAULT NULL,
  `following_count` int unsigned DEFAULT NULL,
  `favourites_count` int DEFAULT NULL,
  `verified` tinyint(1) DEFAULT NULL,
  `signature` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `recorded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `error` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
)
```

## Business Entity Tables

### Brands Table

The `brands` table stores information about brands/companies.

```sql
CREATE TABLE `brands` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Username of the brand.',
  `uniqueID` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unique id generated for each brand. This will always start with with "B_".',
  `active` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'yes' COMMENT 'Is this brand currently active? ''yes'' if YES. ''no'' if NO.',
  `available_balance` int DEFAULT '0' COMMENT 'Available balance for NIL deals. Example ''10000'' equals ''100.00''.',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Name to be displayed for the brand.',
  `legal_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Full legal name of the brand.',
  /* Additional fields omitted for brevity */
  PRIMARY KEY (`id`)
)
```

### Brands Users Table

The `brands_users` table manages relationships between brands and users.

```sql
CREATE TABLE `brands_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Value references ''brands(id)''',
  `user_id` int DEFAULT NULL COMMENT 'Value references ''users(id)''',
  `role_id` int DEFAULT '4' COMMENT 'Value references ''brandRoles(id)''',
  `active` enum('yes','no','pending','deleted','declined','rescinded') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'yes' COMMENT 'Current state of the users relationship with this brand.',
  `job_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Users job title with this brand.',
  `added_by` int DEFAULT NULL COMMENT 'Value references ''users(id)''',
  `timestamp_added` int DEFAULT NULL COMMENT 'Timestamp that this user has been added to this brand.',
  `deleted_by` int DEFAULT NULL COMMENT 'Value references ''users(id)''',
  `timestamp_deleted` int DEFAULT NULL COMMENT 'Timestamp that this user has been removed from this brand.',
  PRIMARY KEY (`id`)
)
```

### Collectives Table

The `collectives` table manages NIL collectives information and profiles.

```sql
CREATE TABLE `collectives` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `uniqueID` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available_balance` int DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  /* Additional fields omitted for brevity */
  PRIMARY KEY (`id`)
)
```

### Collectives Users Table

The `collectives_users` table manages relationships between collectives and users.

```sql
CREATE TABLE `collectives_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `collective_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `role_id` int DEFAULT '4',
  `active` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'yes',
  `job_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `verified` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  PRIMARY KEY (`id`)
)
```

## Content and Asset Tables

### Assets Table

The `assets` table provides a comprehensive asset management system.

```sql
CREATE TABLE `assets` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nanoid` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nanoid of the user that uploaded the asset.',
  `group_id` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'If images are uploaded in bulk, then they will have a matching group_id. 12 character nanoid.',
  `caption` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'User attached caption.',
  `usage_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `uploaded_by` char(36) DEFAULT NULL,
  `source_file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Original name of the uploaded asset.',
  /* Additional fields omitted for brevity */
  PRIMARY KEY (`id`)
)
```

### Collection Main Table

The `collection_main` table is the primary table for managing collections.

```sql
CREATE TABLE `collection_main` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `athlete_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
)
```

## Transaction Tables

### Deals Table

The `deals` table manages NIL deals between athletes and brands/collectives.

```sql
CREATE TABLE `deals` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uniqueID` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Unique id number for each deal.',
  `paid` tinyint DEFAULT '0' COMMENT '''1'' if deal has been paid. ''0'' if unpaid.',
  `charge_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'The charge id generated by Stripe.',
  `campaign_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Value references ''campaigns(id)''',
  `status` enum('saved','deleted','cart','under_review','approved','athlete_accepted','athlete_declined','expired','under_dispute','complete') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Current status of each deal.',
  /* Additional fields omitted for brevity */
  PRIMARY KEY (`id`)
)
```

### Pricing Table

The `pricing` table manages pricing information for services.

```sql
CREATE TABLE `pricing` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_id` int DEFAULT NULL,
  `active` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'no',
  `set_price` int DEFAULT NULL,
  `pricing` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'fixed',
  /* Additional fields omitted for brevity */
  PRIMARY KEY (`id`)
)
```

## School and Sports Tables

### Schools Table

The `schools` table manages school information and configurations.

```sql
CREATE TABLE `schools` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nanoid` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `mascot` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  /* Additional fields omitted for brevity */
  PRIMARY KEY (`id`),
  UNIQUE KEY `nanoid` (`nanoid`)
)
```

### Sports Table

The `sports` table manages sport information and configurations.

```sql
CREATE TABLE `sports` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `sport_name` varchar(100) NOT NULL,
  `abbreviation` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `icon` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int DEFAULT NULL,
  PRIMARY KEY (`id`)
)
```

### Positions Table

The `positions` table manages sport positions and abbreviations.

```sql
CREATE TABLE `positions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `sportID` int unsigned DEFAULT NULL,
  `position` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `positionAbbreviation` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)
```

### Pro Sports Table

The `pro_sports` table manages professional sports information.

```sql
CREATE TABLE `pro_sports` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pro_sport_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `abbreviation` varchar(10) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '''0'' if in-active (not visible). ''1'' if active and visible.',
  PRIMARY KEY (`id`)
)
```

## System Tables

### Activity Log Table

The `activity_log` table provides a comprehensive activity logging system.

```sql
CREATE TABLE `activity_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `activity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_agent` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `additional_data` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `timestamp` (`timestamp`)
)
```

### Email Log Table

The `email_log` table tracks email communication history.

```sql
CREATE TABLE `email_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `to_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_html` tinyint(1) NOT NULL DEFAULT '0',
  `attachments` text COLLATE utf8mb4_unicode_ci,
  `status` enum('success','failed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sent_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_sent_at` (`sent_at`),
  KEY `idx_to_address` (`to_address`)
)
```

### API Keys Table

The `api_keys` table manages API keys for secure third-party access.

```sql
CREATE TABLE `api_keys` (
  `id` int NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) NOT NULL,
  `api_key_hash` char(64) NOT NULL,
  `rate_limit` int DEFAULT '1000',
  `requests_made` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `expires_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `permissions` json DEFAULT NULL,
  PRIMARY KEY (`id`)
)
```

### Alert Messages Table

The `alert_messages` table stores system alert messages and their display properties.

```sql
CREATE TABLE `alert_messages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `message` text,
  `type` enum('PRIMARY','SUCCESS','DANGER','WARNING') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `icon` enum('INFO-CIRCLE-FILL','CHECK-CIRCLE-FILL','EXCLAMATION-OCTAGON-FILL','EXCLAMATION-TRIANGLE-FILL') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
)
```

### Landing Products Table

The `landing_products` table manages landing page product listings.

```sql
CREATE TABLE `landing_products` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `menu_sub_title` varchar(255) DEFAULT NULL,
  `active` int DEFAULT '1',
  PRIMARY KEY (`id`)
)
```

### Services Table

The `services` table manages service offerings and configurations.

```sql
CREATE TABLE `services` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'yes',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  /* Additional fields omitted for brevity */
  PRIMARY KEY (`id`)
)
```

### Workbench Activity Table

The `workbench_activity` table tracks workbench activity.

```sql
CREATE TABLE `workbench_activity` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `uuid_updated` char(36) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)
```

## Table Relationships

The database uses a relational model with relationships defined in the `database/relationships.json` file. Key relationships include:

1. **Users and Profiles**:
   - One-to-one relationship between `users` and `user_profiles`
   - One-to-one relationship between `users` and `user_flags`
   - One-to-one relationship between `users` and `user_metadata`
   - One-to-many relationship between `users` and `user_addresses`

2. **Users and Authentication**:
   - One-to-many relationship between `users` and `login_attempts`
   - One-to-many relationship between `users` and `verification_attempts`
   - One-to-many relationship between `users` and `banned_users`

3. **Users and Social Media**:
   - One-to-one relationship between `users` and `user_social_media`
   - One-to-many relationship between `users` and social media stats tables

4. **Users and Business Entities**:
   - Many-to-many relationship between `users` and `brands` through `brands_users`
   - Many-to-many relationship between `users` and `collectives` through `collectives_users`

5. **Users and Content**:
   - One-to-many relationship between `users` and `assets`
   - One-to-many relationship between `users` and `collection_main`

6. **Users and Transactions**:
   - One-to-many relationship between `users` and `deals`
   - One-to-many relationship between `users` and `pricing`

7. **Users and System**:
   - One-to-many relationship between `users` and `activity_log`
   - One-to-many relationship between `users` and `workbench_activity`

8. **Profile Relationships**:
   - One-to-many relationship between `roles` and `user_profiles`
   - One-to-one relationship between `assets` and `user_profiles` for profile and cover images
   - One-to-one relationship between `levels` and `user_profiles`
   - One-to-one relationship between `positions` and `user_profiles`
   - One-to-one relationship between `sports` and `user_profiles`
   - One-to-one relationship between `schools` and `user_profiles`

9. **Sports Relationships**:
   - One-to-many relationship between `sports` and `positions`

10. **School Relationships**:
    - One-to-many relationship between `schools` and `school_associations`
    - One-to-many relationship between `schools` and `school_conferences`

## Database Design Considerations

1. **No Foreign Key Constraints**: The database does not use FOREIGN KEY constraints, assuming PlanetScale as the database, and manages referential integrity through application code.

2. **UUID Usage**: Many tables use UUIDs for unique identification, providing better security and distribution capabilities.

3. **Timestamps**: Most tables include `created_at` and `updated_at` timestamps for tracking record creation and modification times.

4. **Soft Deletes**: Some tables implement soft deletes through status fields rather than actually deleting records.

5. **JSON Data**: Some tables use JSON columns for storing flexible, schema-less data.

6. **Enums**: The database uses ENUM types for fields with a fixed set of possible values.

7. **Indexing**: Key fields are indexed for better query performance.

8. **Comments**: Many fields include comments describing their purpose and usage.
