@extends('admin.layouts.app')

@section('title', '文章管理')
@section('page-title', '文章列表')

@section('breadcrumb')
<li class="breadcrumb-item active">文章列表</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">文章列表</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> 新建文章
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>标题</th>
                            <th>副标题</th>
                            <th>状态</th>
                            <th>作者</th>
                            <th>发布时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                        <tr>
                            <td>{{ $post->post_id }}</td>
                            <td>
                                <a href="{{ route('web.post', $post->slug) }}" target="_blank" class="text-decoration-none">
                                    {{ $post->title }}
                                </a>
                            </td>
                            <td>{{ $post->subtitle ?: '-' }}</td>
                            <td>
                                @if($post->status === 'published')
                                    <span class="badge badge-success">已发布</span>
                                @else
                                    <span class="badge badge-warning">草稿</span>
                                @endif
                            </td>
                            <td>{{ $post->user->name }}</td>
                            <td>{{ $post->published_at ? $post->published_at->format('Y-m-d H:i') : '-' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-info btn-sm" title="查看详情">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning btn-sm" title="编辑">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($post->status === 'draft')
                                        <form action="{{ route('admin.posts.publish', $post) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm" title="发布">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.posts.unpublish', $post) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-secondary btn-sm" title="取消发布">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('确定要删除这篇文章吗？')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="删除">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">暂无文章</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            
            @if($posts->hasPages())
            <div class="card-footer clearfix">
                {{ $posts->links() }}
            </div>
            @endif
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
