/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80027
 Source Host           : localhost:3306
 Source Schema         : colorful-admin

 Target Server Type    : MySQL
 Target Server Version : 80027
 File Encoding         : 65001

 Date: 29/09/2022 17:30:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_handle_log
-- ----------------------------
DROP TABLE IF EXISTS `admin_handle_log`;
CREATE TABLE `admin_handle_log` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `admin_user_id` int unsigned DEFAULT '0' COMMENT '管理员id',
  `classes` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '类和方法',
  `desc` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '描述',
  `request_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '请求参数',
  `response_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '响应',
  `ip` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'ip',
  `created_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_on` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态。0为已删除，1为正常',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Table structure for admin_user
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '登录账号',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '登录密码',
  `salt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '组合密码加密用的扰乱串',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `headimg` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
  `role_id` int unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  `last_login_ip` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户最后一次登录的ip',
  `last_login_time` bigint unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'token',
  `created_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_on` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户状态。0为已删除，1为正常',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_user
-- ----------------------------
BEGIN;
INSERT INTO `admin_user` VALUES (1, 'admin', 'a05033118f9930bd7d6b9aa2bcff8871', 'oqpPS', '超级管理员', '', 1, '172.23.0.1', 1664441789358, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhZG1pbl9pZCI6MSwiYWRtaW5fbmFtZSI6ImFkbWluIiwicm9sZXMiOiJcdThkODVcdTdlYTdcdTdiYTFcdTc0MDZcdTU0NTgsIiwiZXhwaXJlc190aW1lIjoxNjQyOTk1MzA2LCJyZWZyZXNoX3RpbWUiOjE2NDI5OTE3MDZ9.WTAEZa-6MwUolEsyh_jlUfTBs__5hOADYOKYGiYSQlg', 1563195572632, 1646793768126, 1);
COMMIT;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '封面url',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '正文markdown',
  `content_html` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '正文html',
  `cat_id` int unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  `is_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '文章类型; 0普通',
  `click_num` int unsigned NOT NULL DEFAULT '0' COMMENT '点击数',
  `created_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_on` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0为已删除，1为正常',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `article_cat_id_index` (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='文章表（不限于文章，类似文章的模块都可以存放，通过分类判断）';

-- ----------------------------
-- Records of article
-- ----------------------------
BEGIN;
INSERT INTO `article` VALUES (66, 'one', 'desc', '', 'https://baseran2.oss-cn-shenzhen.aliyuncs.com/bbx/article/1643107411337.png', '', '&lt;p&gt;123123&lt;/p&gt;', 53, 1, 0, 0, 1643163607323, 1645434800012, 0);
INSERT INTO `article` VALUES (67, 'one3', 'desc3', '', 'https://baseran2.oss-cn-shenzhen.aliyuncs.com/bbx/article/1643107411337.png', '', '&lt;p&gt;123123&lt;/p&gt;', 54, 1, 0, 0, 1645434990065, 1645436702915, 1);
INSERT INTO `article` VALUES (68, 'one1', 'desc1', '', 'https://baseran2.oss-cn-shenzhen.aliyuncs.com/bbx/article/1643107411337.png', '', '123123123123', 54, 1, 0, 0, 1645435435862, 1645435435862, 1);
INSERT INTO `article` VALUES (69, 'one1', 'desc1', '', 'https://baseran2.oss-cn-shenzhen.aliyuncs.com/bbx/article/1643107411337.png', '', '123123123123', 54, 1, 0, 0, 1645516694791, 1645516694791, 1);
INSERT INTO `article` VALUES (70, 'one1', 'desc1', '', 'https://baseran2.oss-cn-shenzhen.aliyuncs.com/bbx/article/1643107411337.png', '', '123123123123', 54, 1, 0, 0, 1645517333844, 1645517333844, 1);
INSERT INTO `article` VALUES (71, 'one1', 'desc1', '', 'https://baseran2.oss-cn-shenzhen.aliyuncs.com/bbx/article/1643107411337.png', '', '123123123123', 54, 1, 0, 0, 1645517576907, 1645517576907, 1);
INSERT INTO `article` VALUES (72, 'one1', 'desc1', '', 'https://baseran2.oss-cn-shenzhen.aliyuncs.com/bbx/article/1643107411337.png', '', '123123123123', 54, 1, 0, 0, 1645517668099, 1645517668099, 1);
INSERT INTO `article` VALUES (73, 'one2', 'desc1', '', 'https://baseran2.oss-cn-shenzhen.aliyuncs.com/bbx/article/1643107411337.png', '', '123123123123', 54, 1, 0, 0, 1645517714038, 1645517714038, 1);
INSERT INTO `article` VALUES (74, 'one2', 'desc1', '', 'https://baseran2.oss-cn-shenzhen.aliyuncs.com/bbx/article/1643107411337.png', '', '123123123123', 54, 0, 0, 0, 1645517737814, 1645517737814, 1);
INSERT INTO `article` VALUES (75, 'one1', 'desc1', '', 'https://baseran2.oss-cn-shenzhen.aliyuncs.com/bbx/article/1643107411337.png', '', '123123123123', 54, 0, 0, 0, 1645517923198, 1645517923198, 1);
INSERT INTO `article` VALUES (76, '123', '', '', '', '123', '', 1, 1, 0, 0, 1645672976347, 1645672976347, 1);
COMMIT;

