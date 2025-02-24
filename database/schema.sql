

/*
 * Activity Log Table
 * -----------------
 * Comprehensive activity logging system.
 * Tracks user actions and system events.
 */
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * Alert Messages Table
 * ------------------
 * Stores system alert messages and their display properties.
 * Used for showing notifications and alerts to users.
 */
# ------------------------------------------------------------

CREATE TABLE `alert_messages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `message` text,
  `type` enum('PRIMARY','SUCCESS','DANGER','WARNING') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `icon` enum('INFO-CIRCLE-FILL','CHECK-CIRCLE-FILL','EXCLAMATION-OCTAGON-FILL','EXCLAMATION-TRIANGLE-FILL') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*
 * User Roles Table
 * ------------------
 * Type of user roles.
 * References the `role_id` column in the `user_profiles` table.
 */
# ------------------------------------------------------------
CREATE TABLE `roles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'References ''role_id'' in ''user_profiles'' table.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


/*
 * API Keys Table
 * -------------
 * Manages API keys for secure third-party access.
 * Tracks key usage, permissions, and expiration.
 */
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * Assets Table
 * -----------
 * Comprehensive asset management system.
 * Handles uploaded files with metadata, optimization, and thumbnails.
 */
# ------------------------------------------------------------

CREATE TABLE `assets` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nanoid` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nanoid of the user that uploaded the asset.',
  `group_id` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'If images are uploaded in bulk, then they will have a matching group_id. 12 character nanoid.',
  `caption` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'User attached caption.',
  `usage_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `uploaded_by` char(36) DEFAULT NULL,
  `source_file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Original name of the uploaded asset.',
  `source_file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Path to the original asset.',
  `source_file_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'File type/mime of the original uploaded asset.',
  `source_file_size` bigint DEFAULT NULL COMMENT 'File size in bytes of the original asset.',
  `source_file_height` int DEFAULT NULL COMMENT 'Height in pixels of the original asset.',
  `source_file_width` int DEFAULT NULL COMMENT 'Width in pixels of the original asset.',
  `compressed_file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'File name for the asset after optimization.',
  `compressed_cdn_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `compressed_file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Path to the optimized asset.',
  `compressed_file_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'File type/mime of the optimized asset.',
  `compressed_file_size` bigint DEFAULT NULL COMMENT 'File size in bytes of the optimzed asset.',
  `compressed_file_height` int DEFAULT NULL COMMENT 'Height in pixels of the optimzed asset.',
  `compressed_file_width` int DEFAULT NULL COMMENT 'Width in pixels of the optimized asset.',
  `thumbnail_file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'File name of the thumbnail image.',
  `thumbnail_cdn_path` varchar(255) DEFAULT NULL,
  `thumbnail_file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Path of the thumbnail image.',
  `thumbnail_file_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'File type/mime of the thumbnail.',
  `thumbnail_file_size` bigint DEFAULT NULL COMMENT 'Size in bytes of the thumbnail image.',
  `thumbnail_file_height` int DEFAULT NULL COMMENT 'Height in pixels of the thumbnail image.',
  `thumbnail_file_width` int DEFAULT NULL COMMENT 'Width in pixels of the thumbnail image.',
  `duration` int DEFAULT NULL COMMENT 'Duration in seconds of the asset.',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp the asset was uploaded.',
  `metadata` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'Metadata from the original uploaded asset.',
  `moderation_score` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Score that the image recieved back from moderation.',
  `privacy` enum('PUBLIC','PRIVATE') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'PUBLIC' COMMENT 'Privacy setting of the image. To be displayed public or private.',
  `status` enum('ACTIVE','ARCHIVED','DELETED','FLAGGED') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Status of the image.',
  `archived_at` timestamp NULL DEFAULT NULL COMMENT 'Timestamp the user archived the asset.',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Timestamp image was deleted on.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * Banned Users Table
 * -----------------
 * Tracks banned users and ban details.
 * Maintains history of account bans.
 */
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * Brands Table
 * -----------
 * Stores information about brands/companies.
 * Manages brand profiles, social media, and business details.
 */
