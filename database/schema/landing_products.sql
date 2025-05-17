/*
 * Landing Products Table
 * --------------------
 * Manages products displayed on landing pages.
 * Controls product visibility and presentation.
 */

CREATE TABLE `landing_products` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'Product name',
  `color` varchar(20) DEFAULT NULL COMMENT 'Color theme for product display',
  `category` varchar(255) DEFAULT NULL COMMENT 'Product category',
  `slug` varchar(255) DEFAULT NULL COMMENT 'URL-friendly product identifier',
  `icon` varchar(30) DEFAULT NULL COMMENT 'Product icon identifier',
  `menu_sub_title` varchar(255) DEFAULT NULL COMMENT 'Subtitle shown in menu',
  `active` int DEFAULT '1' COMMENT 'Product visibility status (1=active, 0=inactive)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
