/*
 Navicat Premium Data Transfer

 Source Server         : 172.17.22.25
 Source Server Type    : MySQL
 Source Server Version : 80035 (8.0.35-27.1)
 Source Host           : 172.17.22.25:62504
 Source Schema         : btm_loan

 Target Server Type    : MySQL
 Target Server Version : 80035 (8.0.35-27.1)
 File Encoding         : 65001

 Date: 05/12/2024 09:50:19
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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of btm_approval
-- ----------------------------
INSERT INTO `btm_approval` VALUES (1, '2262007', 1, NULL, '2024-12-01 14:46:14', '2024-12-01 14:46:14');
INSERT INTO `btm_approval` VALUES (2, '10432014', 1, NULL, '2024-12-01 14:46:14', '2024-12-01 14:46:14');
INSERT INTO `btm_approval` VALUES (3, '11802017', 1, NULL, '2024-12-01 15:40:37', '2024-12-01 15:40:37');
INSERT INTO `btm_approval` VALUES (4, '12512021', 0, NULL, '2024-12-02 11:18:00', '2024-12-02 12:52:07');

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'Network Peripheral', '2024-12-01 14:46:14', '2024-12-01 14:46:14');
INSERT INTO `categories` VALUES (2, 'Audio Visual Apparatus', '2024-12-01 14:46:14', '2024-12-01 14:46:14');
INSERT INTO `categories` VALUES (3, 'Computers And Notebooks', '2024-12-01 14:46:14', '2024-12-01 14:46:14');
INSERT INTO `categories` VALUES (4, 'Lcd Projector', '2024-12-01 15:32:14', '2024-12-01 15:32:14');

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
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dept_approval
-- ----------------------------
INSERT INTO `dept_approval` VALUES (1, '0021995', 'PUSH', 1, NULL, '2024-12-01 15:40:23', '2024-12-01 15:40:23');
INSERT INTO `dept_approval` VALUES (2, '11802017', 'CIRC', 1, NULL, '2024-12-02 11:17:31', '2024-12-02 11:17:31');
INSERT INTO `dept_approval` VALUES (3, '12252020', 'PHEP', 1, NULL, '2024-12-02 11:17:31', '2024-12-02 11:17:31');

-- ----------------------------
-- Table structure for email_registration_applications
-- ----------------------------
DROP TABLE IF EXISTS `email_registration_applications`;
CREATE TABLE `email_registration_applications`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nostaf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email_for_id` int NULL DEFAULT NULL,
  `approver_staff` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approver_date` datetime NULL DEFAULT NULL,
  `approver_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `approver_status_id` int NULL DEFAULT NULL,
  `btm_approver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `btm_date` datetime NULL DEFAULT NULL,
  `btm_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_email_id` int NULL DEFAULT NULL,
  `active` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of email_registration_applications
-- ----------------------------

-- ----------------------------
-- Table structure for email_suggestions
-- ----------------------------
DROP TABLE IF EXISTS `email_suggestions`;
CREATE TABLE `email_suggestions`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `email_application_id` int NULL DEFAULT NULL,
  `email_suggestion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of equipments
-- ----------------------------
INSERT INTO `equipments` VALUES (1, 1, 'ARUBA AP 01', 'CISCO', 'CB7Y65G', 'A729H60MNG8', 'test1', 1, '2024-12-01 15:33:07', '2024-12-01 15:33:07');
INSERT INTO `equipments` VALUES (2, 2, 'AMP 01', 'PANASONIC', 'EMP0947Y4', '999827590OLP-TR428', 'test2', 1, '2024-12-01 15:34:13', '2024-12-01 15:34:13');
INSERT INTO `equipments` VALUES (3, 3, 'ASUS 0207', 'ASUS', 'A98346BG6543-LX', 'JNH748H54F56-9-008', 'test3', 1, '2024-12-01 15:35:07', '2024-12-01 15:35:07');
INSERT INTO `equipments` VALUES (4, 4, 'LCD 0304', 'Phillips', 'PLCDPro5420-TR745', 'PP73548-GF99-BFT', 'test4', 1, '2024-12-01 15:36:19', '2024-12-01 15:36:19');

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
  `approver_status_id` int NULL DEFAULT NULL,
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
INSERT INTO `loan_applications` VALUES (1, '10432014', '2024-12-05 00:00:00', '2024-12-05 00:00:00', NULL, 'Asdasdasdasdd Asd Asd Asdsa Da Sdas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-12-02 10:08:13', '2024-12-02 10:08:13');
INSERT INTO `loan_applications` VALUES (2, '12362020', '2024-12-05 00:00:00', '2024-12-05 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-12-02 10:55:39', '2024-12-02 14:09:54');

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of loan_equipments
-- ----------------------------
INSERT INTO `loan_equipments` VALUES (1, 1, 1, NULL, NULL, 1, NULL, NULL, '2024-12-02 10:08:14', '2024-12-02 10:08:14');
INSERT INTO `loan_equipments` VALUES (2, 1, 2, NULL, NULL, 1, NULL, NULL, '2024-12-02 10:08:14', '2024-12-02 10:08:14');
INSERT INTO `loan_equipments` VALUES (3, 1, 3, NULL, NULL, 1, NULL, NULL, '2024-12-02 10:08:14', '2024-12-02 10:08:14');
INSERT INTO `loan_equipments` VALUES (4, 2, 1, NULL, NULL, 1, NULL, NULL, '2024-12-02 10:55:40', '2024-12-02 10:55:40');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
INSERT INTO `status_applications` VALUES (1, 'Permohonan Diluluskan', NULL, '2024-12-01 14:46:15', '2024-12-01 14:46:15');
INSERT INTO `status_applications` VALUES (2, 'Permohonan Tidak Diluluskan', NULL, '2024-12-01 14:46:15', '2024-12-01 14:46:15');
INSERT INTO `status_applications` VALUES (3, 'Permohonan Sedang Diproses', NULL, '2024-12-01 14:46:15', '2024-12-01 14:46:15');

-- ----------------------------
-- Table structure for status_approvals
-- ----------------------------
DROP TABLE IF EXISTS `status_approvals`;
CREATE TABLE `status_approvals`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `status_approval` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of status_approvals
-- ----------------------------
INSERT INTO `status_approvals` VALUES (1, 'Permohonan Disokong', NULL, NULL, NULL);
INSERT INTO `status_approvals` VALUES (2, 'Permohonan Tidak Disokong', NULL, '2024-12-02 13:04:05', '2024-12-02 13:04:05');

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
INSERT INTO `status_equipments` VALUES (1, 'OK', NULL, '2024-12-01 14:46:14', '2024-12-01 14:46:14');
INSERT INTO `status_equipments` VALUES (2, 'Damage', NULL, '2024-12-01 14:46:15', '2024-12-01 14:46:15');
INSERT INTO `status_equipments` VALUES (3, 'Obsolete', NULL, '2024-12-01 14:46:15', '2024-12-01 14:46:15');
INSERT INTO `status_equipments` VALUES (4, 'Under Repair', NULL, '2024-12-01 14:46:15', '2024-12-01 14:46:15');

SET FOREIGN_KEY_CHECKS = 1;
