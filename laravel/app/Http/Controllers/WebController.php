<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class WebController extends Controller
{
    /**
     * 首页
     */
    public function index()
    {
        // 从数据库获取已发布的文章，包含用户信息
        $posts = Post::with('user')
            ->where('status', 'published')
            ->whereNotNull('published_at')  // 只获取有发布日期的文章
            ->orderBy('published_at', 'desc')
            ->orderBy('post_id', 'desc')
            ->get();
        
        return view('web.index', compact('posts'));
    }

    /**
     * 关于页面
     */
    public function about()
    {
        return view('web.about');
    }

    /**
     * 文章详情页面
     */
    public function post($slug)
    {
        // 从数据库根据slug获取文章，包含用户信息
        $post = Post::with('user')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();
        
        if (!$post) {
            abort(404);
        }
        
        return view('web.post', compact('post'));
    }
}
