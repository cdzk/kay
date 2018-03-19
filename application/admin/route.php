<?php
use think\Route;

Route::rule('admin/test', 'admin/Index/test');  // 测试专用

// 管理后台入口
Route::rule('admin/login', 'admin/Login/index');        // 管理员登录
Route::rule('admin/logout', 'admin/Publics/logout');    // 管理员退出登录

// 管理首页
Route::rule('admin/index', 'admin/Index/index');    // 管理后台首页

// 管理后台 > 系统 > 菜单管理
/*Route::rule('admin/menu/list', 'admin/sys.Menu/index');          // 列表
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
    'add/[:parent_id]' => ['admin/Auth/add', [], ['parent_id'=>'\d+']], // 新增权限 | 带parent_id参数则表示新增子权限
    'edit/:auth_id' => ['admin/Auth/edit', [], ['auth_id'=>'\d+']],     // 编辑权限
    'save' => ['admin/Auth/save', ['method' => 'post']],                // 保存权限数据
    'del' => ['admin/Auth/del', ['method' => 'get']],                   // 删除权限
]);

// 管理后台 > 系统 > 系统用户 > 用户管理
Route::rule('admin/user', 'admin/User/index');              // 列表
Route::group('admin/user',[
    'add' => ['admin/User/add'],                                        // 新增用户
    'edit/:user_id' => ['admin/User/edit', [], ['user_id'=>'\d+']],     // 编辑用户
    'repeat' => ['admin/User/repeat', ['method' => 'post']],            // 用户重复检测
    'save' => ['admin/User/save', ['method' => 'post']],                // 保存用户数据
    'del' => ['admin/User/del', ['method' => 'get']],                   // 删除用户
    'status' => ['admin/User/status', ['method' => 'post']]             // 设置用户状态
]);

// 管理后台 > 系统 > 系统用户 > 角色管理
Route::rule('admin/role', 'admin/Role/index');                  // 列表
Route::group('admin/role',[
    'add' => ['admin/Role/add'],                                            // 新增角色
    'edit/:role_id' => ['admin/Role/edit', [], ['role_id'=>'\d+']],         // 编辑角色
    'save' => ['admin/Role/save', ['method' => 'post']],                    // 保存角色数据
    'del' => ['admin/Role/del', ['method' => 'get']],                       // 删除角色
    'status' => ['admin/Role/status', ['method' => 'post']],                // 设置角色状态
    'auth_menu/[:type]' => ['admin/Role/auth_menu', ['method' => 'post']],  // 设置角色菜单权限
    'auth/[:type]' => ['admin/Role/auth', ['method' => 'post']],            // 设置角色管理权限
]);*/