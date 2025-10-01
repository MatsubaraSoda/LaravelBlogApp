<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * 后台管理首页
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