-- ----------------------------
-- Table structure for article_article_tag
-- ----------------------------
DROP TABLE IF EXISTS `article_article_tag`;
CREATE TABLE `article_article_tag` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int unsigned NOT NULL COMMENT '文章id',
  `tag_id` int unsigned NOT NULL COMMENT '标签',
  PRIMARY KEY (`id`),
  KEY ```article_id_index``` (`article_id`) USING BTREE,
  KEY ```tag_id_index``` (`tag_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of article_article_tag
-- ----------------------------
BEGIN;
INSERT INTO `article_article_tag` VALUES (1, 75, 3);
INSERT INTO `article_article_tag` VALUES (2, 75, 4);
INSERT INTO `article_article_tag` VALUES (3, 76, 5);
COMMIT;

-- ----------------------------
-- Table structure for article_category
-- ----------------------------
DROP TABLE IF EXISTS `article_category`;
CREATE TABLE `article_category` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题名称',
  `p_id` int unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `article_num` int unsigned NOT NULL DEFAULT '0' COMMENT '文章数量',
  `level` int unsigned NOT NULL DEFAULT '0' COMMENT '层级',
  `sort` int NOT NULL DEFAULT '1' COMMENT '权重，越大越前',
  `created_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_on` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0为已删除，1为正常',
  PRIMARY KEY (`id`),
  KEY ```parent_id_index``` (`p_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of article_category
-- ----------------------------
BEGIN;
INSERT INTO `article_category` VALUES (1, '产品收录', 0, 0, 0, 1, 1643090637, 1643090713, 1);
INSERT INTO `article_category` VALUES (2, '文章', 0, 0, 0, 1, 0, 0, 1);
INSERT INTO `article_category` VALUES (54, '收录', 0, 0, 0, 1, 1643176453582, 1643176453582, 1);
INSERT INTO `article_category` VALUES (55, '产品收录2', 0, 0, 0, 1, 1645433495567, 1645433566483, 0);
COMMIT;

-- ----------------------------
-- Table structure for article_tag
-- ----------------------------
DROP TABLE IF EXISTS `article_tag`;
CREATE TABLE `article_tag` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题名称',
  `created_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_on` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0为已删除，1为正常',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of article_tag
-- ----------------------------
BEGIN;
INSERT INTO `article_tag` VALUES (3, 'tag1', 1645517923256, 1645517923256, 1);
INSERT INTO `article_tag` VALUES (4, 'tag2', 1645517923306, 1645517923306, 1);
INSERT INTO `article_tag` VALUES (5, '123', 1645672976412, 1645672976412, 1);
COMMIT;

-- ----------------------------
-- Table structure for config
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '配置编码',
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '说明',
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '配置值',
  `is_show` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '是否可见（预留字段，暂时没用到）',
  `created_at` bigint unsigned NOT NULL DEFAULT '0',
  `updated_at` bigint unsigned NOT NULL DEFAULT '0',
  `is_on` tinyint unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `config_code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='配置表';

-- ----------------------------
-- Records of config
-- ----------------------------
BEGIN;
INSERT INTO `config` VALUES (1, 'about_us', '关于', '2', 1, 1563195572727, 1646215065865, 1);
INSERT INTO `config` VALUES (2, 'base_setting_name', '基础设置-网站名称', '1', 1, 0, 1646215065884, 1);
INSERT INTO `config` VALUES (3, 'base_setting_favicon', '基础设置-favicon ', '基础设置-favicon ', 1, 0, 1645526885861, 1);
INSERT INTO `config` VALUES (4, 'base_setting_keyword', '基础设置-关键词', '1', 1, 0, 1646215065902, 1);
INSERT INTO `config` VALUES (5, 'base_setting_description', '基础设置-网站描述', '2', 1, 0, 1646215065921, 1);
COMMIT;

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL COMMENT '菜单名称',
  `path` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '#' COMMENT '跳转地址',
  `component` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT '组件',
  `icon` varchar(120) DEFAULT NULL COMMENT '图标标识',
  `p_id` int unsigned DEFAULT '0' COMMENT '上级id',
  `sort` int unsigned DEFAULT '0' COMMENT '排序，从大到小',
  `created_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_on` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0为已删除，1为正常',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `p_id` (`p_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='菜单表\n';

-- ----------------------------
-- Records of menu
-- ----------------------------
BEGIN;
INSERT INTO `menu` VALUES (67, '文章管理', '/article', '#', 'documentation', 0, 0, 1645606764467, 1645606764467, 1);
INSERT INTO `menu` VALUES (68, '文章列表', '/article/lists', '/article/lists/lists', '', 67, 0, 1645606816666, 1645606816666, 1);
INSERT INTO `menu` VALUES (69, '文章分类列表', '/article/categorys', '/article/categorys/lists', '', 67, 0, 1645606911612, 1645606911612, 1);
INSERT INTO `menu` VALUES (70, '添加文章', '/article/add', '/article/lists/add', '', 67, 0, 1645606945534, 1645606945534, 1);
INSERT INTO `menu` VALUES (71, '权限管理', '/rbac', '#', 'lock', 0, 0, 1645606983868, 1645606983868, 1);
INSERT INTO `menu` VALUES (72, '角色列表', '/rbac/roles/lists', '/rbac/roles/lists', '', 71, 0, 1645607011868, 1645607011868, 1);
INSERT INTO `menu` VALUES (73, '菜单列表', '/rbac/menus/lists', '/rbac/menus/lists', '', 71, 0, 1645607027645, 1645607027645, 1);
INSERT INTO `menu` VALUES (74, '权限列表', '/rbac/permissions/lists', '/rbac/permissions/lists', '', 71, 0, 1645607041009, 1645607041009, 1);
INSERT INTO `menu` VALUES (75, '管理员管理', '/admin/user', '#', 'theme', 0, 0, 1645607062091, 1645607062091, 1);
INSERT INTO `menu` VALUES (76, '管理员列表', '/admin/user/lists', '/admin-user/lists/lists', '', 75, 0, 1645607073769, 1645607073769, 1);
INSERT INTO `menu` VALUES (77, '系统管理', '/config', '#', 'component', 0, 0, 1645607084632, 1645607084632, 1);
INSERT INTO `menu` VALUES (78, '网站设置', '/configs', '/configs/site/edit', '', 77, 0, 1645607097170, 1645607097170, 1);
INSERT INTO `menu` VALUES (82, '操作日志', '/system/handle/log/lists', '/system/handle-log/lists', '', 77, 0, 1646647209025, 1646647209025, 1);
COMMIT;

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL COMMENT '名称',
  `code` varchar(120) DEFAULT NULL COMMENT '规则代码',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型：0:菜单; 1:按钮;2:其他',
  `created_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_on` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0为已删除，1为正常',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='权限表';

-- ----------------------------
-- Records of permission
-- ----------------------------
BEGIN;
INSERT INTO `permission` VALUES (11, '渠道管理', '', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (12, '渠道列表', 'App\\Controller\\ChannelController@list', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (13, '新增/修改渠道', 'App\\Controller\\ChannelController@channel_action', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (14, '账户列表', 'App\\Controller\\ChannelController@channel_child', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (15, '消耗数据对比', 'App\\Controller\\ChannelController@consume_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (16, '账户列表', 'App\\Controller\\ChannelController@advervisters', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (17, '日环比分析', 'App\\Controller\\ChannelController@chain_comparison', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (18, '报表管理', '', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (19, 'ROI报表', 'App\\Controller\\RoiController@roi_list', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (20, '注册ARPU/付费ARPPU', 'App\\Controller\\RoiController@arpu_list', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (21, '产品报表', 'App\\Controller\\ReportController@package_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (22, '投放趋势报表', 'App\\Controller\\ReportController@launch_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (23, '利润报表', 'App\\Controller\\ReportController@profit_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (24, 'ROI报表(新)', 'App\\Controller\\ReportController@roi_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (25, 'arpu报表(新)', 'App\\Controller\\ReportController@arpu_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (26, 'arppu报表(新)', 'App\\Controller\\ReportController@arppu_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (27, '数据管理', '', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (28, '付费报表', 'App\\Controller\\ReportController@payment_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (29, '提现报表', 'App\\Controller\\ReportController@withdrawal_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (30, '消耗统计', 'App\\Controller\\ReportController@consume_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (31, '结算报表', 'App\\Controller\\ReportController@settle_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (32, '注册留存报表', 'App\\Controller\\ReportController@retained_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (33, '注册留存统计（新）', 'App\\Controller\\ReportController@retained_report_pack', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (34, '注册留存统计(账户)', 'App\\Controller\\ReportController@retained_advertiser_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (35, '付费留存统计报表', 'App\\Controller\\ReportController@paykeep_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (36, '钻石报表', 'App\\Controller\\ReportController@diamonds_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (37, '图表管理', '', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (38, '受众分析报表', 'App\\Controller\\EchartController@audience', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (39, '结算管理', '', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (40, '充值统计', 'App\\Controller\\ReportController@cooper_report', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (41, '回收趋势', 'App\\Controller\\ReportController@roi_settle', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (42, '注册留存', 'App\\Controller\\ReportController@retained_report_sh', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (43, '付费留存', 'App\\Controller\\ReportController@paykeep_report_sh', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (44, '财务管理', '', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (45, '账户资金流水', 'App\\Controller\\ReportController@daily_stat', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (46, '用户管理', '', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (47, '用户列表', 'App\\Controller\\UserController@list', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (48, '添加用户', 'App\\Controller\\UserController@add_user', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (49, '删除用户', 'App\\Controller\\UserController@del_user', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (50, '其他', '', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (51, '媒体列表', 'App\\Controller\\ChannelController@agent_list', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (52, '产品列表', 'App\\Controller\\ChannelController@package_list', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (53, '代理账户列表', 'App\\Controller\\ChannelController@account', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (54, '修改密码', 'App\\Controller\\LoginController@edit_pwd', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (55, '账户修改', 'App\\Controller\\ChannelController@channel_child_action', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (58, '获取用户可访问菜单', 'App\\Controller\\MenuController@getAllowMenu', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (59, '获取合作商绑定列表', 'App\\Controller\\CooperateAuthController@index', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (60, '获取合作商绑定详情', 'App\\Controller\\CooperateAuthController@show', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (61, '新增合作商绑定', 'App\\Controller\\CooperateAuthController@store', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (62, '更新合作商绑定', 'App\\Controller\\CooperateAuthController@update', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (63, '删除合作商绑定', 'App\\Controller\\CooperateAuthController@destroy', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (64, '投放趋势报表(新)', 'App\\Controller\\ReportController@trend_report_new', 0, 1645606764467, 1645606764467, 1);
INSERT INTO `permission` VALUES (66, 'test1', 'App\\Controller\\PermissionController@store', 0, 1645606764467, 1645606764467, 0);
INSERT INTO `permission` VALUES (67, '123', '123', 0, 1646620794264, 1646622574252, 0);
INSERT INTO `permission` VALUES (68, '222', '222', 1, 1646620909682, 1646622575322, 0);
INSERT INTO `permission` VALUES (69, '33', '33', 2, 1646621139949, 1646622575821, 0);
INSERT INTO `permission` VALUES (70, '4444', '4444', 1, 1646622527908, 1646622576278, 0);
COMMIT;

-- ----------------------------
-- Table structure for permission_menu
-- ----------------------------
DROP TABLE IF EXISTS `permission_menu`;
CREATE TABLE `permission_menu` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int unsigned NOT NULL COMMENT '权限id',
  `menu_id` int unsigned NOT NULL COMMENT '菜单id',
  PRIMARY KEY (`id`),
  KEY `permission_id` (`permission_id`) USING BTREE,
  KEY `menu_id` (`menu_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='权限菜单关系表';

-- ----------------------------
-- Records of permission_menu
-- ----------------------------
BEGIN;
INSERT INTO `permission_menu` VALUES (24, 12, 60);
INSERT INTO `permission_menu` VALUES (25, 13, 60);
INSERT INTO `permission_menu` VALUES (26, 14, 8);
INSERT INTO `permission_menu` VALUES (27, 16, 8);
INSERT INTO `permission_menu` VALUES (28, 17, 10);
INSERT INTO `permission_menu` VALUES (29, 15, 9);
INSERT INTO `permission_menu` VALUES (30, 19, 12);
INSERT INTO `permission_menu` VALUES (31, 20, 13);
INSERT INTO `permission_menu` VALUES (32, 20, 14);
INSERT INTO `permission_menu` VALUES (33, 21, 15);
INSERT INTO `permission_menu` VALUES (34, 22, 16);
INSERT INTO `permission_menu` VALUES (35, 23, 17);
INSERT INTO `permission_menu` VALUES (36, 24, 58);
INSERT INTO `permission_menu` VALUES (37, 25, 19);
INSERT INTO `permission_menu` VALUES (38, 26, 20);
INSERT INTO `permission_menu` VALUES (39, 28, 22);
INSERT INTO `permission_menu` VALUES (40, 29, 23);
INSERT INTO `permission_menu` VALUES (41, 30, 24);
INSERT INTO `permission_menu` VALUES (42, 31, 25);
INSERT INTO `permission_menu` VALUES (43, 32, 26);
INSERT INTO `permission_menu` VALUES (44, 33, 27);
INSERT INTO `permission_menu` VALUES (45, 34, 28);
INSERT INTO `permission_menu` VALUES (46, 36, 30);
INSERT INTO `permission_menu` VALUES (47, 35, 29);
INSERT INTO `permission_menu` VALUES (48, 38, 32);
INSERT INTO `permission_menu` VALUES (49, 40, 34);
INSERT INTO `permission_menu` VALUES (50, 41, 35);
INSERT INTO `permission_menu` VALUES (51, 42, 36);
INSERT INTO `permission_menu` VALUES (52, 45, 40);
INSERT INTO `permission_menu` VALUES (53, 45, 39);
INSERT INTO `permission_menu` VALUES (54, 47, 42);
INSERT INTO `permission_menu` VALUES (55, 48, 42);
INSERT INTO `permission_menu` VALUES (56, 49, 42);
INSERT INTO `permission_menu` VALUES (57, 55, 8);
INSERT INTO `permission_menu` VALUES (58, 43, 37);
INSERT INTO `permission_menu` VALUES (59, 59, 18);
INSERT INTO `permission_menu` VALUES (60, 60, 18);
INSERT INTO `permission_menu` VALUES (61, 61, 18);
INSERT INTO `permission_menu` VALUES (62, 62, 18);
INSERT INTO `permission_menu` VALUES (63, 63, 18);
INSERT INTO `permission_menu` VALUES (64, 64, 62);
COMMIT;

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL COMMENT '角色名称',
  `created_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_on` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0为已删除，1为正常',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name_unique` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='角色表';

-- ----------------------------
-- Records of role
-- ----------------------------
BEGIN;
INSERT INTO `role` VALUES (1, '管理员', 1645525601421, 1645525601421, 1);
INSERT INTO `role` VALUES (2, '代理商', 1645525601421, 1645525601421, 1);
INSERT INTO `role` VALUES (3, '合作商', 1645525601421, 1645525601421, 1);
INSERT INTO `role` VALUES (7, 'test111', 1645525601421, 1645525900679, 0);
INSERT INTO `role` VALUES (8, '111', 1646623899310, 1646623899310, 1);
INSERT INTO `role` VALUES (9, '222', 1646623954046, 1646623954046, 1);
COMMIT;

-- ----------------------------
-- Table structure for role_permission
-- ----------------------------
DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int unsigned NOT NULL COMMENT '角色id',
  `permission_id` int unsigned NOT NULL COMMENT '权限id',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  KEY `permission_id` (`permission_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='角色权限关系表';

-- ----------------------------
-- Records of role_permission
-- ----------------------------
BEGIN;
INSERT INTO `role_permission` VALUES (7, 6, 3);
INSERT INTO `role_permission` VALUES (8, 6, 4);
INSERT INTO `role_permission` VALUES (9, 6, 5);
INSERT INTO `role_permission` VALUES (60, 3, 39);
INSERT INTO `role_permission` VALUES (61, 3, 40);
INSERT INTO `role_permission` VALUES (62, 3, 41);
INSERT INTO `role_permission` VALUES (63, 3, 42);
INSERT INTO `role_permission` VALUES (64, 3, 43);
INSERT INTO `role_permission` VALUES (65, 3, 51);
INSERT INTO `role_permission` VALUES (66, 3, 52);
INSERT INTO `role_permission` VALUES (67, 3, 53);
INSERT INTO `role_permission` VALUES (68, 3, 58);
INSERT INTO `role_permission` VALUES (69, 3, 11);
INSERT INTO `role_permission` VALUES (70, 3, 12);
INSERT INTO `role_permission` VALUES (71, 3, 13);
INSERT INTO `role_permission` VALUES (72, 3, 14);
INSERT INTO `role_permission` VALUES (73, 3, 15);
INSERT INTO `role_permission` VALUES (74, 3, 16);
INSERT INTO `role_permission` VALUES (75, 3, 17);
INSERT INTO `role_permission` VALUES (110, 2, 11);
INSERT INTO `role_permission` VALUES (111, 2, 51);
INSERT INTO `role_permission` VALUES (112, 2, 52);
INSERT INTO `role_permission` VALUES (113, 2, 53);
INSERT INTO `role_permission` VALUES (114, 2, 58);
INSERT INTO `role_permission` VALUES (115, 2, 12);
INSERT INTO `role_permission` VALUES (116, 2, 13);
INSERT INTO `role_permission` VALUES (117, 2, 14);
INSERT INTO `role_permission` VALUES (118, 2, 15);
INSERT INTO `role_permission` VALUES (119, 2, 16);
INSERT INTO `role_permission` VALUES (120, 2, 17);
INSERT INTO `role_permission` VALUES (125, 8, 63);
INSERT INTO `role_permission` VALUES (126, 8, 60);
INSERT INTO `role_permission` VALUES (127, 8, 62);
INSERT INTO `role_permission` VALUES (128, 8, 58);
INSERT INTO `role_permission` VALUES (129, 9, 59);
INSERT INTO `role_permission` VALUES (130, 9, 60);
INSERT INTO `role_permission` VALUES (131, 9, 62);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
