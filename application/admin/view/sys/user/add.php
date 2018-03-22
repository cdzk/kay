<!-- Content Header (Page header) -->
<section class="content-header clearfix">
    <h5>系统用户</h5>
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i> <a href="{:url('admin/Index/index')}">管理首页</a></li>
        <li>系统管理</li>
        <li><a href="{:url('admin/sys.User/index')}">系统用户</a></li>
        <li class="active">添加用户</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <ul class="nav nav-pills child_page_menu">
                        <li role="presentation" {$Request.action==='index' ? 'class="active"' : ''}><a href="{$Request.action==='index' ? 'javascript:void(0);' : url('admin/sys.User/index')}">用户列表</a></li>
                        <li role="presentation" {$Request.action==='add' ? 'class="active"' : ''}><a href="{$Request.action==='add' ? 'javascript:void(0);' : url('admin/sys.User/add')}">添加用户</a></li>
                    </ul>
                </div>
                <!-- {:url('admin/Menu/add_save')} -->
                <form id="formSubmit" action="{:url('admin/sys.User/add')}" method="post">
                    <input type="hidden" name="__hash__" value="{$Request.token.__hash__}">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="user_name">用户名</label>
                            <input type="text" class="form-control" id="user_name" name="user_name"
                                   ajaxurl="{:url('admin/sys.User/repeat')}"
                                   datatype="scope_string_3"
                                   nullmsg="用户名不能为空"
                                   errormsg="用户名只允许使用英文字母与数字"
                                   placeholder="用户名">
                            <div class="Validform_checktip">用户名只允许使用英文字母与数字</div>
                        </div>
                        <div class="form-group">
                            <label for="user_roleid">用户角色</label>
                            <select class="form-control select2" id="user_roleid" name="user_roleid"
                                    datatype="*"
                                    nullmsg="请选择用户角色"
                                    errormsg="请选择用户角色"
                                    style="width: 100%;">
                                <option value="">请选择</option>
                                {volist name="role_list" id="vo"}
                                <option value="{$vo.role_id}">{$vo.role_name}</option>
                                {/volist}
                            </select>
                            <div class="Validform_checktip"></div>
                        </div>
                        <div class="form-group">
                            <label for="user_password">登录密码</label>
                            <input type="password" class="form-control" id="user_password" name="user_password"
                                   datatype="scope_string_2,*6-20"
                                   nullmsg="登录密码不能为空"
                                   errormsg="登录密码必须包含英文字母与数字，长度在6~20位之间"
                                   placeholder="登录密码">
                            <div class="Validform_checktip">登录密码必须包含英文字母与数字，长度在6~20位之间</div>
                        </div>
                        <div class="form-group">
                            <label for="user_password_confirm">确认密码</label>
                            <input type="password" class="form-control" id="user_password_confirm" name="user_password_confirm"
                                   datatype="*"
                                   recheck="user_password"
                                   nullmsg="请再次输入登录密码"
                                   errormsg="两次输入密码不一致"
                                   placeholder="确认密码">
                            <div class="Validform_checktip"></div>
                        </div>
                        <div class="form-group">
                            <label for="user_realname">真实姓名</label>
                            <input type="text" class="form-control" id="user_realname" name="user_realname"
                                   datatype="yes_null|check_name"
                                   nullmsg="真实姓名不能为空"
                                   errormsg="姓名格式不正确。中文字符之间不允许有空格，英文字符之间只能有一个空格"
                                   placeholder="真实姓名">
                            <div class="Validform_checktip"></div>
                        </div>
                        <div class="form-group">
                            <label for="user_mobile">手机号</label>
                            <input type="text" class="form-control" id="user_mobile" name="user_mobile"
                                   datatype="yes_null|check_mobile"
                                   nullmsg="手机号码不能为空"
                                   errormsg="手机号码格式不正确"
                                   placeholder="手机号码">
                            <div class="Validform_checktip"></div>
                        </div>
                        <div class="form-group">
                            <label for="user_email">邮箱</label>
                            <input type="text" class="form-control" id="user_email" name="user_email"
                                   datatype="yes_null|e"
                                   nullmsg="邮箱不能为空"
                                   errormsg="邮箱格式不正确"
                                   placeholder="邮箱">
                            <div class="Validform_checktip"></div>
                        </div>
                        <div class="form-group">
                            <label for="user_status">状态</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" class="minimal" id="user_status_1" name="user_status" value="1" checked>
                                    正常
                                </label>
                                <label>
                                    <input type="radio" class="minimal" id="user_status_2" name="user_status" value="0">
                                    锁定
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer text-center">
                        <button type="submit" class="btn btn-info" style="width: 80px;height: 28px">保&emsp;存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->

<!-- requireJs 2.3.5 -->
<script src="{$Think.config.path.static}js/require.js"></script>
<script>
    require(['{$Think.config.path.static}js/require.config.js'], function () {
        require(
            [
                'jquery',
                'bootstrap',
                'layer',
                'slimscroll',
                'adminLTE',
                'admin',

                'select2',
                'icheck',
                'validform',
            ],
            function ($) {
                layer.config({
                    path: '/static/common/plugins/layer/'
                });

                $(function () {
                    // 根据窗口大小调整 main区域的高度
                    admin.setMainHeight();
                    $(window).resize(function() {
                        admin.setMainHeight();
                    });

                    // 左侧菜单滚动条
                    var $h = $(window).height()-($('.main-footer').height()+parseInt($('.content-wrapper').css('paddingTop'))+30);
                    $(".sidebar-menu").slimScroll({
                        height: $h+'px'
                    });

                    $(".select2").select2();

                    //iCheck for checkbox and radio inputs
                    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                        checkboxClass: 'icheckbox_minimal-blue',
                        radioClass: 'iradio_minimal-blue'
                    });

                    admin.initValidator();
                });
            }
        );
    });
</script>