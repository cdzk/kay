<?php
use think\Route;

Route::rule('admin/test', 'admin/Index/test');  // 测试专用

// 管理后台入口
Route::rule('admin/login', 'admin/Login/index');        // 管理员登录
Route::rule('admin/logout', 'admin/Publics/logout');    // 管理员退出登录

// 管理首页
Route::rule('admin/index', 'admin/Index/index');    // 管理后台首页