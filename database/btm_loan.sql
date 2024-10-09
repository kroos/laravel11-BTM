/*
 Navicat Premium Data Transfer

 Source Server         : Localhost WSL
 Source Server Type    : MariaDB
 Source Server Version : 100339 (10.3.39-MariaDB-0+deb10u2)
 Source Host           : localhost:3306
 Source Schema         : btm_loan

 Target Server Type    : MariaDB
 Target Server Version : 100339 (10.3.39-MariaDB-0+deb10u2)
 File Encoding         : 65001

 Date: 03/10/2024 14:56:31
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'Network Peripheral', '2024-10-02 13:10:32', '2024-10-02 13:10:32');

-- ----------------------------
-- Table structure for dept_approval
-- ----------------------------
DROP TABLE IF EXISTS `dept_approval`;
CREATE TABLE `dept_approval`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nostaf` int(11) NULL DEFAULT NULL COMMENT 'staff appointed to approve loan application',
  `kod_jabatan` int(11) NULL DEFAULT NULL,
  `remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dept_approval
-- ----------------------------

-- ----------------------------
-- Table structure for items
-- ----------------------------
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NULL DEFAULT NULL,
  `item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `brand` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `serial_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `quantity` int(11) NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of items
-- ----------------------------
INSERT INTO `items` VALUES (1, 1, 'AP Router', 'TP Link', 'tp0987', '1232342345754768', 'AP for users or events', NULL, '2024-10-02 13:12:51', '2024-10-02 13:12:51');

SET FOREIGN_KEY_CHECKS = 1;
