<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Admin Routes (后台管理)
|--------------------------------------------------------------------------
*/

// 后台管理路由组 - 需要认证
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // 仪表盘
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // 文章管理路由 - 仅限admin和editor
    Route::prefix('posts')->name('posts.')->middleware(['role:admin,editor'])->group(function () {
        Route::get('/list', [PostController::class, 'index'])->name('index');
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{post}', [PostController::class, 'show'])->name('show');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{post}', [PostController::class, 'update'])->name('update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
        Route::patch('/{post}/publish', [PostController::class, 'publish'])->name('publish');
        Route::patch('/{post}/unpublish', [PostController::class, 'unpublish'])->name('unpublish');
    });

    // 用户管理路由 - 仅限admin
    Route::prefix('users')->name('users.')->middleware(['role:admin'])->group(function () {
        Route::get('/list', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});

// 后台根路由 - 重定向到登录或仪表盘
Route::get('/admin', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
})->name('admin.index');