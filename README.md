# Laravel Blog - 全栈博客系统

基于 Laravel + AdminLTE + Clean Blog 的全栈博客系统，Docker 一键部署。

## 🚀 快速开始

### 1. 拉取基础镜像
```bash
docker pull ubuntu:22.04
```

### 2. 克隆并构建
```bash
git clone https://github.com/MatsubaraSoda/LaravelBlogApp.git
cd LaravelBlogApp
docker build -t laravelblog:ver07 -f Dockerfile.07 .
```

### 3. 运行容器
```bash
docker run -d -p 8080:80 --name LaravelBlogApp07 \
  -e APP_URL=http://localhost:8080 \
  laravelblog:ver07
```

### 4. 访问应用
- 前台：http://localhost:8080
- 后台：http://localhost:8080/admin

## 🔐 登录信息

| 用户名 | 密码 | 权限 |
|--------|------|------|
| admin  | 123  | 管理员 |
| editor | 123  | 编辑者 |
| viewer | 123  | 访客 |

## 📦 技术栈

- Laravel 10 + PHP 8.1
- MySQL 8.0
- Nginx
- AdminLTE 3.2.0 + Clean Blog
- Docker (All-in-One)

## 🛠️ 容器管理

```bash
# 查看日志
docker logs -f LaravelBlogApp07

# 停止容器
docker stop LaravelBlogApp07

# 删除容器
docker rm LaravelBlogApp07

# 重新部署
docker stop LaravelBlogApp07 && docker rm LaravelBlogApp07
docker build -t laravelblog:ver07 -f Dockerfile.07 .
docker run -d -p 8080:80 --name LaravelBlogApp07 -e APP_URL=http://localhost:8080 laravelblog:ver07
```

## 📚 功能特性

- 三级权限系统（admin/editor/viewer）
- 文章管理（创建、编辑、发布）
- Markdown 编辑器（实时预览）
- 用户管理（仅管理员）
- 响应式布局
- 内置 10 篇开发文档

## ⚠️ 说明

这是一个 **Demo 项目**，用于展示全栈开发能力，不适合生产环境使用。

---

**开发者**: MatsubaraSoda | **邮箱**: MatsubaraSoda@gmail.com

