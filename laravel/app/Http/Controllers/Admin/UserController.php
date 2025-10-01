<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * 显示用户列表
     */
    public function index()
    {
        $users = User::orderBy('user_id', 'desc')->paginate(15);
        return view('admin.users.list', compact('users'));
    }

    /**
     * 显示新建用户表单
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * 保存新用户
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,editor,viewer'
        ]);

        $data = $request->only(['name', 'role']);
        $data['password'] = Hash::make($request->password);

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', '用户创建成功！');
    }

    /**
     * 显示指定用户
     */
    public function show(User $user)
    {
        // 获取用户文章统计
        $userStats = [
            'total_posts' => $user->posts()->count(),
            'published_posts' => $user->posts()->where('status', 'published')->count(),
            'draft_posts' => $user->posts()->where('status', 'draft')->count(),
        ];

        // 获取用户最近文章
        $recentPosts = $user->posts()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.users.show', compact('user', 'userStats', 'recentPosts'));
    }

    /**
     * 显示编辑用户表单
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * 更新用户
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $user->user_id . ',user_id',
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,editor,viewer'
        ]);

        $data = $request->only(['name', 'role']);
        
        // 如果提供了新密码，则更新密码
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // 防止降级为viewer
        if ($user->user_id === Auth::user()->user_id && $request->role === 'viewer') {
            return back()->with('error', '不能将自己的角色修改为访客');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', '用户更新成功！');
    }

    /**
     * 删除用户
     */
    public function destroy(User $user)
    {
        // 防止删除自己
        if ($user->user_id === Auth::user()->user_id) {
            return back()->with('error', '不能删除自己的账户');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', '用户删除成功！');
    }
}