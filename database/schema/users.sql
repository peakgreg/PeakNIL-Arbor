/*
 * Core Users Table
 * ---------------
 * Primary table for user authentication and basic information.
 * This table handles core authentication and should be kept minimal.
 */

CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `username` varchar(255) DEFAULT NULL COMMENT 'Username of the user.',
  `email` varchar(50) DEFAULT NULL COMMENT 'Users email address.',
  `email_verified` tinyint(1) DEFAULT '0' COMMENT 'Has the user confirmed their email address.',
  `email_confirmation_code` int DEFAULT NULL COMMENT 'Email confirmation code.',
  `password_hash` varchar(255) NOT NULL COMMENT 'Users password.',
  `status` enum('active','inactive','banned') DEFAULT 'active',
  `last_login` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
