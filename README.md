# Laravel Blog

全栈博客系统 Demo，展示初级全栈web应用开发能力。

## 快速部署

```bash
# 1. 拉取基础镜像
docker pull ubuntu:22.04

# 2. 克隆项目
git clone https://github.com/MatsubaraSoda/LaravelBlogApp.git
cd LaravelBlogApp

# 3. 构建镜像（首次需要 10-20 分钟）
docker build -t laravelblog:latest -f Dockerfile .

# 4. 运行容器
docker run -d -p 8080:80 --name LaravelBlogApp laravelblog:latest

# 5. 等待 30 秒后访问
```

**访问地址**：
- 前台：http://localhost:8080
- 后台：http://localhost:8080/admin

**默认账号**：
- 管理员：`admin` / `123`
- 编辑者：`editor` / `123`
- 访客：`viewer` / `123`

## 容器管理

```bash
# 查看日志
docker logs -f LaravelBlogApp

# 重启
docker restart LaravelBlogApp

# 停止并删除
docker stop LaravelBlogApp && docker rm LaravelBlogApp
```

## 技术栈

Laravel 10.x + MySQL 8.x + Nginx + AdminLTE + Clean Blog

## 应用功能

- 三级权限系统（管理员/编辑者/访客）
- 文章管理（创建、编辑、发布）
- Markdown 编辑器
- 用户管理（需要管理员权限）
- 内置 10 篇开发文档

## 说明

Demo 项目，仅用于学习展示。All-in-One 单容器架构，适合本地开发测试。

---

**开发者**: MatsubaraSoda
