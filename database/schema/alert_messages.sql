/*
 * Alert Messages Table
 * ------------------
 * Stores system alert messages and their display properties.
 * Used for showing notifications and alerts to users.
 */

CREATE TABLE `alert_messages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `message` text,
  `type` enum('PRIMARY','SUCCESS','DANGER','WARNING') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `icon` enum('INFO-CIRCLE-FILL','CHECK-CIRCLE-FILL','EXCLAMATION-OCTAGON-FILL','EXCLAMATION-TRIANGLE-FILL') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
