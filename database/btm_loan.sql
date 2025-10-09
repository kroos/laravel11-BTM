/*
 Navicat Premium Data Transfer

 Source Server         : Localhost MySQL
 Source Server Type    : MySQL
 Source Server Version : 80043 (8.0.43)
 Source Host           : localhost:3306
 Source Schema         : btm_loan

 Target Server Type    : MySQL
 Target Server Version : 80043 (8.0.43)
 File Encoding         : 65001

 Date: 09/10/2025 23:12:14
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
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of btm_approval
-- ----------------------------
INSERT INTO `btm_approval` VALUES (1, '10432014', 1, NULL, '2025-08-19 12:58:41', '2025-08-19 12:58:41');
INSERT INTO `btm_approval` VALUES (2, '2262007', 1, NULL, '2025-08-19 16:00:39', '2025-08-19 16:00:39');
INSERT INTO `btm_approval` VALUES (3, '25I2OO7', 0, NULL, '2025-08-20 15:09:01', '2025-08-20 15:09:05');
INSERT INTO `btm_approval` VALUES (4, '2262007', 1, NULL, '2025-08-25 12:09:10', '2025-08-25 12:09:10');
INSERT INTO `btm_approval` VALUES (5, '10432014', 1, NULL, '2025-08-25 12:09:10', '2025-08-25 12:09:10');

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
INSERT INTO `cache` VALUES ('btmgo_cache_c59f007c61fb41d0582e9e2645e263a1', 'i:1;', 1759822767);
INSERT INTO `cache` VALUES ('btmgo_cache_c59f007c61fb41d0582e9e2645e263a1:timer', 'i:1759822767;', 1759822767);

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
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'Network', '2025-08-20 12:05:19', '2025-08-20 12:05:19');
INSERT INTO `categories` VALUES (2, 'Computer', '2025-08-20 12:05:27', '2025-08-20 12:05:27');
INSERT INTO `categories` VALUES (3, 'Audio Visual Devices', '2025-08-20 12:05:51', '2025-08-20 12:05:51');
INSERT INTO `categories` VALUES (4, 'WiFi', '2025-08-25 12:09:10', '2025-08-25 12:09:10');
INSERT INTO `categories` VALUES (5, 'Audio Visual Apparatus', '2025-08-25 12:09:10', '2025-08-25 12:09:10');
INSERT INTO `categories` VALUES (6, 'Computers And Notebooks', '2025-08-25 12:09:10', '2025-08-25 12:09:10');

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
INSERT INTO `dept_approval` VALUES (1, '0021995', 'PUSH', 1, NULL, '2025-09-22 16:21:35', '2025-09-22 16:21:35');

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
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of email_group_members
-- ----------------------------

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
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of email_registration_applications
-- ----------------------------

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
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of email_suggestions
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of equipments
-- ----------------------------
INSERT INTO `equipments` VALUES (1, 1, 'WiFi Router', 'Aztech', 'AZWF123', '123123123', 'none', 1, '2025-08-20 12:06:27', '2025-08-20 12:06:27');
INSERT INTO `equipments` VALUES (2, 1, 'WiFi Router', 'TP Link', 'TPLWF123', NULL, 'none', 1, '2025-08-20 12:07:18', '2025-08-20 12:07:18');
INSERT INTO `equipments` VALUES (3, 2, 'Desktop Computer', 'HP', 'HPDC123', '234234234', 'none', 1, '2025-08-20 12:07:56', '2025-08-20 12:07:56');
INSERT INTO `equipments` VALUES (5, 2, 'Desktop Computer', 'HP', 'HPDC123456', '234234234456', 'none', 1, '2025-08-20 12:09:20', '2025-08-20 12:09:20');
INSERT INTO `equipments` VALUES (6, 3, 'Microphone', 'None', 'None', 'None', 'none', 1, '2025-08-20 12:10:05', '2025-08-20 12:10:05');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for icms_applicant_modules
-- ----------------------------
DROP TABLE IF EXISTS `icms_applicant_modules`;
CREATE TABLE `icms_applicant_modules`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `icms_applicant_module_id` int NOT NULL,
  `icms_module_id` bigint UNSIGNED NOT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `icms_applicant_modules_icms_module_id_foreign`(`icms_module_id` ASC) USING BTREE,
  CONSTRAINT `icms_applicant_modules_icms_module_id_foreign` FOREIGN KEY (`icms_module_id`) REFERENCES `icms_modules` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of icms_applicant_modules
-- ----------------------------

-- ----------------------------
-- Table structure for icms_modules
-- ----------------------------
DROP TABLE IF EXISTS `icms_modules`;
CREATE TABLE `icms_modules`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `icms_module` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of icms_modules
-- ----------------------------
INSERT INTO `icms_modules` VALUES (1, 'Ketua Di Jabatan/Pusat (Head Of Department/Center)', NULL, NULL, '2025-09-09 12:41:16', '2025-09-09 12:41:16', NULL);
INSERT INTO `icms_modules` VALUES (2, 'Setiausaha Jabatan/Pusat (Secretary Department/Center)', NULL, NULL, '2025-09-09 12:41:16', '2025-09-09 12:41:16', NULL);
INSERT INTO `icms_modules` VALUES (3, 'Pengurusan Pentadbiran Jabatan/Pusat (Administrative Management)', NULL, NULL, '2025-09-09 12:41:16', '2025-09-09 12:41:16', NULL);
INSERT INTO `icms_modules` VALUES (4, 'Pengurusan Akademik Kulliyyah (Admin Academic)', NULL, NULL, '2025-09-09 12:41:16', '2025-09-09 12:41:16', NULL);
INSERT INTO `icms_modules` VALUES (5, 'Dekan (Dean)', NULL, NULL, '2025-09-09 12:41:16', '2025-09-09 12:41:16', NULL);
INSERT INTO `icms_modules` VALUES (6, 'Ketua Program (Head Of Programme)', NULL, NULL, '2025-09-09 12:41:16', '2025-09-09 12:41:16', NULL);
INSERT INTO `icms_modules` VALUES (7, 'Pensyarah (Lecturer)', NULL, NULL, '2025-09-09 12:41:16', '2025-09-09 12:41:16', NULL);
INSERT INTO `icms_modules` VALUES (8, 'Jurulatih Ko-Kurikulum (Co-Qurriculum Trainer)', NULL, NULL, '2025-09-09 12:41:16', '2025-09-09 12:41:16', NULL);
INSERT INTO `icms_modules` VALUES (9, 'Lain-lain, Sila Nyatakan. (Others, Please Specify)', NULL, NULL, '2025-09-09 12:41:16', '2025-09-09 12:41:16', NULL);

-- ----------------------------
-- Table structure for icms_requester_applicants
-- ----------------------------
DROP TABLE IF EXISTS `icms_requester_applicants`;
CREATE TABLE `icms_requester_applicants`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `icms_requester_id` bigint UNSIGNED NOT NULL,
  `nostaf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `menu_setting_only` tinyint(1) NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of icms_requester_applicants
-- ----------------------------

-- ----------------------------
-- Table structure for icms_requesters
-- ----------------------------
DROP TABLE IF EXISTS `icms_requesters`;
CREATE TABLE `icms_requesters`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nostaf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `approver_staff` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approver_date` datetime NULL DEFAULT NULL,
  `approver_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `approver_status_id` tinyint NULL DEFAULT NULL,
  `btm_approver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `btm_date` datetime NULL DEFAULT NULL,
  `btm_remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status_request_id` tinyint NULL DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of icms_requesters
-- ----------------------------

-- ----------------------------
-- Table structure for item_status_history
-- ----------------------------
DROP TABLE IF EXISTS `item_status_history`;
CREATE TABLE `item_status_history`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` bigint UNSIGNED NOT NULL,
  `status` enum('available','reserved','borrowed','damaged','maintenance','lost') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `changed_by` bigint UNSIGNED NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `item_status_history_item_id_foreign`(`item_id` ASC) USING BTREE,
  CONSTRAINT `item_status_history_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of item_status_history
-- ----------------------------

-- ----------------------------
-- Table structure for items
-- ----------------------------
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint UNSIGNED NOT NULL,
  `brand` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `serial_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_status` enum('available','reserved','borrowed','damaged','maintenance','lost') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `items_serial_number_unique`(`serial_number` ASC) USING BTREE,
  INDEX `items_category_id_foreign`(`category_id` ASC) USING BTREE,
  CONSTRAINT `items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of items
-- ----------------------------

-- ----------------------------
-- Table structure for job_batches
-- ----------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches`  (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `cancelled_at` int NULL DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of job_batches
-- ----------------------------

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED NULL DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_index`(`queue` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jobs
-- ----------------------------

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
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of loan_applications
-- ----------------------------

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
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of loan_equipments
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (2, '2024_12_01_122408_create_btm_approval_table', 1);
INSERT INTO `migrations` VALUES (3, '2024_12_01_122452_create_categories_table', 1);
INSERT INTO `migrations` VALUES (4, '2024_12_01_122508_create_dept_approval_table', 1);
INSERT INTO `migrations` VALUES (5, '2024_12_01_122521_create_equipments_table', 1);
INSERT INTO `migrations` VALUES (6, '2024_12_01_122539_create_loan_applications_table', 1);
INSERT INTO `migrations` VALUES (7, '2024_12_01_122551_create_loan_equipments_table', 1);
INSERT INTO `migrations` VALUES (8, '2024_12_01_122609_create_status_equipments_table', 1);
INSERT INTO `migrations` VALUES (9, '2024_12_01_122618_create_status_loans_table', 1);
INSERT INTO `migrations` VALUES (10, '2024_12_02_131615_create_status_approvals_table', 1);
INSERT INTO `migrations` VALUES (11, '2024_12_05_094623_create_email_suggestions_table', 1);
INSERT INTO `migrations` VALUES (12, '2024_12_09_131256_create_status_applications_table', 1);
INSERT INTO `migrations` VALUES (13, '2024_12_10_111012_create_email_registration_applications_table', 1);
INSERT INTO `migrations` VALUES (14, '2024_12_10_115842_create_email_group_members_table', 1);
INSERT INTO `migrations` VALUES (15, '2024_12_17_101213_create_notifications_table', 1);
INSERT INTO `migrations` VALUES (16, '2025_02_12_202714_create_sessions_table', 1);
INSERT INTO `migrations` VALUES (17, '2025_02_12_202742_create_cache_table', 1);
INSERT INTO `migrations` VALUES (18, '2025_08_19_160510_create_items_table', 2);
INSERT INTO `migrations` VALUES (19, '2025_08_19_204604_add_location_to_loan_applications_table', 3);
INSERT INTO `migrations` VALUES (20, '2025_09_08_125720_create_icms_requesters_table', 4);
INSERT INTO `migrations` VALUES (21, '2025_09_08_132047_create_icms_requester_applicants_table', 4);
INSERT INTO `migrations` VALUES (22, '2025_09_09_104932_create_icms_modules_table', 4);
INSERT INTO `migrations` VALUES (23, '2025_09_09_110636_create_icms_applicant_modules_table', 4);
INSERT INTO `migrations` VALUES (24, '2025_09_09_130232_add_username_and_password_to_icms_requester_applicants_table', 5);
INSERT INTO `migrations` VALUES (25, '2025_09_10_115136_change_icms_requester_module_id_to_icms_applicants_module_id_to_icms_applicant_modules_table', 6);
INSERT INTO `migrations` VALUES (26, '2025_09_29_202833_create_jobs_table', 7);
INSERT INTO `migrations` VALUES (27, '2025_09_29_203036_create_job_batches_table', 7);
INSERT INTO `migrations` VALUES (28, '2025_09_29_203037_create_failed_jobs_table', 7);

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
INSERT INTO `sessions` VALUES ('3y3ScxdVZ7ALWFwjOtlJ2GUV1GVPACC0ZUhjnV0m', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWEk3Qlp3RjFSMFUxbFJVazdqNjA4RXcyT1pQTmEyeHNuM0FmcWdEQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fX0=', 1759812381);
INSERT INTO `sessions` VALUES ('AkOLNzyivIT4KcI8I2wSR63JoNgTdrbbXJUX8SnW', 12362020, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZ3c3ZnA0Z3FKWWhQZ293QVhjanExYjVHUWdmZzJDRWx1NDk4enFrUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9lbWFpbGFjY2FwcC9jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czo4OiIxMjM2MjAyMCI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiR1UXlmZ21Id2czLzlrdmlpU2dKaVYuOWFiQW03Z2M1WmxPNnZ3ejVsRDNDem55WkIxdGVvRyI7fQ==', 1759811590);
INSERT INTO `sessions` VALUES ('eCQWSkICipQPNv1ZXXy7I80yIRKZBWryuy9IBrMY', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOW4zVzlZWXVmSGhBWjI1c3dBcGdhUENhZkRVdXlMdGNmYnpqUWJTZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fX0=', 1759822928);

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
INSERT INTO `status_applications` VALUES (1, 'Permohonan Diluluskan', NULL, '2025-08-25 12:09:10', '2025-08-25 12:09:10');
INSERT INTO `status_applications` VALUES (2, 'Permohonan Tidak Diluluskan', NULL, '2025-08-25 12:09:10', '2025-08-25 12:09:10');
INSERT INTO `status_applications` VALUES (3, 'Permohonan Sedang Diproses', NULL, '2025-08-25 12:09:10', '2025-08-25 12:09:10');

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
INSERT INTO `status_approvals` VALUES (1, 'Permohonan Disokong', NULL, '2025-08-25 12:09:10', '2025-08-25 12:09:10');
INSERT INTO `status_approvals` VALUES (2, 'Permohonan Tidak Disokong', NULL, '2025-08-25 12:09:10', '2025-08-25 12:09:10');

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
INSERT INTO `status_equipments` VALUES (1, 'OK', NULL, '2025-08-25 12:09:10', '2025-08-25 12:09:10');
INSERT INTO `status_equipments` VALUES (2, 'Damage', NULL, '2025-08-25 12:09:10', '2025-08-25 12:09:10');
INSERT INTO `status_equipments` VALUES (3, 'Obsolete', NULL, '2025-08-25 12:09:10', '2025-08-25 12:09:10');
INSERT INTO `status_equipments` VALUES (4, 'Under Repair', NULL, '2025-08-25 12:09:10', '2025-08-25 12:09:10');

SET FOREIGN_KEY_CHECKS = 1;
