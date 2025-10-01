# 使用 Ubuntu 22.04 LTS 作为基础镜像
FROM ubuntu:22.04

# 设置维护者信息
LABEL maintainer="MatsubaraSoda <MatsubaraSoda@gmail.com>"
LABEL version="07"
LABEL description="Laravel Blog - Production Ready"

# 设置环境变量
ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=Asia/Shanghai
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV DB_CONNECTION=mysql
ENV DB_HOST=127.0.0.1
ENV DB_PORT=3306
ENV DB_DATABASE=laravel_blog
ENV DB_USERNAME=laravel_user
ENV DB_PASSWORD=laravel_pass
ENV MYSQL_ROOT_PASSWORD=root_password

# 安装所有依赖（使用 Ubuntu 22.04 官方仓库默认版本）
RUN apt-get update && \
    apt-get install -y \
    nginx \
    mysql-server \
    software-properties-common \
    curl \
    wget \
    git \
    unzip \
    php8.1 \
    php-fpm \
    php-mysql \
    php-xml \
    php-mbstring \
    php-curl \
    php-zip \
    php-gd \
    php-intl \
    php-bcmath \
    php-redis \
    php-sqlite3 \
    composer \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# 创建应用目录
WORKDIR /var/www/laravel

# 复制配置文件
COPY nginx.conf /etc/nginx/sites-available/default
COPY php-fpm.conf /etc/php/8.1/fpm/pool.d/www.conf
COPY mysql-init.sql /docker-entrypoint-initdb.d/init.sql
COPY seed-data.sql /var/www/laravel/seed-data.sql

# 复制现有的 Laravel 项目（排除vendor目录）
COPY laravel/ /var/www/laravel/

# 复制建站文章到MySQL允许的目录（构建时使用root权限）
COPY 建站文章/ /var/lib/mysql-files/
RUN chmod 644 /var/lib/mysql-files/*.md && \
    chown mysql:mysql /var/lib/mysql-files/*.md

# 安装 Composer 依赖（生产环境优化）
RUN cd /var/www/laravel && \
    composer install --no-dev --optimize-autoloader --no-interaction

# 配置 Laravel 环境
RUN cp .env.example .env && \
    php artisan key:generate

# 预配置数据库连接和APP_URL
RUN sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env && \
    sed -i 's/DB_HOST=.*/DB_HOST=127.0.0.1/' .env && \
    sed -i 's/DB_PORT=.*/DB_PORT=3306/' .env && \
    sed -i 's/DB_DATABASE=.*/DB_DATABASE=laravel_blog/' .env && \
    sed -i 's/DB_USERNAME=.*/DB_USERNAME=laravel_user/' .env && \
    sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=laravel_pass/' .env && \
    sed -i 's|APP_URL=.*|APP_URL=http://localhost:8080|' .env && \
    sed -i 's/APP_ENV=.*/APP_ENV=production/' .env && \
    sed -i 's/APP_DEBUG=.*/APP_DEBUG=false/' .env

# 配置会话管理 - 浏览器关闭时会话过期
RUN sed -i "s/'expire_on_close' => false,/'expire_on_close' => true,/" config/session.php

# 配置时区为北京时间
RUN sed -i "s/'timezone' => 'UTC',/'timezone' => 'Asia\/Shanghai',/" config/app.php

# 配置 MySQL（通过 mysql-init.sql 文件）
RUN service mysql start && \
    mysql -e "SET NAMES utf8mb4; SET CHARACTER SET utf8mb4;" && \
    mysql < /docker-entrypoint-initdb.d/init.sql

# 设置生产环境权限（755 替代 777）
RUN chown -R www-data:www-data /var/www/laravel && \
    chmod -R 755 /var/www/laravel && \
    chmod -R 755 /var/www/laravel/storage && \
    chmod -R 755 /var/www/laravel/bootstrap/cache && \
    chmod -R 755 /var/www/laravel/public && \
    chmod -R 755 /var/www/laravel/vendor

# 生产环境缓存优化
RUN cd /var/www/laravel && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# 声明容器将监听的端口
EXPOSE 80 3306

# 复制启动脚本
COPY start.sh /start.sh
RUN chmod +x /start.sh

# 健康检查
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/health || exit 1

# 启动服务
CMD ["/start.sh"]

# 构建镜像（本地）: docker build -t laravelblog:latest -f Dockerfile .
# 构建镜像（Railway）: 自动检测并构建
# 
# 本地运行:
# docker run -d -p 8080:80 --name LaravelBlogApp \
#   -e APP_URL=http://localhost:8080 \
#   laravelblog:latest
#
# 访问应用: http://localhost:8080
# 后台管理: http://localhost:8080/admin
# 
# 部署说明:
# - APP_ENV=production, APP_DEBUG=false
# - 权限设置为 755（生产安全）
# - 缓存优化已启用
# - 健康检查已配置
# - 自动导入所有建站文章数据
# - 支持动态端口（Railway 兼容）
# - 适用于本地和云端部署

