<header class="main-header">

    <!-- Logo -->
    <a href="javascript:void(0);" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="{$Think.config.path.static}adminLTE/img/logo_mini.png"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="{$Think.config.path.static}adminLTE/img/logo_large.png"></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="javascript:void(0);" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{$avatar}" class="user-image" alt="User Image">
                        <span class="hidden-xs">ss</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="height: auto;">
                            <img src="{$avatar}" class="img-circle" alt="User Image">

                            <p>
                                <small>用户角色：ss</small>
                                <small>登录时间：ss</small>
                                <small>登录IP：ss</small>
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
                                <a href="#" class="btn btn-default btn-flat">密码修改</a>
                            </div>
                            <div class="pull-right">
                                <a href="{:url('admin/Publics/logout')}" class="btn btn-default btn-flat">退出登录</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </nav>
</header>