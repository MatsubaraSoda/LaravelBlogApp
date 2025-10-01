<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

/*
|--------------------------------------------------------------------------
| Web Routes (Clean Blog)
|--------------------------------------------------------------------------
*/

// 首页 - 根目录指向 index
Route::get('/', [WebController::class, 'index'])->name('web.index');

// 关于页面
Route::get('/about', [WebController::class, 'about'])->name('web.about');

// 文章详情页面
Route::get('/post/{slug}', [WebController::class, 'post'])->name('web.post')->where('slug', '.*');

// 包含认证路由
require __DIR__.'/auth.php';

// 包含后台路由
require __DIR__.'/admin.php';
