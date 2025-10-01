# 使用 Laravel

本文记录了 Laravel Blog 项目中使用的 Laravel 功能配置。

## 路由系统

### 路由分组
- **前台路由** (`web.php`): Clean Blog 展示界面
- **后台路由** (`admin.php`): AdminLTE 管理界面  
- **认证路由** (`auth.php`): 登录/登出功能

### 路由中间件
- `auth`: 用户认证检查
- `guest`: 访客访问限制
- `role:admin,editor`: 自定义角色权限检查

### 路由模型绑定
```php
Route::get('/post/{slug}', [WebController::class, 'post'])
    ->where('slug', '.*');  // 支持中文slug
```

## 认证系统

### 用户认证
- 使用 Laravel 内置 `Auth` facade
- 支持"记住我"功能
- 自定义用户字段：`name` 替代 `email`

### 会话管理
- 驱动：`file` (默认)
- 过期策略：`expire_on_close => true` (浏览器关闭时过期)
- 时区：`Asia/Shanghai`

### 权限控制
- 三级角色：`admin`、`editor`、`viewer`
- 自定义中间件 `CheckRole` 实现角色检查
- 权限隔离：editor 只能管理自己的文章

## 模型系统

### User 模型
```php
protected $primaryKey = 'user_id';
protected $fillable = ['name', 'password', 'role', 'remember_token'];
protected $casts = ['password' => 'hashed'];
```

### Post 模型
```php
protected $primaryKey = 'post_id';
protected $fillable = ['user_id', 'title', 'slug', 'status', 'published_at', 'subtitle', 'content_markdown'];
protected $casts = ['published_at' => 'date'];
```

### 模型关系
- `User::posts()`: 一对多关系
- `Post::user()`: 多对一关系

### 访问器
- `Post::getContentHtmlAttribute()`: Markdown 转 HTML
- `Post::getFormattedPublishedAtAttribute()`: 格式化发布时间

## 控制器功能

### 认证控制器
- `showLoginForm()`: 显示登录表单
- `login()`: 处理登录请求
- `logout()`: 处理登出请求

### 文章控制器
- 完整的 CRUD 操作
- 权限检查：`checkPostPermission()`
- Slug 生成：支持中文标题
- 发布/取消发布功能

### 权限控制逻辑
```php
// admin: 访问所有文章
// editor: 只能访问自己的文章
// viewer: 无权限访问管理功能
```

## 验证系统

### 表单验证
- 使用 `$request->validate()` 进行验证
- 自定义验证消息（中文）
- 唯一性验证：文章标题、用户名称

### 验证规则示例
```php
'title' => 'required|string|max:255|unique:posts,title'
'name' => 'required|string|max:255'
'password' => 'required|string|min:1'
```

## 视图系统

### Blade 模板
- 模板继承：`@extends`、`@section`、`@yield`
- 组件化：`@include` 引入公共组件
- 条件渲染：`@if`、`@foreach`、`@auth`

### 视图组织
- `resources/views/web/`: 前台模板
- `resources/views/admin/`: 后台模板
- 布局文件：`layouts/app.blade.php`

## 数据库功能

### Eloquent ORM
- 模型查询：`Post::with('user')->paginate(15)`
- 条件查询：`where('user_id', $user->user_id)`
- 排序：`orderBy('post_id', 'desc')`

### 分页
- 使用 Laravel 内置分页：`paginate(15)`
- 自动生成分页链接

## 辅助功能

### 字符串处理
- 自定义 Slug 生成：支持中文标题

### 时间处理
- `now()`: 获取当前时间
- Carbon 日期处理：`published_at->format('Y年m月d日')`

### Markdown 处理
- 使用 `Parsedown` 库转换 Markdown
- 在模型中定义访问器自动转换

## 配置要点

### 环境配置
- 数据库连接：MySQL
- 会话驱动：文件存储
- 时区设置：北京时间

### 安全配置
- CSRF 保护：`VerifyCsrfToken` 中间件
- 密码加密：`hashed` 类型转换
- 会话安全：自动过期、令牌重新生成

这个配置实现了完整的博客系统功能，包括用户认证、权限管理、内容管理、前后台分离等核心特性。
