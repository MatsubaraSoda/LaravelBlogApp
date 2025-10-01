<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * 显示登录表单
     */
    public function showLoginForm()
    {
        // 如果用户已经登录，重定向到仪表盘
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login');
    }

    /**
     * 处理登录请求
     */
    public function login(Request $request)
    {
        // 验证输入
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:1',
        ], [
            'name.required' => '请输入用户名',
            'password.required' => '请输入密码',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // 尝试登录
        $credentials = [
            'name' => $request->name,
            'password' => $request->password,
        ];

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // 登录成功，重定向到仪表盘
            return redirect()->intended(route('admin.dashboard'));
        }

        // 登录失败
        return back()->withErrors([
            'name' => '用户名或密码错误',
        ])->withInput($request->except('password'));
    }

    /**
     * 处理退出登录
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}
