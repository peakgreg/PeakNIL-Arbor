/*
 * Collection Main Table
 * -------------------
 * Primary table for managing collections.
 * Links athletes to collections for organization and grouping.
 */

CREATE TABLE `collection_main` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `athlete_id` int DEFAULT NULL COMMENT 'References the athlete ID for this collection entry',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
