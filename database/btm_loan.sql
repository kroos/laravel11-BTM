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

 Date: 29/10/2024 15:48:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for btm_approval
-- ----------------------------
DROP TABLE IF EXISTS `btm_approval`;
CREATE TABLE `btm_approval`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nostaf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'staff appointed to approve loan application',
  `active` tinyint NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'approver kepada jabatan' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of btm_approval
-- ----------------------------
INSERT INTO `btm_approval` VALUES (1, '2262007', 0, NULL, '2024-10-29 12:29:52', '2024-10-29 15:38:21');
INSERT INTO `btm_approval` VALUES (2, '6792011', 0, NULL, '2024-10-29 12:30:39', '2024-10-29 15:38:19');
INSERT INTO `btm_approval` VALUES (3, '0541998', 1, NULL, '2024-10-29 15:01:50', '2024-10-29 15:47:37');
INSERT INTO `btm_approval` VALUES (6, '10432014', 0, NULL, '2024-10-29 15:36:38', '2024-10-29 15:37:48');
INSERT INTO `btm_approval` VALUES (7, '12472021', 0, NULL, '2024-10-29 15:44:52', '2024-10-29 15:47:43');

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'Network Peripheral', '2024-10-02 13:10:32', '2024-10-02 13:10:32');
INSERT INTO `categories` VALUES (2, 'Audio Visual Apparatus', '2024-10-23 09:47:11', '2024-10-23 09:47:11');

-- ----------------------------
-- Table structure for dept_approval
-- ----------------------------
DROP TABLE IF EXISTS `dept_approval`;
CREATE TABLE `dept_approval`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nostaf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'staff appointed to approve loan application',
  `kod_jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `active` int NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'approver kepada jabatan' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of dept_approval
-- ----------------------------
INSERT INTO `dept_approval` VALUES (1, '0021995', 'PUSH', 1, NULL, '2024-10-21 16:17:33', '2024-10-29 10:00:15');

-- ----------------------------
-- Table structure for equipments
-- ----------------------------
DROP TABLE IF EXISTS `equipments`;
CREATE TABLE `equipments`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int NULL DEFAULT NULL,
  `item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `brand` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `serial_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `quantity` int NULL DEFAULT NULL,
  `status` int NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of equipments
-- ----------------------------
INSERT INTO `equipments` VALUES (3, 1, 'Access Point CISCO', 'CISCO', 'C340AP', 'aasdasd', 'asdasd', NULL, 1, '2024-10-16 14:49:50', '2024-10-16 14:49:50');
INSERT INTO `equipments` VALUES (4, 1, 'Access Point TP Link', 'TP Link', 'TP980AP', 'sdfsdf', 'sdfsd', NULL, 1, '2024-10-16 14:50:27', '2024-10-16 14:50:27');

-- ----------------------------
-- Table structure for loan_applications
-- ----------------------------
DROP TABLE IF EXISTS `loan_applications`;
CREATE TABLE `loan_applications`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nostaf` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `date_loan_from` datetime NULL DEFAULT NULL,
  `date_loan_to` datetime NULL DEFAULT NULL,
  `equipment_pickup_date` datetime NULL DEFAULT NULL,
  `loan_purpose` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `approver_staff` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `approver_date` datetime NULL DEFAULT NULL,
  `btm_approver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `btm_date` datetime NULL DEFAULT NULL,
  `status_loan_id` int NULL DEFAULT NULL,
  `active` int NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of loan_applications
-- ----------------------------
INSERT INTO `loan_applications` VALUES (1, '0021995', '2024-11-03 00:00:00', '2024-11-04 00:00:00', NULL, 'Sdfsdfsdf Sdf Sdf Sdf Sdf Dsf\r\nDf Sdf Sdf Sdf Sdf', NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-10-29 09:32:57', '2024-10-29 09:32:57');

-- ----------------------------
-- Table structure for loan_equipments
-- ----------------------------
DROP TABLE IF EXISTS `loan_equipments`;
CREATE TABLE `loan_equipments`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `application_id` int NULL DEFAULT NULL,
  `equipment_id` int NULL DEFAULT NULL,
  `taken_on` datetime NULL DEFAULT NULL,
  `approved_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'nostaf',
  `approved_on` datetime NULL DEFAULT NULL,
  `status_item_id` int NULL DEFAULT NULL,
  `status_condition_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of loan_equipments
-- ----------------------------
INSERT INTO `loan_equipments` VALUES (1, 1, 3, NULL, NULL, NULL, 1, NULL, NULL, '2024-10-29 09:32:57', '2024-10-29 09:32:57');

-- ----------------------------
-- Table structure for status_equipments
-- ----------------------------
DROP TABLE IF EXISTS `status_equipments`;
CREATE TABLE `status_equipments`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `status_item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of status_equipments
-- ----------------------------
INSERT INTO `status_equipments` VALUES (1, 'OK', NULL, '2024-10-17 10:24:43', '2024-10-17 10:24:43');
INSERT INTO `status_equipments` VALUES (2, 'Damage', NULL, '2024-10-17 10:24:43', '2024-10-17 10:24:43');
INSERT INTO `status_equipments` VALUES (3, 'Obsolete', NULL, '2024-10-17 10:24:43', '2024-10-17 10:24:43');
INSERT INTO `status_equipments` VALUES (4, 'Under Repair', NULL, '2024-10-17 10:24:43', '2024-10-17 10:24:43');

-- ----------------------------
-- Table structure for status_loans
-- ----------------------------
DROP TABLE IF EXISTS `status_loans`;
CREATE TABLE `status_loans`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `status_loan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of status_loans
-- ----------------------------
INSERT INTO `status_loans` VALUES (1, 'Permohonan Diluluskan', NULL, '2024-10-28 10:46:35', '2024-10-28 10:46:35');
INSERT INTO `status_loans` VALUES (2, 'Permohonan Tidak Diluluskan', NULL, '2024-10-28 10:46:35', '2024-10-28 10:46:35');
INSERT INTO `status_loans` VALUES (3, 'Permohonan Dalam Proses', NULL, '2024-10-28 10:46:35', '2024-10-28 10:46:35');

SET FOREIGN_KEY_CHECKS = 1;