# ------------------------------------------------------------

CREATE TABLE `brands` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Username of the brand.',
  `uniqueID` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Unique id generated for each brand. This will always start with with "B_".',
  `active` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'yes' COMMENT 'Is this brand currently active? ''yes'' if YES. ''no'' if NO.',
  `available_balance` int DEFAULT '0' COMMENT 'Available balance for NIL deals. Example ''10000'' equals ''100.00''.',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Name to be displayed for the brand.',
  `legal_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Full legal name of the brand.',
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Hash tags the brand has selected to describe itself.',
  `url_website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'URL to the website of the brand.',
  `facebook_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Brands Facebook username.',
  `twitter_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Brands Twitter/X username.',
  `instagram_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Brands Instagram username.',
  `tiktok_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Brands TikTok username.',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Phone number for the brand.',
  `banned` int DEFAULT '0' COMMENT 'Is the brand banned? ''1'' if YES, ''0'' if NO.',
  `accept_pitches` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Does this brand allow athletes to send them pitches for NIL deals? ''yes'' if YES. ''no'' if NO.',
  `verified` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'no' COMMENT 'Has the brand been verified? ''yes'' if YES. ''no'' if NO.',
  `logo_url` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'URL of the brands logo.',
  `created_by` int DEFAULT NULL COMMENT '''id'' of the user that created the brand.',
  `created_on` int DEFAULT NULL COMMENT 'Timestamp that the user created the account.',
  `coverImageURL` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'URL of the cover image for the brands profile.',
  `profileImageURL` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'URL of the profile image for the brand.',
  `profile` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Profile information about the brand.',
  `display_website` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Display the website of the company on the brand profile? ''NULL'' or ''yes'' if YES. ''no'' if NO.',
  `display_facebook` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Display the Facebook of the company on the brand profile? ''NULL'' or ''yes'' if YES. ''no'' if NO.',
  `display_twitter` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Display the Twitter/X of the company on the brand profile? ''NULL'' or ''yes'' if YES. ''no'' if NO.',
  `display_instagram` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Display the Instagram of the company on the brand profile? ''NULL'' or ''yes'' if YES. ''no'' if NO.',
  `display_tiktok` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Display the TikTok of the company on the brand profile? ''NULL'' or ''yes'' if YES. ''no'' if NO.',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Address of the brand.',
  `address_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Second line of the address of the brand if applicable.',
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Address city of the brand.',
  `state` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Address state of the brand.',
  `zipcode` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Address zipcode of the brand.',
  `display_address` int DEFAULT '1' COMMENT 'Display the address of the brand on their profile page? ''1'' if YES. ''0'' if NO.',
  `imported` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Has the brand been imported manually? ''1'' if YES. ''NULL'' if NO.',
  `claimed` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Has the brand been claimed? ''1'' if YES. ''NULL'' if NO.',
  `email` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Email address of the brand.',
  `allow_messages` int DEFAULT '1' COMMENT 'Does the brand allow messages to be sent to them? ''1'' if YES. ''0'' if NO.',
  `allow_pitches` int DEFAULT '1' COMMENT 'Does the brand allow NIL pitches to be sent to them? ''1'' if YES. ''0'' if NO.',
  `display_profile` int DEFAULT '1' COMMENT 'Does the brand want to display their profile on PeakNIL? ''1'' if YES. ''0'' if NO.',
  `brand_type` enum('local','nationwide','both') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Is the brand a ''local'' brand, ''nationwide'' brand, or ''both''.',
  `delete` int DEFAULT '0' COMMENT 'Has the brand requested to be deleted? ''0'' if NO. ''1'' if YES.',
  `delete_request_id` int DEFAULT NULL COMMENT 'ID of the user that requested deletion. References ''users(id)''.',
  `delete_request_timestamp` int DEFAULT NULL COMMENT 'Timestamp of the deletion request.',
  `fee_percent` decimal(5,3) DEFAULT '0.200' COMMENT 'Custom fee percentage for this brand.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



/*
 * Brands Users Table
 * ----------------
 * Manages relationships between brands and users.
 * Tracks user roles, permissions and status within brands.
 */
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



/*
 * Collection Main Table
 * -------------------
 * Primary table for managing collections.
 * Links athletes to collections for organization and grouping.
 */
# ------------------------------------------------------------

CREATE TABLE `collection_main` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `athlete_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * Collectives Table
 * ---------------
 * Manages NIL collectives information and profiles.
 * Stores collective details, social media, and operational settings.
 */
# ------------------------------------------------------------

CREATE TABLE `collectives` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `uniqueID` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `available_balance` int DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `url_website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `facebook_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `twitter_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `instagram_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tiktok_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `banned` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accept_pitches` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'yes',
  `verified` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `timestampCreated` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_on` int DEFAULT NULL,
  `coverImageURL` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profileImageURL` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `display_website` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_facebook` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_twitter` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_instagram` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_tiktok` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete` tinyint(1) DEFAULT '0',
  `fee_percent` decimal(5,3) DEFAULT '0.200',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



/*
 * Collectives Users Table
 * ---------------------
 * Manages relationships between collectives and users.
 * Tracks user roles and status within collectives.
 */
# ------------------------------------------------------------

CREATE TABLE `collectives_users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `collective_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `role_id` int DEFAULT '4',
  `active` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'yes',
  `job_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `verified` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



/*
 * Deals Table
 * ----------
 * Manages NIL deals between athletes and brands/collectives.
 * Tracks deal status, pricing, and transaction details.
 */
# ------------------------------------------------------------

CREATE TABLE `deals` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `uniqueID` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Unique id number for each deal.',
  `paid` tinyint DEFAULT '0' COMMENT '''1'' if deal has been paid. ''0'' if unpaid.',
  `charge_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'The charge id generated by Stripe.',
  `campaign_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Value references ''campaigns(id)''',
  `status` enum('saved','deleted','cart','under_review','approved','athlete_accepted','athlete_declined','expired','under_dispute','complete') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Current status of each deal.',
  `secondary_status` enum('content_algo_flagged','content_human_flagged','fail_algo','pass_algo','pass_manual','fail_manual','athlete_failure','pending_complete','client_complete','client_fail','retention_closed','escalated','paid','mediation_pending','mediation_client','mediation_athlete','mediation_split','mediation_other') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Current secondary status of each deal if applicable.',
  `athlete_id` int DEFAULT NULL COMMENT 'Value references ''users(id)''',
  `service_id` int DEFAULT NULL COMMENT 'Value references ''nilUsers(id)''',
  `platform_service_id` int DEFAULT NULL COMMENT 'Value references ''nilServices(id)''',
  `client_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT '''id'' of the client. If value is only numerical then it references the ''id'' from the ''users'' table. If value begings with ''B_'' the the client is a brand and the value references ''uniqueID(brands)''. If value begins with ''C_'' then the client is a NIL collective and the value references ''uniqueID(collectives)''.',
  `submitter_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'The ''id'' of the person that send the deal. Value references ''users(id)''.',
  `overview` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'Overview of the NIL deal.',
  `overview_content_id` varchar(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Value references ''content_unique_id(content_moderation)''',
  `time_sensitive` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'Input from the user regarding the time sensitive nature of the deal.',
  `time_sensitive_content_id` varchar(26) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Value references ''content_unique_id(content_moderation)''',
  `start_date` date DEFAULT NULL COMMENT 'Start date of the NIL deal.',
  `end_date` date DEFAULT NULL COMMENT 'End date of the NIL deal.',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date the NIL was created.',
  `price` int DEFAULT NULL COMMENT 'Price of the NIL deal.',
  `best_offer` int DEFAULT NULL COMMENT 'Price of the NIL deal if a ''Best Offer'' price has been submitted.',
  `tip_added` tinyint DEFAULT '0' COMMENT 'Has the client added a tip to the NIL deal? ''1'' if YES. ''0'' if NO.',
  `tip_amount` int DEFAULT '0' COMMENT 'Amount of the tip added by the client.',
  `expedite` tinyint DEFAULT '0' COMMENT 'Has the client paid to have the deal expedited? ''1'' if YES. ''0'' if NO.',
  `expedite_amount` int DEFAULT '0' COMMENT 'Cost of the expedited services.',
  `service_fee` int DEFAULT NULL COMMENT 'Amount charged for the service fee on this deal.',
  `service_fee_percent` decimal(5,3) DEFAULT NULL COMMENT 'Percentage charged for the service fee.',
  `total` int DEFAULT NULL COMMENT 'Total amount charged for the NIL deal.',
  `timestamp_athlete_accepted` int DEFAULT NULL COMMENT 'The timestamp that the athlete accepted to work this NIL deal.',
  `timestamp_athlete_declined` int DEFAULT NULL COMMENT 'The timestamp that the athlete declined to work this NIL deal.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * Email Log Table
 * -------------
 * Tracks email communication history.
 * Records email details, status, and errors.
 */
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



/*
 * Landing Products Table
 * -------------------
 * Manages landing page product listings.
 * Tracks product details and visibility status.
 */
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * Levels Table
 * ----------
 * Manages different user access levels.
 * Tracks user permissions and system roles.
 */
# ------------------------------------------------------------

CREATE TABLE `levels` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `level` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * Login Attempts Table
 * -----------------
 * Tracks user login attempts and security details.
 * Monitors suspicious activity and potential breaches.
 */
# ------------------------------------------------------------

CREATE TABLE `login_attempts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempt_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ip_email` (`ip_address`,`email`),
  KEY `idx_attempt_time` (`attempt_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



/*
 * Positions Table
 * -------------
 * Manages sport positions and abbreviations.
 * Tracks player roles within sports teams.
 */
# ------------------------------------------------------------

CREATE TABLE `positions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `sportID` int unsigned DEFAULT NULL,
  `position` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `positionAbbreviation` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



/*
 * Pricing Table
 * ------------
 * Manages pricing information for services.
 * Tracks pricing models, discounts, and fees.
 */
# ------------------------------------------------------------

CREATE TABLE `pricing` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `uuid` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_id` int DEFAULT NULL,
  `active` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'no',
  `set_price` int DEFAULT NULL,
  `pricing` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'fixed',
  `make_offer` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'no',
  `custom_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `custom_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `expedite_enabled` tinyint DEFAULT '0',
  `expedite_deal_price` int DEFAULT '10000',
  `expedite_deal_percent` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0.3',
  `peak_deal_fee` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accept_tips` tinyint DEFAULT '1',
  `custom_terms_and_conditions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `custom_usage_rights` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



/*
 * Pro Sports Table
 * ---------------
 * Manages professional sports information.
 * Tracks sport names, abbreviations, and visibility status.
 */
# ------------------------------------------------------------

CREATE TABLE `pro_sports` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `pro_sport_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `abbreviation` varchar(10) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '''0'' if in-active (not visible). ''1'' if active and visible.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * Schools Table
 * ------------
 * Manages school information and configurations.
 * Tracks school details, branding, and sports affiliations.
 */
# ------------------------------------------------------------

CREATE TABLE `schools` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nanoid` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `mascot` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `logo_set` tinyint(1) DEFAULT '0' COMMENT '''1'' if the school logo has been uploaded to AWS. ''0'' if no.',
  `address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `zip` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `compliance_email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `compliance_phone` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `association_id` int DEFAULT NULL,
  `conference_id` int DEFAULT NULL,
  `active` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'yes',
  `peak_branding` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT 'yes',
  `peak_logo_color` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT 'light',
  `marketplace_text` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `type` varchar(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `abbreviation` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `altName1` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `altName2` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `altName3` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `conference` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `division` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '',
  `color` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `altColor` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `textColor` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cardColor1` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cardColor2` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `buttonColor` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `selectColor` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `logoDark` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `logoLight` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `secondary_address` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `countryCode` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `timezone` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `latitude` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `longitude` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `elevation` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `footballVenueID` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `footballVenue` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `footballVenueCapacity` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `footballVenueYearConstructed` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `footballVenueGrass` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `footballVenueDome` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `schoolFacebookUsername` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `schoolInstagramUsername` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `schoolTwitterUsername` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `schoolTikTokUsername` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `schoolYouTubeUsername` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `athletic_url` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `public_or_private` varchar(7) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `football_classification` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `cover_photo` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT 'off',
  `cover_photo_url_1` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cover_photo_url_2` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cover_photo_url_3` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cover_photo_url_4` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cover_photo_url_5` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `cover_photo_url_6` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `hbcu` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `document_sla` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `document_saas_order_form` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `marketplace_logo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `white_label_logo_height` int DEFAULT '24',
  `navbar_logo_height` int DEFAULT '24',
  `button_color` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT 'dark',
  `white_label` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT 'no',
  `sport_101` tinyint(1) DEFAULT '1',
  `sport_102` tinyint(1) DEFAULT '1',
  `sport_103` tinyint(1) DEFAULT '1',
  `sport_104` tinyint(1) DEFAULT '1',
  `sport_105` tinyint(1) DEFAULT '1',
  `sport_106` tinyint(1) DEFAULT '1',
  `sport_107` tinyint(1) DEFAULT '1',
  `sport_108` tinyint(1) DEFAULT '1',
  `sport_109` tinyint(1) DEFAULT '1',
  `sport_110` tinyint(1) DEFAULT '1',
  `sport_111` tinyint(1) DEFAULT '1',
  `sport_112` tinyint(1) DEFAULT '1',
  `sport_113` tinyint(1) DEFAULT '1',
  `sport_114` tinyint(1) DEFAULT '1',
  `sport_115` tinyint(1) DEFAULT '1',
  `sport_116` tinyint(1) DEFAULT '1',
  `sport_117` tinyint(1) DEFAULT '1',
  `sport_118` tinyint(1) DEFAULT '1',
  `sport_119` tinyint(1) DEFAULT '1',
  `sport_120` tinyint(1) DEFAULT '1',
  `sport_121` tinyint(1) DEFAULT '1',
  `sport_122` tinyint(1) DEFAULT '1',
  `sport_123` tinyint(1) DEFAULT '1',
  `sport_124` tinyint(1) DEFAULT '1',
  `sport_125` tinyint(1) DEFAULT '1',
  `sport_126` tinyint(1) DEFAULT '1',
  `sport_127` tinyint(1) DEFAULT '1',
  `sport_128` tinyint(1) DEFAULT '1',
  `sport_129` tinyint(1) DEFAULT '1',
  `sport_130` tinyint(1) DEFAULT '1',
  `sport_131` tinyint(1) DEFAULT '1',
  `sport_132` tinyint(1) DEFAULT '1',
  `sport_133` tinyint(1) DEFAULT '1',
  `sport_134` tinyint(1) DEFAULT '1',
  `sport_135` tinyint(1) DEFAULT '1',
  `sport_136` tinyint(1) DEFAULT '1',
  `sport_137` tinyint(1) DEFAULT '1',
  `sport_138` tinyint(1) DEFAULT '1',
  `sport_139` tinyint(1) DEFAULT '1',
  `sport_140` tinyint(1) DEFAULT '1',
  `sport_141` tinyint(1) DEFAULT '1',
  `sport_142` tinyint(1) DEFAULT '1',
  `sport_143` tinyint(1) DEFAULT '1',
  `sport_144` tinyint(1) DEFAULT '1',
  `sport_145` tinyint(1) DEFAULT '1',
  `sport_146` tinyint(1) DEFAULT '1',
  `sport_147` tinyint(1) DEFAULT '1',
  `sport_148` tinyint(1) DEFAULT '1',
  `sport_149` tinyint(1) DEFAULT '1',
  `sport_150` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nanoid` (`nanoid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;



/*
 * Services Table
 * -------------
 * Manages service offerings and configurations.
 * Tracks service details, terms, and usage rights.
 */
# ------------------------------------------------------------

CREATE TABLE `services` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'yes',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `brandTerms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `athleteTerms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `termsAndConditions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `usageRights` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tags` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `field_1_display` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'display',
  `field_1_placeholder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `field_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `field_2_display` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'display',
  `field_2_placeholder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `field_3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `field_3_display` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'display',
  `field_3_placeholder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `field_4` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `field_4_display` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'display',
  `field_4_placeholder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `field_5` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `field_5_display` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'display',
  `field_5_placeholder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `field_6` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `field_6_display` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'display',
  `field_6_placeholder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `field_7` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `field_7_display` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'display',
  `field_7_placeholder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `field_8` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `field_8_display` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'display',
  `field_8_placeholder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `field_9` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `field_9_display` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'display',
  `field_9_placeholder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `field_10` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `field_10_display` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'display',
  `field_10_placeholder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



/*
 * Social Media Stats Instagram Table
 * ------------------------------
 * Tracks Instagram account statistics and metrics.
 * Monitors follower count, engagement, and content performance.
 */
# ------------------------------------------------------------

CREATE TABLE `social_media_stats_instagram` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `follower_count` int unsigned DEFAULT NULL,
  `following_count` int unsigned DEFAULT NULL,
  `media_count` int DEFAULT NULL,
  `recorded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `error` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * Social Media Stats TikTok Table
 * ---------------------------
 * Tracks TikTok account statistics and metrics.
 * Monitors follower count, engagement, and content performance.
 */
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * Social Media Stats X Table
 * -----------------------
 * Tracks X (Twitter) account statistics and metrics.
 * Monitors follower count, engagement, and content performance.
 */
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * Sports Table
 * -----------
 * Manages sport information and configurations.
 * Tracks sport names, abbreviations, and visibility status.
 */
# ------------------------------------------------------------

CREATE TABLE `sports` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `sport_name` varchar(100) NOT NULL,
  `abbreviation` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `icon` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * User Addresses Table
 * -----------------
 * Manages user address information.
 * Tracks different types of addresses for users.
 */
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * User Flags Table
 * -------------
 * Tracks user account flags and system statuses.
 * Manages user permissions, bans, and special access rights.
 */
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * User Metadata Table
 * ----------------
 * Stores additional user information and preferences.
 * Tracks user activity, device details, and system interactions.
 */
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * User Profiles Table
 * ----------------
 * Stores detailed user profile information.
 * Tracks personal details, preferences, and social media links.
 */
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * User Social Media Table
 * -------------------
 * Tracks user social media account information.
 * Stores usernames and profiles across different platforms.
 */
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



/*
 * Users Table
 * ---------
 * Core user information and authentication details.
 * Manages user accounts, status, and security settings.
 */
# ------------------------------------------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



/*
 * Verification Attempts Table
 * ------------------------
 * Tracks user verification attempts and security details.
 * Monitors email verification processes and status.
 */
# ------------------------------------------------------------

CREATE TABLE `verification_attempts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `attempted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_last_attempt` (`user_id`,`attempted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table workbench_activity
# ------------------------------------------------------------

CREATE TABLE `workbench_activity` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `uuid_updated` char(36) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
