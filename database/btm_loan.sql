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

 Date: 01/12/2024 13:55:45
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
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'approver kepada jabatan' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of btm_approval
-- ----------------------------
INSERT INTO `btm_approval` VALUES (1, '2262007', 1, NULL, '2024-10-29 12:29:52', '2024-11-11 13:49:31');
INSERT INTO `btm_approval` VALUES (2, '6792011', 0, NULL, '2024-10-29 12:30:39', '2024-10-29 15:38:19');
INSERT INTO `btm_approval` VALUES (3, '0541998', 0, NULL, '2024-10-29 15:01:50', '2024-11-11 13:49:23');
INSERT INTO `btm_approval` VALUES (6, '10432014', 1, NULL, '2024-10-29 15:36:38', '2024-10-29 15:37:48');
INSERT INTO `btm_approval` VALUES (7, '12472021', 0, NULL, '2024-10-29 15:44:52', '2024-10-29 15:47:43');
INSERT INTO `btm_approval` VALUES (8, '25I2OO7', 1, NULL, '2024-11-11 13:49:12', '2024-11-11 13:49:12');

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = 'approver kepada jabatan' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of dept_approval
-- ----------------------------
INSERT INTO `dept_approval` VALUES (1, '0021995', 'PUSH', 1, NULL, '2024-10-21 16:17:33', '2024-10-29 10:00:15');
INSERT INTO `dept_approval` VALUES (2, '0021995', 'IIF', NULL, NULL, '2024-10-21 16:17:33', '2024-10-29 10:00:15');

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
  `approver_remarks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `btm_approver` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `btm_date` datetime NULL DEFAULT NULL,
  `btm_remarks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status_loan_id` int NULL DEFAULT NULL,
  `active` int NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of loan_applications
-- ----------------------------
INSERT INTO `loan_applications` VALUES (1, '10772014', '2024-11-09 00:00:00', '2024-11-11 00:00:00', NULL, 'Sdfsdfsdf Sdf Sdf Sdf Sdf Dsf\r\nDf Sdf Sdf Sdf Sdf Zxczxc Zc Zxc Zxc Zxczxc Zx Czxc\r\nZxc Zxc Zxc Zxczxc', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-10-29 09:32:57', '2024-11-07 15:20:58');
INSERT INTO `loan_applications` VALUES (3, '10772014', '2024-11-10 00:00:00', '2024-11-11 00:00:00', NULL, 'Sdf Sdf Sdf Sdf Rtert Eert\r\nErt Ertfghfgh Fgh Fgh Fgh', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-06 15:46:10', '2024-11-06 15:46:10');
INSERT INTO `loan_applications` VALUES (4, '12362020', '2024-11-27 00:00:00', '2024-11-27 00:00:00', NULL, 'Asd Asd Asdasd', '0021995', '2024-11-17 11:31:22', NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-07 14:38:38', '2024-11-18 13:23:37');
INSERT INTO `loan_applications` VALUES (5, '12362020', '2024-11-28 00:00:00', '2024-12-01 00:00:00', NULL, 'Asd Asd Asd Asd Asda Sd', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-25 16:24:57', '2024-11-25 16:24:57');
INSERT INTO `loan_applications` VALUES (6, '12362020', '2024-11-28 00:00:00', '2024-12-01 00:00:00', NULL, 'Asd Asd Asd Asd Asda Sd', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-25 16:26:01', '2024-11-25 16:26:01');
INSERT INTO `loan_applications` VALUES (7, '12362020', '2024-12-01 00:00:00', '2024-12-02 00:00:00', NULL, 'Xcvvxcvx Cvxcv', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-26 10:27:34', '2024-11-26 10:27:34');
INSERT INTO `loan_applications` VALUES (8, '12362020', '2024-12-01 00:00:00', '2024-12-02 00:00:00', NULL, 'Xcvvxcvx Cvxcv', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-26 10:28:50', '2024-11-26 10:28:50');
INSERT INTO `loan_applications` VALUES (9, '12362020', '2024-12-01 00:00:00', '2024-12-02 00:00:00', NULL, 'Xcvvxcvx Cvxcv', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-26 10:29:20', '2024-11-26 10:29:20');
INSERT INTO `loan_applications` VALUES (10, '12362020', '2024-12-01 00:00:00', '2024-12-02 00:00:00', NULL, 'Xcvvxcvx Cvxcv', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-26 10:30:00', '2024-11-26 10:30:00');
INSERT INTO `loan_applications` VALUES (11, '12362020', '2024-12-01 00:00:00', '2024-12-02 00:00:00', NULL, 'Xcvvxcvx Cvxcv', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-26 10:32:51', '2024-11-26 10:32:51');
INSERT INTO `loan_applications` VALUES (12, '12362020', '2024-12-01 00:00:00', '2024-12-02 00:00:00', NULL, 'Xcvvxcvx Cvxcv', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-26 10:33:12', '2024-11-26 10:33:12');
INSERT INTO `loan_applications` VALUES (13, '12362020', '2024-12-01 00:00:00', '2024-12-02 00:00:00', NULL, 'Xcvvxcvx Cvxcv', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-26 10:35:22', '2024-11-26 10:35:22');
INSERT INTO `loan_applications` VALUES (14, '12362020', '2024-12-01 00:00:00', '2024-12-02 00:00:00', NULL, 'Xcvvxcvx Cvxcv', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-26 10:35:35', '2024-11-26 10:35:35');
INSERT INTO `loan_applications` VALUES (15, '12362020', '2024-12-01 00:00:00', '2024-12-02 00:00:00', NULL, 'Xcvvxcvx Cvxcv', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-26 10:39:22', '2024-11-26 10:39:22');
INSERT INTO `loan_applications` VALUES (16, '12362020', '2024-12-01 00:00:00', '2024-12-02 00:00:00', NULL, 'Xcvvxcvx Cvxcv', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-26 10:40:39', '2024-11-26 10:40:39');
INSERT INTO `loan_applications` VALUES (17, '12362020', '2024-12-01 00:00:00', '2024-12-02 00:00:00', NULL, 'Xcvvxcvx Cvxcv', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-26 10:41:15', '2024-11-26 10:41:15');
INSERT INTO `loan_applications` VALUES (18, '12362020', '2024-12-01 00:00:00', '2024-12-02 00:00:00', NULL, 'Xcvvxcvx Cvxcv', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-26 11:21:21', '2024-11-26 11:21:21');
INSERT INTO `loan_applications` VALUES (19, '12362020', '2024-12-01 00:00:00', '2024-12-02 00:00:00', NULL, 'Xcvvxcvx Cvxcv', NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, NULL, '2024-11-26 11:21:46', '2024-11-26 11:21:46');

-- ----------------------------
-- Table structure for loan_equipments
-- ----------------------------
DROP TABLE IF EXISTS `loan_equipments`;
CREATE TABLE `loan_equipments`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `application_id` int NULL DEFAULT NULL,
  `equipment_id` int NULL DEFAULT NULL,
  `taken_on` datetime NULL DEFAULT NULL,
  `return_on` datetime NULL DEFAULT NULL,
  `status_item_id` int NULL DEFAULT NULL,
  `status_condition_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of loan_equipments
