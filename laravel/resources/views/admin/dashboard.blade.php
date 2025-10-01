@extends('admin.layouts.app')

@section('title', '仪表盘')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">仪表盘</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">仪表盘</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Viewer 欢迎信息 -->
            @if($user->role === 'viewer')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">欢迎使用 Laravel Blog 系统</h3>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <h4>欢迎，{{ $user->name }}！</h4>
                                <p class="text-muted">您当前的身份是：<span class="badge badge-info">{{ ucfirst($user->role) }}</span></p>
                                <p>作为访客用户，您可以浏览网站内容，但无法进行文章管理操作。</p>
                                <div class="mt-4">
                                    <a href="/" class="btn btn-primary btn-lg" target="_blank">
                                        <i class="fas fa-external-link-alt"></i> 访问网站首页
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <!-- 全局统计 (仅admin可见) -->
            @if($user->role === 'admin' && isset($data['global_stats']))
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $data['global_stats']['total_published_posts'] }}</h3>
                            <p>已发布文章数</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $data['global_stats']['total_users'] }}</h3>
                            <p>用户数</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">系统信息</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>PHP版本:</strong> {{ $data['global_stats']['system_info']['php_version'] }}</p>
                                    <p><strong>Laravel版本:</strong> {{ $data['global_stats']['system_info']['laravel_version'] }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>服务器时间:</strong> {{ $data['global_stats']['system_info']['server_time'] }}</p>
                                    <p><strong>用户角色:</strong> <span class="badge badge-primary">{{ ucfirst($user->role) }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- 个人统计 -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $data['personal_stats']['total_posts'] }}</h3>
                            <p>我的总文章数</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $data['personal_stats']['published_posts'] }}</h3>
                            <p>已发布</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $data['personal_stats']['draft_posts'] }}</h3>
                            <p>草稿</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $user->role === 'admin' ? 'Admin' : 'Editor' }}</h3>
                            <p>权限级别</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 最近文章和快速操作 -->
            <div class="row">
                <!-- 最近文章 -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">最近文章</h3>
                        </div>
                        <div class="card-body">
                            @if($data['recent_posts']->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>标题</th>
                                                <th>状态</th>
                                                <th>创建时间</th>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data['recent_posts'] as $post)
                                            <tr>
                                                <td>{{ Str::limit($post->title, 30) }}</td>
                                                <td>
                                                    @if($post->status === 'published')
                                                        <span class="badge badge-success">已发布</span>
                                                    @else
                                                        <span class="badge badge-warning">草稿</span>
                                                    @endif
                                                </td>
                                                <td>{{ $post->created_at ? $post->created_at->format('Y-m-d H:i') : '-' }}</td>
                                                <td>
                                                    <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> 查看
                                                    </a>
                                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i> 编辑
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">暂无文章</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- 快速操作 -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">快速操作</h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <a href="{{ route('admin.posts.create') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-plus"></i> 新建文章
                                </a>
                                <a href="{{ route('admin.posts.index') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-list"></i> 文章列表
                                </a>
                                @if($user->role === 'admin')
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-users"></i> 用户管理
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-cog"></i> 系统设置
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
</div>
@endsection