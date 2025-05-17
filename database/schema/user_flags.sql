/*
 * User Flags Table
 * ---------------
 * Boolean flags for user status and permissions.
 * Handles feature access and account status flags.
 */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
