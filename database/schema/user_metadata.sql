/*
 * User Metadata Table
 * ------------------
 * Technical and system-related user data.
 * Stores registration and terms acceptance information.
 */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
