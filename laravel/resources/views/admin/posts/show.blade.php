@extends('admin.layouts.app')

@section('title', '查看文章')
@section('page-title', '查看文章')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">文章管理</a></li>
<li class="breadcrumb-item active">查看文章</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $post->title }}</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> 编辑
                    </a>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> 返回列表
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <!-- 文章信息 -->
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>文章ID:</strong></div>
                            <div class="col-sm-9">{{ $post->post_id }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>标题:</strong></div>
                            <div class="col-sm-9">{{ $post->title }}</div>
                        </div>
                        
                        @if($post->subtitle)
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>副标题:</strong></div>
                            <div class="col-sm-9">{{ $post->subtitle }}</div>
                        </div>
                        @endif
                        
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>Slug:</strong></div>
                            <div class="col-sm-9">
                                <code>{{ $post->slug }}</code>
                                <a href="{{ route('web.post', $post->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary ml-2">
                                    <i class="fas fa-external-link-alt"></i> 查看前台
                                </a>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>状态:</strong></div>
                            <div class="col-sm-9">
                                @if($post->status === 'published')
                                    <span class="badge badge-success">已发布</span>
                                @else
                                    <span class="badge badge-warning">草稿</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>作者:</strong></div>
                            <div class="col-sm-9">{{ $post->user->name }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>创建时间:</strong></div>
                            <div class="col-sm-9">{{ $post->created_at ? $post->created_at->format('Y-m-d H:i:s') : '-' }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>更新时间:</strong></div>
                            <div class="col-sm-9">{{ $post->updated_at ? $post->updated_at->format('Y-m-d H:i:s') : '-' }}</div>
                        </div>
                        
                        @if($post->published_at)
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>发布时间:</strong></div>
                            <div class="col-sm-9">{{ $post->published_at->format('Y-m-d H:i:s') }}</div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="col-md-4">
                        <!-- 操作面板 -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">操作</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> 编辑文章
                                    </a>
                                    
                                    @if($post->status === 'draft')
                                        <form action="{{ route('admin.posts.publish', $post) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="fas fa-paper-plane"></i> 发布文章
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.posts.unpublish', $post) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-warning w-100">
                                                <i class="fas fa-undo"></i> 取消发布
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('web.post', $post->slug) }}" target="_blank" class="btn btn-info">
                                        <i class="fas fa-external-link-alt"></i> 查看前台
                                    </a>
                                    
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('确定要删除这篇文章吗？')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="fas fa-trash"></i> 删除文章
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- 文章内容 -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h4>文章内容</h4>
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs" id="content-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="markdown-tab" data-toggle="tab" href="#markdown-content" role="tab">
                                            Markdown 源码
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="preview-tab" data-toggle="tab" href="#preview-content" role="tab">
                                            预览效果
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="content-tab-content">
                                    <div class="tab-pane fade show active" id="markdown-content" role="tabpanel">
                                        <pre><code>{{ $post->content_markdown }}</code></pre>
                                    </div>
                                    <div class="tab-pane fade" id="preview-content" role="tabpanel">
                                        <div class="markdown-body">
                                            {!! $post->content_html !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection

@push('styles')
<style>
.markdown-body {
    box-sizing: border-box;
    min-width: 200px;
    max-width: 980px;
    margin: 0 auto;
    padding: 45px;
}

@media (max-width: 767px) {
    .markdown-body {
        padding: 15px;
    }
}
</style>
@endpush
