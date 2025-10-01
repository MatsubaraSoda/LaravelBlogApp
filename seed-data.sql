-- 建站文章数据导入脚本
-- 使用LOAD_FILE函数读取Markdown文件内容

-- 插入用户数据
INSERT INTO `users` (`name`, `password`, `role`) VALUES
('admin', '$2y$12$Y5U0veQBzQ1WDEo7wV9JyeBjQ3wNTZY.QVRFKdsaDFbR1ufHnfceu', 'admin'),
('editor', '$2y$12$Y5U0veQBzQ1WDEo7wV9JyeBjQ3wNTZY.QVRFKdsaDFbR1ufHnfceu', 'editor'),
('viewer', '$2y$12$Y5U0veQBzQ1WDEo7wV9JyeBjQ3wNTZY.QVRFKdsaDFbR1ufHnfceu', 'viewer');

-- 插入文章：技术栈规划
INSERT INTO `posts` (`user_id`, `title`, `slug`, `status`, `published_at`, `subtitle`, `content_markdown`) VALUES
(1, '技术栈规划', '技术栈规划', 'published', '2025-09-26', '第一步', LOAD_FILE('/var/lib/mysql-files/01_技术栈规划.md'));

-- 插入文章：数据库设计
INSERT INTO `posts` (`user_id`, `title`, `slug`, `status`, `published_at`, `subtitle`, `content_markdown`) VALUES
(1, '数据库设计', '数据库设计', 'published', '2025-09-27', '第二步', LOAD_FILE('/var/lib/mysql-files/02_数据库设计.md'));

-- 插入文章：使用 Laravel
INSERT INTO `posts` (`user_id`, `title`, `slug`, `status`, `published_at`, `subtitle`, `content_markdown`) VALUES
(1, '使用 Laravel', '使用-Laravel', 'published', '2025-09-28', '第三步', LOAD_FILE('/var/lib/mysql-files/03_使用 Laravel.md'));

-- 插入文章：容器与部署
INSERT INTO `posts` (`user_id`, `title`, `slug`, `status`, `published_at`, `subtitle`, `content_markdown`) VALUES
(1, '容器与部署', '容器与部署', 'published', '2025-09-29', '第四步', LOAD_FILE('/var/lib/mysql-files/04_容器与部署.md'));

-- 插入文章：Nginx 与 PHP-FPM 配置
INSERT INTO `posts` (`user_id`, `title`, `slug`, `status`, `published_at`, `subtitle`, `content_markdown`) VALUES
(1, 'Nginx 与 PHP-FPM 配置', 'Nginx-与-PHP-FPM-配置', 'published', '2025-09-30', '第五步', LOAD_FILE('/var/lib/mysql-files/05_Nginx 与 PHP-FPM 配置.md'));

-- 插入文章：权限系统设计
INSERT INTO `posts` (`user_id`, `title`, `slug`, `status`, `published_at`, `subtitle`, `content_markdown`) VALUES
(1, '权限系统设计', '权限系统设计', 'published', '2025-10-01', '第六步', LOAD_FILE('/var/lib/mysql-files/06_权限系统设计.md'));

-- 插入文章：认证与会话
INSERT INTO `posts` (`user_id`, `title`, `slug`, `status`, `published_at`, `subtitle`, `content_markdown`) VALUES
(1, '认证与会话', '认证与会话', 'published', '2025-10-02', '第七步', LOAD_FILE('/var/lib/mysql-files/07_认证与会话.md'));

-- 插入文章：文章系统实现
INSERT INTO `posts` (`user_id`, `title`, `slug`, `status`, `published_at`, `subtitle`, `content_markdown`) VALUES
(1, '文章系统实现', '文章系统实现', 'published', '2025-10-03', '第八步', LOAD_FILE('/var/lib/mysql-files/08_文章系统实现.md'));

-- 插入文章：Markdown 与 Slug
INSERT INTO `posts` (`user_id`, `title`, `slug`, `status`, `published_at`, `subtitle`, `content_markdown`) VALUES
(1, 'Markdown 与 Slug', 'Markdown-与-Slug', 'published', '2025-10-04', '第九步', LOAD_FILE('/var/lib/mysql-files/09_Markdown 与 Slug.md'));

-- 插入文章：运维与排错
INSERT INTO `posts` (`user_id`, `title`, `slug`, `status`, `published_at`, `subtitle`, `content_markdown`) VALUES
(1, '运维与排错', '运维与排错', 'published', '2025-10-05', '第十步', LOAD_FILE('/var/lib/mysql-files/10_运维与排错.md'));
