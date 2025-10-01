<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * 检查用户是否有权限访问文章
     */
    private function checkPostPermission(Post $post)
    {
        $user = Auth::user();
        
        // admin可以访问所有文章
        if ($user->role === 'admin') {
            return true;
        }
        
        // editor只能访问自己的文章
        if ($user->role === 'editor' && $post->user_id === $user->user_id) {
            return true;
        }
        
        return false;
    }
    /**
     * 显示文章列表
     */
    public function index()
    {
        $user = Auth::user();
        
        // 根据用户角色决定显示范围
        if ($user->role === 'admin') {
            // admin可以看到所有文章
            $posts = Post::with('user')
                ->orderBy('post_id', 'desc')
                ->paginate(15);
        } elseif ($user->role === 'editor') {
            // editor只能看到自己的文章
            $posts = Post::with('user')
                ->where('user_id', $user->user_id)
                ->orderBy('post_id', 'desc')
                ->paginate(15);
        } else {
            // viewer或其他角色不应该访问此页面
            abort(403, '您没有权限访问文章管理');
        }

        return view('admin.posts.list', compact('posts'));
    }

    /**
     * 显示新建文章表单
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * 保存新文章
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title',
            'subtitle' => 'nullable|string|max:255',
            'content_markdown' => 'nullable|string',
        ]);

        $data = $request->only(['title', 'subtitle', 'content_markdown']);
        
        // 生成 URL 友好的 slug
        $data['slug'] = $this->generateSlug($data['title']);
        
        // 设置用户ID为当前登录用户
        $data['user_id'] = Auth::user()->user_id;
        
        // 新建文章默认为草稿状态
        $data['status'] = 'draft';

        Post::create($data);

        return redirect()->route('admin.posts.index')
            ->with('success', '文章创建成功！');
    }

    /**
     * 显示指定文章
     */
    public function show(Post $post)
    {
        // 检查权限
        if (!$this->checkPostPermission($post)) {
            abort(403, '您没有权限访问此文章');
        }
        
        return view('admin.posts.show', compact('post'));
    }

    /**
     * 显示编辑文章表单
     */
    public function edit(Post $post)
    {
        // 检查权限
        if (!$this->checkPostPermission($post)) {
            abort(403, '您没有权限编辑此文章');
        }
        
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * 更新文章
     */
    public function update(Request $request, Post $post)
    {
        // 检查权限
        if (!$this->checkPostPermission($post)) {
            abort(403, '您没有权限更新此文章');
        }
        
        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,' . $post->post_id . ',post_id',
            'subtitle' => 'nullable|string|max:255',
            'content_markdown' => 'nullable|string',
        ]);

        $data = $request->only(['title', 'subtitle', 'content_markdown']);
        
        // 如果标题改变，重新生成 slug
        if ($data['title'] !== $post->title) {
            $data['slug'] = $this->generateSlug($data['title']);
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')
            ->with('success', '文章更新成功！');
    }

    /**
     * 删除文章
     */
    public function destroy(Post $post)
    {
        // 检查权限
        if (!$this->checkPostPermission($post)) {
            abort(403, '您没有权限删除此文章');
        }
        
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', '文章删除成功！');
    }

    /**
     * 发布文章
     */
    public function publish(Post $post)
    {
        // 检查权限
        if (!$this->checkPostPermission($post)) {
            abort(403, '您没有权限发布此文章');
        }
        
        $post->update([
            'status' => 'published',
            'published_at' => now()
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', '文章发布成功！');
    }

    /**
     * 取消发布文章
     */
    public function unpublish(Post $post)
    {
        // 检查权限
        if (!$this->checkPostPermission($post)) {
            abort(403, '您没有权限取消发布此文章');
        }
        
        $post->update([
            'status' => 'draft',
            'published_at' => null
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', '文章已取消发布！');
    }

    /**
     * 生成 URL 友好的 slug
     */
    private function generateSlug($title)
    {
        // 保留中文，只处理空格和特殊字符
        $slug = $title;
        
        // 替换空格为减号
        $slug = preg_replace('/\s+/', '-', $slug);
        
        // 替换特殊字符为减号（保留中文、英文、数字、减号）
        $slug = preg_replace('/[^\p{L}\p{N}\-]/u', '-', $slug);
        
        // 清理多余的减号
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // 如果 slug 为空，使用时间戳
        if (empty($slug)) {
            $slug = 'post-' . time();
        }
        
        // 确保 slug 唯一
        $originalSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
}
