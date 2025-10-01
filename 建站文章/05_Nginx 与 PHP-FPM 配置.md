# Nginx 与 PHP-FPM 配置

记录站点转发与 PHP-FPM 参数（精简）。

## Nginx 站点

文件：`/etc/nginx/sites-available/default`

要点：
- 根目录：`/var/www/laravel/public`
- 静态资源缓存：`css/js/img/font` 一年缓存
- `/admin` 特殊路由：`try_files $uri /index.php?$query_string;`
- 其余路由：`try_files $uri $uri/ /index.php?$query_string;`
- PHP 转发：`fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;`
- 安全响应头：`X-Frame-Options`、`X-Content-Type-Options` 等

健康检查：
```nginx
location /health { return 200 "healthy\n"; }
```

## PHP-FPM 池

文件：`/etc/php/8.1/fpm/pool.d/www.conf`

要点：
- 用户与组：`www-data`
- 监听：`/var/run/php/php8.1-fpm.sock`
- 进程模型：`pm=dynamic`，`max_children=50`
- 上传/内存：`upload_max_filesize=100M`，`post_max_size=100M`，`memory_limit=256M`
- 慢日志：`slowlog=/var/log/php8.1-fpm-slow.log`

## 常用命令
```bash
nginx -t && service nginx reload
service php8.1-fpm restart
tail -n 200 /var/log/nginx/laravel_error.log
```
