/*
 * Banned Users Table
 * -----------------
 * Tracks banned users and ban details.
 * Maintains history of account bans.
 */

CREATE TABLE `banned_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `uuid` char(36) NOT NULL,
  `banned_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `banned_by` int unsigned DEFAULT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `banned_by` (`banned_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
