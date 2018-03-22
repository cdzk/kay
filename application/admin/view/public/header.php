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
                        <span class="hidden-xs">{$curr_user.user_name}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="height: auto;">
                            <img src="{$avatar}" class="img-circle" alt="User Image">

                            <p class="text-center">
                                <!--<small>用户名：</small>-->
                                <small>{$curr_user.role_name}</small>
                                <small>{$curr_user.user_name}</small>
                                <!--<small>登录时间：ss</small>
                                <small>登录  IP：ss</small>-->
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
                                <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#userSafeModal">密码修改</a>
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

<!--账号安全 模态框-->
<div class="modal fade" id="userSafeModal" tabindex="-1" role="dialog" aria-labelledby="userSafeModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <a href="javascript:void(0);" class="close" data-dismiss="modal" aria-label="Close" role="button"><span aria-hidden="true">&times;</span></a>
                <h4 class="modal-title" id="userSafeModalLabel">账号安全</h4>
            </div>
            <form class="form-horizontal" name="user_safe" id="user_safe" method="post" action="{:url('admin/sys.User/account_safe')}">
                <input type="hidden" name="__hash__" value="{$Request.token.__hash__}">
                <input type="hidden" name="user_id" value="{$curr_user.user_id}">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户名</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{$curr_user.user_name}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">角色</label>
                        <div class="col-sm-10">
                            <p class="form-control-static">{$curr_user.role_name}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_password" class="col-sm-2 control-label">新密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="user_password" name="user_password"
                                   datatype="scope_string_2,*6-20"
                                   nullmsg="登录密码不能为空"
                                   errormsg="登录密码必须包含英文字母与数字，长度在6~20位之间"
                                   placeholder="新密码">
                            <div class="Validform_checktip"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_password_confirm" class="col-sm-2 control-label">确认密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="user_password_confirm" name="user_password_confirm"
                                   datatype="scope_string_2,*6-20"
                                   recheck="user_password"
                                   nullmsg="请再次输入登录密码"
                                   errormsg="两次输入密码不一致"
                                   placeholder="确认密码">
                            <div class="Validform_checktip"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-default pull-left" role="button" data-dismiss="modal">取&emsp;消</a>
                    <button type="submit" class="btn btn-primary" onclick="formSubmit();">确&emsp;认</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--账号安全 模态框 /-->