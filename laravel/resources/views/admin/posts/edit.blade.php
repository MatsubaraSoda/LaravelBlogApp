@extends('admin.layouts.app')

@section('title', '编辑文章')
@section('page-title', '编辑文章')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">文章管理</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.posts.show', $post) }}">查看文章</a></li>
<li class="breadcrumb-item active">编辑文章</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card" style="height: calc(99vh - 200px); overflow-y: auto;">
            <div class="card-header">
                <h3 class="card-title">编辑文章</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form action="{{ route('admin.posts.update', $post) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8 d-flex flex-column">
                            <!-- 标题 -->
                            <div class="form-group">
                                <label for="title">标题 <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $post->title) }}" 
                                       placeholder="请输入文章标题" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 副标题 -->
                            <div class="form-group">
                                <label for="subtitle">副标题</label>
                                <input type="text" class="form-control @error('subtitle') is-invalid @enderror" 
                                       id="subtitle" name="subtitle" value="{{ old('subtitle', $post->subtitle) }}" 
                                       placeholder="请输入副标题（可选）">
                                @error('subtitle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- 内容 -->
                            <div class="form-group d-flex flex-column flex-fill">
                                <label for="content_markdown">内容</label>
                                <textarea class="form-control @error('content_markdown') is-invalid @enderror flex-fill" 
                                          id="content_markdown" name="content_markdown" 
                                          placeholder="请输入文章内容（支持 Markdown 格式）" 
                                          style="min-height: 300px;">{{ old('content_markdown', $post->content_markdown) }}</textarea>
                                @error('content_markdown')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    支持 Markdown 语法，如：**粗体**、*斜体*、[链接](url)、# 标题等
                                </small>
                            </div>
                        </div>

                        <div class="col-md-4 d-flex align-items-stretch flex-column">
                            <!-- 文章信息 -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">文章信息</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-4"><strong>ID:</strong></div>
                                        <div class="col-sm-8">{{ $post->post_id }}</div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-sm-4"><strong>Slug:</strong></div>
                                        <div class="col-sm-8">
                                            <code>{{ $post->slug }}</code>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-sm-4"><strong>状态:</strong></div>
                                        <div class="col-sm-8">
                                            @if($post->status === 'published')
                                                <span class="badge badge-success">已发布</span>
                                            @else
                                                <span class="badge badge-warning">草稿</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-sm-4"><strong>作者:</strong></div>
                                        <div class="col-sm-8">{{ $post->user->name }}</div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <div class="col-sm-4"><strong>创建时间:</strong></div>
                                        <div class="col-sm-8">{{ $post->created_at ? $post->created_at->format('Y-m-d H:i') : '-' }}</div>
                                    </div>
                                    
                                    @if($post->published_at)
                                    <div class="row mb-2">
                                        <div class="col-sm-4"><strong>发布时间:</strong></div>
                                        <div class="col-sm-8">{{ $post->published_at->format('Y-m-d H:i') }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- 预览卡片 -->
                            <div class="card d-flex flex-fill">
                                <div class="card-header">
                                    <h3 class="card-title">Markdown 预览</h3>
                                </div>
                                <div class="card-body" id="preview-content" style="padding: 20px;">
                                    <p class="text-muted">输入内容后将显示预览...</p>
                                </div>
                            </div>

                            <!-- 操作按钮 -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> 保存更改
                                </button>
                                <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> 取消
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentTextarea = document.getElementById('content_markdown');
    const previewContent = document.getElementById('preview-content');
    
    if (!contentTextarea || !previewContent) {
        console.error('找不到必要的 DOM 元素');
        return;
    }
    
    // 配置 marked 选项
    marked.setOptions({
        breaks: true,        // 支持换行符转换为 <br>
        gfm: true,          // 启用 GitHub Flavored Markdown
        sanitize: false,    // 不清理 HTML（允许 HTML 标签）
        smartLists: true,   // 智能列表
        smartypants: true   // 智能标点符号
    });
    
    // 专业的 Markdown 预览功能
    function updatePreview() {
        const markdownText = contentTextarea.value;
        
        if (markdownText.trim() === '') {
            previewContent.innerHTML = '<p class="text-muted">输入内容后将显示预览...</p>';
            previewContent.className = '';
            return;
        }
        
        try {
            // 使用 marked 解析 Markdown 并渲染为 HTML
            const htmlContent = marked.parse(markdownText);
            
            // 直接渲染HTML内容并应用markdown-body样式
            previewContent.innerHTML = htmlContent;
            previewContent.className = 'markdown-body';
            
        } catch (error) {
            console.error('Markdown 解析错误:', error);
            previewContent.innerHTML = '<p class="text-danger">Markdown 解析错误，请检查语法。</p>';
            previewContent.className = '';
        }
    }
    
    // 监听输入事件，实现实时预览
    contentTextarea.addEventListener('input', updatePreview);
    
    // 监听粘贴事件
    contentTextarea.addEventListener('paste', () => {
        // 延迟一帧执行，确保粘贴内容已经插入
        setTimeout(updatePreview, 0);
    });
    
    // 初始预览
    updatePreview();
});
</script>
@endpush
