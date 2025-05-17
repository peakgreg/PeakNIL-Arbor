/*
 * Collectives Users Table
 * ---------------------
 * Manages relationships between collectives and users.
 * Tracks user roles and status within collectives.
 */

CREATE TABLE `collectives_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `collective_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'References collective ID',
  `user_id` int DEFAULT NULL COMMENT 'References user ID',
  `role_id` int DEFAULT '4' COMMENT 'User role within collective',
  `active` varchar(3) DEFAULT 'yes' COMMENT 'Active status of relationship',
  `job_title` varchar(255) DEFAULT NULL COMMENT 'User job title in collective',
  `verified` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'no' COMMENT 'Verification status',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
