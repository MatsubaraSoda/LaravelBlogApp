#!/bin/bash

# 生产环境启动脚本

# 启动 MySQL 服务
echo "启动 MySQL 服务..."
service mysql start

# 等待 MySQL 启动
sleep 5

# 检查 MySQL 是否启动成功
while ! mysqladmin ping -h 127.0.0.1 --silent; do
    echo "等待 MySQL 启动..."
    sleep 2
done

echo "MySQL 已启动"

# 启动 PHP-FPM 服务
echo "启动 PHP-FPM 服务..."
service php8.1-fpm start

# 启动 Nginx 服务
echo "启动 Nginx 服务..."
service nginx start

# 切换到Laravel目录
cd /var/www/laravel

# 初始化数据库
echo "初始化数据库..."
mysql -u root -p$MYSQL_ROOT_PASSWORD < /docker-entrypoint-initdb.d/init.sql

# 检查数据库表是否存在，如果不存在则运行迁移
echo "检查数据库表结构..."
if ! mysql -u laravel_user -plaravel_pass -e "USE laravel_blog; SHOW TABLES LIKE 'users';" | grep -q "users"; then
    echo "数据库表不存在，运行 Laravel 数据库迁移..."
    php artisan migrate --force
else
    echo "数据库表已存在，跳过迁移..."
fi

# 给laravel_user授予FILE权限以读取建站文章
echo "授予laravel_user FILE权限..."
mysql -u root -p$MYSQL_ROOT_PASSWORD -e "GRANT FILE ON *.* TO 'laravel_user'@'localhost'; FLUSH PRIVILEGES;"

# 插入建站文章数据
echo "生产环境模式，插入建站文章数据"
echo "正在插入建站文章数据..."
mysql -u laravel_user -plaravel_pass --default-character-set=utf8mb4 laravel_blog < /var/www/laravel/seed-data.sql
echo "建站文章数据插入完成"

# 生产环境缓存优化（仅在需要时执行）
echo "检查缓存状态..."
if [ ! -f bootstrap/cache/config.php ]; then
    echo "生成生产环境缓存..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    echo "缓存生成完成"
else
    echo "缓存已存在，跳过缓存生成"
fi

# 设置生产环境权限
echo "设置生产环境权限..."
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 保持容器运行
echo "所有服务已启动，容器运行中..."
echo "访问地址: http://localhost:8080"
echo "后台管理: http://localhost:8080/admin"
echo "默认账户: admin/123, editor/123, viewer/123"

# 输出日志到标准输出（容器友好）
tail -f /dev/stdout