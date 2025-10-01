<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| 认证路由
|--------------------------------------------------------------------------
|
| 这些路由处理用户认证相关的请求
|
*/

// 访客路由（已登录用户会被重定向）
Route::middleware(['guest'])->group(function () {
    // 显示登录表单
    Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    
    // 处理登录请求
    Route::post('/admin/login', [AuthController::class, 'login']);
});

// 认证用户路由
Route::middleware(['auth'])->group(function () {
    // 处理退出登录
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
});
