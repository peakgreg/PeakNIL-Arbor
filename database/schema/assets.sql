/*
 * Assets Table
 * -----------
 * Comprehensive asset management system.
 * Handles uploaded files with metadata, optimization, and thumbnails.
 */

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
  `thumbnail_cdn_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
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
