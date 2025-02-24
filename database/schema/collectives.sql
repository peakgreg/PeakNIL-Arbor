/*
 * Collectives Table
 * ---------------
 * Manages NIL collectives information and profiles.
 * Stores collective details, social media, and operational settings.
 */

CREATE TABLE `collectives` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL COMMENT 'Username of the collective',
  `uniqueID` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unique identifier for the collective',
  `available_balance` int DEFAULT '0' COMMENT 'Available balance for transactions',
  `name` varchar(255) DEFAULT NULL COMMENT 'Display name of the collective',
  `url_website` varchar(255) DEFAULT NULL COMMENT 'Website URL',
  `facebook_username` varchar(255) DEFAULT NULL COMMENT 'Facebook username',
  `twitter_username` varchar(255) DEFAULT NULL COMMENT 'Twitter/X username',
  `instagram_username` varchar(255) DEFAULT NULL COMMENT 'Instagram username',
  `tiktok_username` varchar(255) DEFAULT NULL COMMENT 'TikTok username',
  `phone` varchar(20) DEFAULT NULL COMMENT 'Contact phone number',
  `banned` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Banned status (yes/no)',
  `accept_pitches` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Whether collective accepts pitches',
  `active` varchar(3) DEFAULT 'yes' COMMENT 'Active status',
  `verified` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'no' COMMENT 'Verification status',
  `timestampCreated` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Creation timestamp',
  `logo_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'URL to collective logo',
  `created_by` int DEFAULT NULL COMMENT 'User ID of creator',
  `created_on` int DEFAULT NULL COMMENT 'Creation timestamp',
  `coverImageURL` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Cover image URL',
  `profileImageURL` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Profile image URL',
  `profile` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Profile description',
  `display_website` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Show website on profile',
  `display_facebook` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Show Facebook on profile',
  `display_twitter` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Show Twitter on profile',
  `display_instagram` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Show Instagram on profile',
  `display_tiktok` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Show TikTok on profile',
  `delete` tinyint(1) DEFAULT '0' COMMENT 'Deletion flag',
  `fee_percent` decimal(5,3) DEFAULT '0.200' COMMENT 'Custom fee percentage',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
