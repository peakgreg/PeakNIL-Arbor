/*
 * Brands Users Table
 * ----------------
 * Manages relationships between brands and users.
 * Tracks user roles, permissions and status within brands.
 */

CREATE TABLE `brands_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Value references ''brands(id)''',
  `user_id` int DEFAULT NULL COMMENT 'Value references ''users(id)''',
  `role_id` int DEFAULT '4' COMMENT 'Value references ''brandRoles(id)''',
  `active` enum('yes','no','pending','deleted','declined','rescinded') DEFAULT 'yes' COMMENT 'Current state of the users relationship with this brand.',
  `job_title` varchar(255) DEFAULT NULL COMMENT 'Users job title with this brand.',
  `added_by` int DEFAULT NULL COMMENT 'Value references ''users(id)''',
  `timestamp_added` int DEFAULT NULL COMMENT 'Timestamp that this user has been added to this brand.',
  `deleted_by` int DEFAULT NULL COMMENT 'Value references ''users(id)''',
  `timestamp_deleted` int DEFAULT NULL COMMENT 'Timestamp that this user has been removed from this brand.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
