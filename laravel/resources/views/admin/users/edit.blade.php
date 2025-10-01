@extends('admin.layouts.app')

@section('title', '编辑用户')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">编辑用户</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">仪表盘</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">用户列表</a></li>
                        <li class="breadcrumb-item active">编辑用户</li>
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
                        <!-- /.card-header -->
                        <form action="{{ route('admin.users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <!-- 用户名 -->
                                <div class="form-group">
                                    <label for="name">用户名 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" 
                                           placeholder="请输入用户名" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- 密码 -->
                                <div class="form-group">
                                    <label for="password">新密码</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" 
                                           placeholder="留空表示不修改密码">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">留空表示不修改密码</small>
                                </div>

                                <!-- 确认密码 -->
                                <div class="form-group">
                                    <label for="password_confirmation">确认新密码</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" 
                                           placeholder="请再次输入新密码">
                                </div>

                                <!-- 角色 -->
                                <div class="form-group">
                                    <label for="role">角色 <span class="text-danger">*</span></label>
                                    <select class="form-control @error('role') is-invalid @enderror" 
                                            id="role" name="role" required>
                                        <option value="">请选择角色</option>
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>管理员</option>
                                        <option value="editor" {{ old('role', $user->role) === 'editor' ? 'selected' : '' }}>编辑者</option>
                                        <option value="viewer" {{ old('role', $user->role) === 'viewer' ? 'selected' : '' }}>访客</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> 保存更改
                                </button>
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> 取消
                                </a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-4">
                    <!-- 用户信息 -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">用户信息</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-4"><strong>ID:</strong></div>
                                <div class="col-sm-8">{{ $user->user_id }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-sm-4"><strong>当前角色:</strong></div>
                                <div class="col-sm-8">
                                    @if($user->role === 'admin')
                                        <span class="badge badge-danger">管理员</span>
                                    @elseif($user->role === 'editor')
                                        <span class="badge badge-warning">编辑者</span>
                                    @else
                                        <span class="badge badge-info">访客</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-sm-4"><strong>创建时间:</strong></div>
                                <div class="col-sm-8">{{ $user->created_at ? $user->created_at->format('Y-m-d H:i') : '-' }}</div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-sm-4"><strong>更新时间:</strong></div>
                                <div class="col-sm-8">{{ $user->updated_at ? $user->updated_at->format('Y-m-d H:i') : '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- 注意事项 -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">注意事项</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>重要提示：</strong>
                                <ul class="mb-0 mt-2">
                                    <li>修改密码时，新密码和确认密码必须一致</li>
                                    <li>不能将自己的角色修改为访客</li>
                                    <li>删除用户前请确认该用户没有重要数据</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
