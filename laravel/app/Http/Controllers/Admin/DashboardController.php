<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * 显示仪表盘
     */
    public function index()
    {
        $user = Auth::user();
        $data = [];

        // 如果是viewer，只显示欢迎信息
        if ($user->role === 'viewer') {
            return view('admin.dashboard', compact('data', 'user'));
        }

        // 如果是admin，显示全局数据
        if ($user->role === 'admin') {
            $data['global_stats'] = [
                'total_published_posts' => Post::where('status', 'published')->count(),
                'total_users' => User::count(),
                'system_info' => [
                    'php_version' => PHP_VERSION,
                    'laravel_version' => app()->version(),
                    'server_time' => now()->format('Y-m-d H:i:s'),
                ]
            ];
        }

        // admin和editor显示个人数据
        if (in_array($user->role, ['admin', 'editor'])) {
            $data['personal_stats'] = [
                'total_posts' => Post::where('user_id', $user->user_id)->count(),
                'published_posts' => Post::where('user_id', $user->user_id)->where('status', 'published')->count(),
                'draft_posts' => Post::where('user_id', $user->user_id)->where('status', 'draft')->count(),
            ];

            // 最近文章（个人）
            $data['recent_posts'] = Post::where('user_id', $user->user_id)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return view('admin.dashboard', compact('data', 'user'));
    }
}