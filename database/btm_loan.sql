/*
 Navicat Premium Data Transfer

 Source Server         : Localhost MySQL
 Source Server Type    : MySQL
 Source Server Version : 80034 (8.0.34)
 Source Host           : localhost:3306
 Source Schema         : btm_loan

 Target Server Type    : MySQL
 Target Server Version : 80034 (8.0.34)
 File Encoding         : 65001

 Date: 19/08/2025 07:47:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for btm_approval
-- ----------------------------
DROP TABLE IF EXISTS `btm_approval`;
CREATE TABLE `btm_approval`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nostaf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `active` tinyint NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of btm_approval
-- ----------------------------
INSERT INTO `btm_approval` VALUES (1, '2262007', 1, NULL, '2024-12-19 17:40:43', '2024-12-19 17:40:43');
INSERT INTO `btm_approval` VALUES (2, '10432014', 1, NULL, '2024-12-19 17:40:43', '2024-12-19 17:40:43');
INSERT INTO `btm_approval` VALUES (3, '11802017', 1, NULL, '2024-12-21 09:58:37', '2024-12-21 09:58:37');

-- ----------------------------
-- Table structure for cache
-- ----------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache
-- ----------------------------
INSERT INTO `cache` VALUES ('btm_request_system_cache_a75f3f172bfb296f2e10cbfc6dfc1883', 'i:1;', 1755519301);
INSERT INTO `cache` VALUES ('btm_request_system_cache_a75f3f172bfb296f2e10cbfc6dfc1883:timer', 'i:1755519301;', 1755519301);
INSERT INTO `cache` VALUES ('btm_request_system_cache_f1f70ec40aaa556905d4a030501c0ba4', 'i:5;', 1755520912);
INSERT INTO `cache` VALUES ('btm_request_system_cache_f1f70ec40aaa556905d4a030501c0ba4:timer', 'i:1755520912;', 1755520912);

-- ----------------------------
-- Table structure for cache_locks
-- ----------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks`  (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cache_locks
-- ----------------------------

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'Network Peripheral', '2024-12-19 17:40:42', '2024-12-19 17:40:42');
INSERT INTO `categories` VALUES (2, 'Audio Visual Apparatus', '2024-12-19 17:40:42', '2024-12-19 17:40:42');
INSERT INTO `categories` VALUES (3, 'Computers And Notebooks', '2024-12-19 17:40:43', '2024-12-19 17:40:43');

-- ----------------------------
-- Table structure for dept_approval
-- ----------------------------
DROP TABLE IF EXISTS `dept_approval`;
CREATE TABLE `dept_approval`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nostaf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kod_jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `active` tinyint NULL DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dept_approval
-- ----------------------------
INSERT INTO `dept_approval` VALUES (1, '0021995', 'PUSH', 1, NULL, '2024-12-19 18:14:19', '2024-12-19 18:14:19');

-- ----------------------------
-- Table structure for email_group_members
-- ----------------------------
DROP TABLE IF EXISTS `email_group_members`;
CREATE TABLE `email_group_members`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email_application_id` bigint UNSIGNED NOT NULL,
  `department_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_staff` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of email_group_members
-- ----------------------------
INSERT INTO `email_group_members` VALUES (1, 2, 'B2P', 'hilmichehalim@unishams.edu.my', NULL, '2025-01-24 15:48:31', '2025-01-24 15:48:31');

-- ----------------------------
-- Table structure for email_registration_applications
-- ----------------------------
DROP TABLE IF EXISTS `email_registration_applications`;
CREATE TABLE `email_registration_applications`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nostaf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `approver_staff` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approver_date` datetime NULL DEFAULT NULL,
  `approver_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `approver_status_id` tinyint NULL DEFAULT NULL,
  `btm_approver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `btm_date` datetime NULL DEFAULT NULL,
  `btm_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status_email_id` tinyint NULL DEFAULT NULL,
  `group_email` tinyint NULL DEFAULT NULL,
  `active` tinyint NULL DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of email_registration_applications
-- ----------------------------
INSERT INTO `email_registration_applications` VALUES (1, '12362020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, 1, NULL, '2024-12-19 18:49:07', '2024-12-19 18:49:07');
INSERT INTO `email_registration_applications` VALUES (2, '12362020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, 1, NULL, '2025-01-24 15:48:31', '2025-01-24 15:48:31');

-- ----------------------------
-- Table structure for email_suggestions
-- ----------------------------
DROP TABLE IF EXISTS `email_suggestions`;
CREATE TABLE `email_suggestions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email_application_id` bigint UNSIGNED NOT NULL,
  `email_suggestion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `temp_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approved_email` int NULL DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of email_suggestions
-- ----------------------------
INSERT INTO `email_suggestions` VALUES (1, 1, 'sdfsdfsdf', NULL, NULL, NULL, '2024-12-19 18:49:07', '2024-12-19 18:49:07');
INSERT INTO `email_suggestions` VALUES (2, 1, 'zxczxc', NULL, NULL, NULL, '2024-12-19 18:49:07', '2024-12-19 18:49:07');
INSERT INTO `email_suggestions` VALUES (3, 2, 'xcvxcvxcv', NULL, NULL, NULL, '2025-01-24 15:48:31', '2025-01-24 15:48:31');

-- ----------------------------
-- Table structure for equipments
-- ----------------------------
DROP TABLE IF EXISTS `equipments`;
CREATE TABLE `equipments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint UNSIGNED NOT NULL,
  `item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `brand` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `serial_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `equipments_category_id_foreign`(`category_id` ASC) USING BTREE,
  CONSTRAINT `equipments_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of equipments
-- ----------------------------
INSERT INTO `equipments` VALUES (1, 1, 'WiFi Router', 'asdasd', 'asdasd', 'asdasdasd', 'asdasdasdasd\nasdasd', 1, '2025-01-24 01:59:05', '2025-01-24 01:59:05');

-- ----------------------------
-- Table structure for loan_applications
-- ----------------------------
DROP TABLE IF EXISTS `loan_applications`;
CREATE TABLE `loan_applications`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nostaf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_loan_from` datetime NULL DEFAULT NULL,
  `date_loan_to` datetime NULL DEFAULT NULL,
  `equipment_pickup_date` datetime NULL DEFAULT NULL,
  `loan_purpose` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `approver_staff` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approver_date` datetime NULL DEFAULT NULL,
  `approver_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `approver_status_id` tinyint NULL DEFAULT NULL,
  `btm_approver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `btm_date` datetime NULL DEFAULT NULL,
  `btm_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status_loan_id` tinyint NULL DEFAULT NULL,
  `active` tinyint NULL DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of loan_applications
-- ----------------------------
INSERT INTO `loan_applications` VALUES (1, '12362020', '2025-01-27 00:00:00', '2025-02-20 00:00:00', NULL, 'Asd Asd Asd Asd Asd\r\nAsd Asd Asd Asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2025-01-24 16:05:59', '2025-01-24 16:05:59');
INSERT INTO `loan_applications` VALUES (2, '12362020', '2025-01-27 00:00:00', '2025-02-20 00:00:00', NULL, 'Asd Asd Asd Asd Asd\r\nAsd Asd Asd Asd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2025-01-24 16:11:23', '2025-01-24 16:11:23');

-- ----------------------------
-- Table structure for loan_equipments
-- ----------------------------
DROP TABLE IF EXISTS `loan_equipments`;
CREATE TABLE `loan_equipments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `application_id` bigint UNSIGNED NOT NULL,
  `equipment_id` bigint UNSIGNED NOT NULL,
  `taken_on` datetime NULL DEFAULT NULL,
  `return_on` datetime NULL DEFAULT NULL,
  `status_item_id` bigint UNSIGNED NULL DEFAULT NULL,
  `status_condition_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `loan_equipments_application_id_foreign`(`application_id` ASC) USING BTREE,
  INDEX `loan_equipments_equipment_id_foreign`(`equipment_id` ASC) USING BTREE,
  CONSTRAINT `loan_equipments_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `loan_applications` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `loan_equipments_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of loan_equipments
-- ----------------------------
INSERT INTO `loan_equipments` VALUES (1, 1, 1, NULL, NULL, 1, NULL, NULL, '2025-01-24 16:05:59', '2025-01-24 16:05:59');
INSERT INTO `loan_equipments` VALUES (2, 2, 1, NULL, NULL, 1, NULL, NULL, '2025-01-24 16:11:23', '2025-01-24 16:11:23');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2024_12_01_122408_create_btm_approval_table', 1);
INSERT INTO `migrations` VALUES (2, '2024_12_01_122452_create_categories_table', 1);
INSERT INTO `migrations` VALUES (3, '2024_12_01_122508_create_dept_approval_table', 1);
INSERT INTO `migrations` VALUES (4, '2024_12_01_122521_create_equipments_table', 1);
INSERT INTO `migrations` VALUES (5, '2024_12_01_122539_create_loan_applications_table', 1);
INSERT INTO `migrations` VALUES (6, '2024_12_01_122551_create_loan_equipments_table', 1);
INSERT INTO `migrations` VALUES (7, '2024_12_01_122609_create_status_equipments_table', 1);
INSERT INTO `migrations` VALUES (8, '2024_12_01_122618_create_status_loans_table', 1);
INSERT INTO `migrations` VALUES (9, '2024_12_02_131615_create_status_approvals_table', 1);
INSERT INTO `migrations` VALUES (10, '2024_12_05_094623_create_email_suggestions_table', 1);
INSERT INTO `migrations` VALUES (11, '2024_12_09_131256_create_status_applications_table', 1);
INSERT INTO `migrations` VALUES (12, '2024_12_10_111012_create_email_registration_applications_table', 1);
INSERT INTO `migrations` VALUES (13, '2024_12_10_115842_create_email_group_members_table', 1);
INSERT INTO `migrations` VALUES (14, '2024_12_17_101213_create_notifications_table', 1);
INSERT INTO `migrations` VALUES (15, '2025_02_12_202714_create_sessions_table', 2);
INSERT INTO `migrations` VALUES (16, '2025_02_12_202742_create_cache_table', 2);
INSERT INTO `migrations` VALUES (17, '2019_12_14_000001_create_personal_access_tokens_table', 3);

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications`  (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `notifications_notifiable_type_notifiable_id_index`(`notifiable_type` ASC, `notifiable_id` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of notifications
-- ----------------------------
INSERT INTO `notifications` VALUES ('1533e326-00f5-427e-9bb6-1ee559a45d41', 'App\\Notifications\\ApplicantEmailAlert', 'App\\Models\\Login', 21995, '{\"data\":\"New email registration application\",\"link\":\"http:\\/\\/localhost:8000\\/emailaccapp\\/1\"}', '2024-12-19 19:00:19', '2024-12-19 18:49:08', '2024-12-19 19:00:19');
INSERT INTO `notifications` VALUES ('550088c1-efca-4237-a337-de1174d35e86', 'App\\Notifications\\ApplicantEmailAlert', 'App\\Models\\Login', 21995, '{\"data\":\"New email registration\",\"link\":\"http:\\/\\/localhost:8000\\/emailaccapp\\/2\"}', NULL, '2025-01-24 15:48:32', '2025-01-24 15:48:32');
INSERT INTO `notifications` VALUES ('a561fb37-cb4a-4e48-ae71-ca0620850fd9', 'App\\Notifications\\ApplicantEmailAlertBTM', 'App\\Models\\Login', 2262007, '{\"data\":\"New email registration\",\"link\":\"http:\\/\\/localhost:8000\\/btmemailapplications\\/2\\/edit\"}', NULL, '2025-01-24 15:48:32', '2025-01-24 15:48:32');
INSERT INTO `notifications` VALUES ('b6bb4845-9cb2-45e9-88a1-80cd20184080', 'App\\Notifications\\ApplicantEmailAlert', 'App\\Models\\Login', 10432014, '{\"data\":\"New email registration application\",\"link\":\"http:\\/\\/localhost:8000\\/emailaccapp\\/1\"}', '2024-12-21 09:54:52', '2024-12-19 18:49:08', '2024-12-21 09:54:52');
INSERT INTO `notifications` VALUES ('c62d14d4-dd00-4894-8b1b-d6afb7054749', 'App\\Notifications\\ApplicantEmailAlert', 'App\\Models\\Login', 2262007, '{\"data\":\"New email registration application\",\"link\":\"http:\\/\\/localhost:8000\\/emailaccapp\\/1\"}', NULL, '2024-12-19 18:49:08', '2024-12-19 18:49:08');
INSERT INTO `notifications` VALUES ('d7e10a8d-008a-4d52-898e-cb69c43616c0', 'App\\Notifications\\ApplicantEmailAlertBTM', 'App\\Models\\Login', 11802017, '{\"data\":\"New email registration\",\"link\":\"http:\\/\\/localhost:8000\\/btmemailapplications\\/2\\/edit\"}', NULL, '2025-01-24 15:48:32', '2025-01-24 15:48:32');
INSERT INTO `notifications` VALUES ('f6270d08-8c46-4a32-8ca1-c1eafc7163c2', 'App\\Notifications\\ApplicantEmailAlertBTM', 'App\\Models\\Login', 10432014, '{\"data\":\"New email registration\",\"link\":\"http:\\/\\/localhost:8000\\/btmemailapplications\\/2\\/edit\"}', '2025-01-24 23:47:42', '2025-01-24 15:48:32', '2025-01-24 23:47:42');

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE,
  INDEX `personal_access_tokens_expires_at_index`(`expires_at` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `sessions_user_id_index`(`user_id` ASC) USING BTREE,
  INDEX `sessions_last_activity_index`(`last_activity` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('gyv6gGXQm8XU5HVsVoz7trM62XkN7h9K1pKLlIqk', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:141.0) Gecko/20100101 Firefox/141.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibW5yTW8zUkdZOHo3cGtIUVNSNkptSVRWV0djZnRGTDZzTlhicWU0MiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fX0=', 1755519160);
INSERT INTO `sessions` VALUES ('KclIZJpnddNu1v5l3g9LUCbgU9e1En98pD41Z7NJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:141.0) Gecko/20100101 Firefox/141.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVWFTZkFOdktEbmVCTTJ4YUs4eTVaS1hKeU56c3dwN0RkdHdHUThQaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1755519230);
INSERT INTO `sessions` VALUES ('XG5OPZE9AnYhnax6oJ60Q5MGI8hQJaXgzng387yV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:141.0) Gecko/20100101 Firefox/141.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUnpGTnVlY0hpUTBhRWZjZjIxV1JSU3ZmOWY1SG1XYlVLcXRCNGZPdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fX0=', 1755520876);

-- ----------------------------
-- Table structure for status_applications
-- ----------------------------
DROP TABLE IF EXISTS `status_applications`;
CREATE TABLE `status_applications`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `status_loan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of status_applications
-- ----------------------------
INSERT INTO `status_applications` VALUES (1, 'Permohonan Diluluskan', NULL, '2024-12-19 17:40:43', '2024-12-19 17:40:43');
INSERT INTO `status_applications` VALUES (2, 'Permohonan Tidak Diluluskan', NULL, '2024-12-19 17:40:43', '2024-12-19 17:40:43');
INSERT INTO `status_applications` VALUES (3, 'Permohonan Sedang Diproses', NULL, '2024-12-19 17:40:43', '2024-12-19 17:40:43');

-- ----------------------------
-- Table structure for status_approvals
-- ----------------------------
DROP TABLE IF EXISTS `status_approvals`;
CREATE TABLE `status_approvals`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `status_approval` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of status_approvals
-- ----------------------------
INSERT INTO `status_approvals` VALUES (1, 'Permohonan Disokong', NULL, '2024-12-19 17:40:43', '2024-12-19 17:40:43');
INSERT INTO `status_approvals` VALUES (2, 'Permohonan Tidak Disokong', NULL, '2024-12-19 17:40:43', '2024-12-19 17:40:43');

-- ----------------------------
-- Table structure for status_equipments
-- ----------------------------
DROP TABLE IF EXISTS `status_equipments`;
CREATE TABLE `status_equipments`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `status_item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of status_equipments
-- ----------------------------
INSERT INTO `status_equipments` VALUES (1, 'OK', NULL, '2024-12-19 17:40:43', '2024-12-19 17:40:43');
INSERT INTO `status_equipments` VALUES (2, 'Damage', NULL, '2024-12-19 17:40:43', '2024-12-19 17:40:43');
INSERT INTO `status_equipments` VALUES (3, 'Obsolete', NULL, '2024-12-19 17:40:43', '2024-12-19 17:40:43');
INSERT INTO `status_equipments` VALUES (4, 'Under Repair', NULL, '2024-12-19 17:40:43', '2024-12-19 17:40:43');

SET FOREIGN_KEY_CHECKS = 1;
