@extends('admin.layouts.app')

@section('title', '访问被拒绝')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">访问被拒绝</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="error-page">
                <h2 class="headline text-warning">403</h2>
                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> 访问被拒绝</h3>
                    <p>
                        抱歉，您没有权限访问此资源。
                        <br>
                        <strong>错误信息：</strong> {{ $exception->getMessage() ?: '您没有权限执行此操作' }}
                    </p>
                    <p>
                        如果您认为这是一个错误，请联系系统管理员。
                    </p>
                    <div class="mt-3">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-home"></i> 返回仪表盘
                        </a>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list"></i> 文章列表
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
