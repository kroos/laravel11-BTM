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

 Date: 24/10/2024 14:31:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
INSERT INTO `dept_approval` VALUES (1, '0021995', 'PUSH', 1, NULL, '2024-10-21 16:17:33', '2024-10-21 16:17:33');

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
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `active` int NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of loan_applications
-- ----------------------------
INSERT INTO `loan_applications` VALUES (1, '0021995', '2024-10-28 00:00:00', '2024-10-28 00:00:00', NULL, 'Qweqweqwe Qwe Qwe Qwe Qwe Qwe Qweq Weqw Eq', NULL, 1, NULL, '2024-10-24 13:28:22', '2024-10-24 13:28:22');

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of loan_equipments
-- ----------------------------
INSERT INTO `loan_equipments` VALUES (1, 1, 3, NULL, NULL, NULL, 2, NULL, NULL, '2024-10-24 13:28:22', '2024-10-24 13:28:22');
INSERT INTO `loan_equipments` VALUES (2, 1, 4, NULL, NULL, NULL, 1, NULL, NULL, '2024-10-24 13:28:22', '2024-10-24 13:28:22');

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

SET FOREIGN_KEY_CHECKS = 1;
