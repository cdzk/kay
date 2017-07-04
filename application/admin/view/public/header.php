<header class="main-header">

    <!-- Logo -->
    <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="{$Think.PATH_STATIC}dist/img/logo_mini.png"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="{$Think.PATH_STATIC}dist/img/logo_large.png"></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <ul class="nav nav-tabs module_menu" id="header-menu">
            <li role="presentation" {$Request.controller=='Index' ? 'class="active"' : ''} data-id="0"><a href="{:url('admin/Index/index')}">首页</a></li>
            {volist name="menu" id="vo"}
                {if condition="$vo.menu_action"}
                <li role="presentation" {$vo.menu_controller==$Request.controller ? 'class="active"' : ''} data-id="{$vo.menu_id}"><a href="{:url($vo.menu_module.'/'.$vo.menu_controller.'/'.$vo.menu_action.'')}">{$vo.menu_name}</a></li>
                {else /}
                <li role="presentation" {$vo.menu_controller==$Request.controller ? 'class="active"' : ''} data-id="{$vo.menu_id}"><a href="javascript:void(0);" data-toggle="offcanvas" role="button">{$vo.menu_name}</a></li>
                {/if}
            {/volist}
            <!--<li role="presentation" class="active"><a href="{:url('@admin/index');}">首页</a></li>
            <li role="presentation"><a href="#">系统</a></li>
            <li role="presentation"><a href="#">内容</a></li>-->
        </ul>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{$Think.PATH_STATIC}dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                        <span class="hidden-xs">admin</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="height: auto;">
                            <img src="{$Think.PATH_STATIC}dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                            <p>
                                admin
                                <small>用户角色：超级管理员</small>
                                <small>登录时间：<?php echo date('Y-m-d H:i:d' ,time());?></small>
                                <small>登录IP：{$Request.ip}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!--<li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </div>
                        </li>-->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">资料修改</a>
                            </div>
                            <div class="pull-right">
                                <a href="#" class="btn btn-default btn-flat">退出登录</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </nav>
</header>