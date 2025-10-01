-- 设置默认字符集
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- 创建数据库
CREATE DATABASE IF NOT EXISTS laravel_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 创建 Laravel 专用用户（如果不存在）
CREATE USER IF NOT EXISTS 'laravel_user'@'localhost' IDENTIFIED BY 'laravel_pass';
CREATE USER IF NOT EXISTS 'laravel_user'@'127.0.0.1' IDENTIFIED BY 'laravel_pass';
GRANT ALL PRIVILEGES ON laravel_blog.* TO 'laravel_user'@'localhost';
GRANT ALL PRIVILEGES ON laravel_blog.* TO 'laravel_user'@'127.0.0.1';
FLUSH PRIVILEGES;

-- 使用数据库
USE laravel_blog;

-- 创建 users 表（包含 remember_token 字段和时间戳）
CREATE TABLE `users` (
  `user_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'editor', 'viewer') NOT NULL DEFAULT 'viewer',
  `remember_token` VARCHAR(100) NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 创建 posts 表（包含时间戳字段）
CREATE TABLE `posts` (
  `post_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `status` ENUM('published', 'draft', 'deleted') NOT NULL DEFAULT 'draft',
  `published_at` DATETIME DEFAULT NULL,
  `subtitle` VARCHAR(255) DEFAULT NULL,
  `content_markdown` LONGTEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 注意：数据插入将在 start.sh 中处理
-- 生产环境：直接插入所有建站文章数据
-- 开发环境：插入示例数据
-- 这里只创建表结构，不插入任何数据
