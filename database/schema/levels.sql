/*
 * Levels Table
 * -----------
 * Defines user experience levels.
 * Used for categorizing and organizing users based on their level of expertise or status.
 */

CREATE TABLE `levels` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `level` varchar(50) DEFAULT NULL COMMENT 'Name/description of the level',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
