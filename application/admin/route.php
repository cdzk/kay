<?php
use think\Route;

Route::rule('admin/test', 'admin/Index/test');  // 测试专用

// 管理首页
Route::rule('admin/index', 'admin/Index/index');    // 管理后台首页
Route::rule('admin/home', 'admin/Index/main');      // 管理后台首页

// 管理后台 > 系统 > 菜单管理
Route::rule('admin/menu', 'admin/Menu/index');              // 列表
Route::group('admin/menu',[
    'add/[:parent_id]' => ['admin/Menu/add', [], ['parent_id'=>'\d+']], // 新增菜单 | 带parent_id参数则表示新增子菜单
    'edit/:menu_id' => ['admin/Menu/edit', [], ['menu_id'=>'\d+']],     // 编辑菜单
    'save' => ['admin/Menu/save', ['method' => 'post']],                // 保存菜单数据
    'sort' => ['admin/Menu/sort', ['method' => 'post']],                // 菜单排序
    'del' => ['admin/Menu/del', ['method' => 'get']],                   // 删除菜单
    'status' => ['admin/Menu/status', ['method' => 'post']]             // 设置菜单状态
]);

// 管理后台 > 系统 > 权限管理
Route::rule('admin/auth', 'admin/Auth/index');              // 列表
Route::group('admin/auth',[
    'add/[:parent_id]' => ['admin/Auth/add', [], ['parent_id'=>'\d+']], // 新增权限 | 带parent_id参数则表示新增子菜单
    'edit/:auth_id' => ['admin/Auth/edit', [], ['auth_id'=>'\d+']],     // 编辑权限
    'save' => ['admin/Auth/save', ['method' => 'post']],                // 保存权限数据
    'del' => ['admin/Auth/del', ['method' => 'get']],                   // 删除菜单
]);

// ajax请求
Route::rule('admin/ajax_sys_info', 'admin/Index/sys_info');                     // 获取系统信息
Route::rule('admin/ajax_admin_menu/:menu_parentid', 'admin/Index/admin_menu');  // 获取左侧管理菜单




