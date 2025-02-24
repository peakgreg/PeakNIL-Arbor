/*
 * Positions Table
 * -------------
 * Stores athletic positions for different sports.
 * Maps positions to sports and includes abbreviations.
 */

CREATE TABLE `positions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `sportID` int unsigned DEFAULT NULL COMMENT 'References sports table ID',
  `position` varchar(255) DEFAULT NULL COMMENT 'Full name of the position',
  `positionAbbreviation` varchar(11) DEFAULT NULL COMMENT 'Abbreviated position name',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
