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