-- ----------------------------
INSERT INTO `loan_equipments` VALUES (1, 1, 4, NULL, NULL, 1, NULL, NULL, '2024-10-29 09:32:57', '2024-11-06 14:01:04');
INSERT INTO `loan_equipments` VALUES (3, 1, 3, NULL, NULL, 1, NULL, NULL, '2024-11-06 12:34:02', '2024-11-06 14:01:04');
INSERT INTO `loan_equipments` VALUES (4, 1, 4, NULL, NULL, 1, NULL, NULL, '2024-11-06 13:59:54', '2024-11-06 14:01:04');
INSERT INTO `loan_equipments` VALUES (5, 1, 3, NULL, NULL, 1, NULL, NULL, '2024-11-06 14:01:04', '2024-11-07 12:54:04');
INSERT INTO `loan_equipments` VALUES (7, 3, 3, NULL, NULL, 1, NULL, NULL, '2024-11-06 15:46:10', '2024-11-06 15:46:10');
INSERT INTO `loan_equipments` VALUES (8, 4, 3, '2024-11-13 00:00:00', '2024-11-14 00:00:00', 2, 'Asd Asd Asd Asd Asd Asd', NULL, '2024-11-07 14:38:39', '2024-11-18 13:23:37');
INSERT INTO `loan_equipments` VALUES (9, 5, 4, NULL, NULL, 1, NULL, NULL, '2024-11-25 16:24:57', '2024-11-25 16:24:57');
INSERT INTO `loan_equipments` VALUES (10, 5, 3, NULL, NULL, 1, NULL, NULL, '2024-11-25 16:24:57', '2024-11-25 16:24:57');
INSERT INTO `loan_equipments` VALUES (11, 6, 4, NULL, NULL, 1, NULL, NULL, '2024-11-25 16:26:01', '2024-11-25 16:26:01');
INSERT INTO `loan_equipments` VALUES (12, 6, 3, NULL, NULL, 1, NULL, NULL, '2024-11-25 16:26:01', '2024-11-25 16:26:01');
INSERT INTO `loan_equipments` VALUES (13, 7, 4, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:27:34', '2024-11-26 10:27:34');
INSERT INTO `loan_equipments` VALUES (14, 7, 3, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:27:34', '2024-11-26 10:27:34');
INSERT INTO `loan_equipments` VALUES (15, 8, 4, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:28:50', '2024-11-26 10:28:50');
INSERT INTO `loan_equipments` VALUES (16, 8, 3, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:28:50', '2024-11-26 10:28:50');
INSERT INTO `loan_equipments` VALUES (17, 9, 4, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:29:21', '2024-11-26 10:29:21');
INSERT INTO `loan_equipments` VALUES (18, 9, 3, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:29:21', '2024-11-26 10:29:21');
INSERT INTO `loan_equipments` VALUES (19, 10, 4, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:30:00', '2024-11-26 10:30:00');
INSERT INTO `loan_equipments` VALUES (20, 10, 3, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:30:01', '2024-11-26 10:30:01');
INSERT INTO `loan_equipments` VALUES (21, 11, 4, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:32:52', '2024-11-26 10:32:52');
INSERT INTO `loan_equipments` VALUES (22, 11, 3, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:32:52', '2024-11-26 10:32:52');
INSERT INTO `loan_equipments` VALUES (23, 12, 4, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:33:12', '2024-11-26 10:33:12');
INSERT INTO `loan_equipments` VALUES (24, 12, 3, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:33:12', '2024-11-26 10:33:12');
INSERT INTO `loan_equipments` VALUES (25, 13, 4, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:35:22', '2024-11-26 10:35:22');
INSERT INTO `loan_equipments` VALUES (26, 13, 3, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:35:22', '2024-11-26 10:35:22');
INSERT INTO `loan_equipments` VALUES (27, 14, 4, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:35:35', '2024-11-26 10:35:35');
INSERT INTO `loan_equipments` VALUES (28, 14, 3, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:35:35', '2024-11-26 10:35:35');
INSERT INTO `loan_equipments` VALUES (29, 15, 4, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:39:22', '2024-11-26 10:39:22');
INSERT INTO `loan_equipments` VALUES (30, 15, 3, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:39:22', '2024-11-26 10:39:22');
INSERT INTO `loan_equipments` VALUES (31, 16, 4, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:40:39', '2024-11-26 10:40:39');
INSERT INTO `loan_equipments` VALUES (32, 16, 3, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:40:40', '2024-11-26 10:40:40');
INSERT INTO `loan_equipments` VALUES (33, 17, 3, NULL, NULL, 1, NULL, NULL, '2024-11-26 10:41:15', '2024-11-26 10:41:15');
INSERT INTO `loan_equipments` VALUES (34, 18, 3, NULL, NULL, 1, NULL, NULL, '2024-11-26 11:21:21', '2024-11-26 11:21:21');
INSERT INTO `loan_equipments` VALUES (35, 19, 3, NULL, NULL, 1, NULL, NULL, '2024-11-26 11:21:47', '2024-11-26 11:21:47');

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
INSERT INTO `status_loans` VALUES (3, 'Permohonan Sedang Diproses', NULL, '2024-10-28 10:46:35', '2024-10-28 10:46:35');

SET FOREIGN_KEY_CHECKS = 1;
