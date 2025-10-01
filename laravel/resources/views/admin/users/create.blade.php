@extends('admin.layouts.app')

@section('title', '新建用户')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">新建用户</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">仪表盘</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">用户列表</a></li>
                        <li class="breadcrumb-item active">新建用户</li>
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
                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <!-- 用户名 -->
                                <div class="form-group">
                                    <label for="name">用户名 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" 
                                           placeholder="请输入用户名" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- 密码 -->
                                <div class="form-group">
                                    <label for="password">密码 <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" 
                                           placeholder="请输入密码（至少6位）" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- 确认密码 -->
                                <div class="form-group">
                                    <label for="password_confirmation">确认密码 <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" 
                                           placeholder="请再次输入密码" required>
                                </div>

                                <!-- 角色 -->
                                <div class="form-group">
                                    <label for="role">角色 <span class="text-danger">*</span></label>
                                    <select class="form-control @error('role') is-invalid @enderror" 
                                            id="role" name="role" required>
                                        <option value="">请选择角色</option>
                                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>管理员</option>
                                        <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>编辑者</option>
                                        <option value="viewer" {{ old('role') === 'viewer' ? 'selected' : '' }}>访客</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> 创建用户
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> 取消
                                </a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-4">
                    <!-- 角色说明 -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">角色说明</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h5><span class="badge badge-danger">管理员</span></h5>
                                <p class="text-muted small">拥有所有权限，可以管理用户、文章和系统设置。</p>
                            </div>
                            <div class="mb-3">
                                <h5><span class="badge badge-warning">编辑者</span></h5>
                                <p class="text-muted small">可以创建、编辑、发布文章，但只能管理自己的文章。</p>
                            </div>
                            <div class="mb-3">
                                <h5><span class="badge badge-info">访客</span></h5>
                                <p class="text-muted small">只能查看仪表盘，无法进行任何管理操作。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
