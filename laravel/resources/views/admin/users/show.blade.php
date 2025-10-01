@extends('admin.layouts.app')

@section('title', '查看用户')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">查看用户</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">仪表盘</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">用户列表</a></li>
                        <li class="breadcrumb-item active">查看用户</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">用户信息</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>用户ID:</strong></div>
                                <div class="col-sm-9">{{ $user->user_id }}</div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>用户名:</strong></div>
                                <div class="col-sm-9">{{ $user->name }}</div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>角色:</strong></div>
                                <div class="col-sm-9">
                                    @if($user->role === 'admin')
                                        <span class="badge badge-danger">管理员</span>
                                    @elseif($user->role === 'editor')
                                        <span class="badge badge-warning">编辑者</span>
                                    @else
                                        <span class="badge badge-info">访客</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>创建时间:</strong></div>
                                <div class="col-sm-9">{{ $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '-' }}</div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>更新时间:</strong></div>
                                <div class="col-sm-9">{{ $user->updated_at ? $user->updated_at->format('Y-m-d H:i:s') : '-' }}</div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> 编辑用户
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> 返回列表
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- 用户统计 -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">文章统计</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $userStats['total_posts'] }}</h5>
                                        <span class="description-text">总文章数</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="description-block">
                                        <h5 class="description-header text-success">{{ $userStats['published_posts'] }}</h5>
                                        <span class="description-text">已发布</span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="description-block">
                                        <h5 class="description-header text-warning">{{ $userStats['draft_posts'] }}</h5>
                                        <span class="description-text">草稿</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 最近文章 -->
                    @if($recentPosts->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">最近文章</h3>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @foreach($recentPosts as $post)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ Str::limit($post->title, 30) }}</h6>
                                        <small>{{ $post->created_at ? $post->created_at->format('m-d') : '-' }}</small>
                                    </div>
                                    <p class="mb-1">
                                        @if($post->status === 'published')
                                            <span class="badge badge-success">已发布</span>
                                        @else
                                            <span class="badge badge-warning">草稿</span>
                                        @endif
                                    </p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
