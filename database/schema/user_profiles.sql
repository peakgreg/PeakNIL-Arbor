/*
 * User Profiles Table
 * ------------------
 * Extended user information and profile data.
 * Contains all non-authentication related user information.
 */

CREATE TABLE `user_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `uuid` char(36) DEFAULT NULL COMMENT 'UUID of user.',
  `first_name` varchar(50) DEFAULT NULL COMMENT 'First name of user.',
  `middle_name` varchar(50) DEFAULT NULL COMMENT 'Middle name of user.',
  `last_name` varchar(50) DEFAULT NULL COMMENT 'Last name of user.',
  `date_of_birth` date DEFAULT NULL COMMENT 'DOB of user.',
  `access_level` int unsigned DEFAULT '1' COMMENT 'User access level.',
  `role_id` tinyint unsigned DEFAULT '1' COMMENT 'Role of the user.',
  `us_citizen` tinyint(1) DEFAULT '0' COMMENT 'Citizenship status.',
  `gender` enum('m','f','o') DEFAULT NULL COMMENT 'Gender of user.',
  `phone_number` varchar(20) DEFAULT NULL COMMENT 'Phone number of user.',
  `profile_image_id` bigint unsigned DEFAULT NULL COMMENT 'Profile image ID.',
  `cover_image_id` bigint unsigned DEFAULT NULL COMMENT 'Cover image ID.',
  `profile_description` text,
  `referral_code` varchar(12) DEFAULT NULL COMMENT 'Users referral code.',
  `additional_data` json DEFAULT NULL COMMENT 'Additional flexible attributes.',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
