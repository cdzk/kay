<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>系统用户 > 用户管理 > 添加用户</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">

    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{$Think.PATH_STATIC}bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="{$Think.PATH_STATIC}plugins/select2/select2.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{$Think.PATH_STATIC}plugins/icheck-1.0.2/skins/all.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{$Think.PATH_STATIC}dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{$Think.PATH_STATIC}dist/css/skins/_all-skins.min.css">

    <!-- yc style -->
    <link rel="stylesheet" href="{$Think.PATH_STATIC}dist/css/yc_style.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition {$Think.ADMIN_SKIN}">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin: 0;">
    <!-- Content Header (Page header) -->
      <section class="content-header clearfix">
          <h5>用户管理</h5>
          <ol class="breadcrumb">
              <li><i class="fa fa-home"></i> 管理中心</li>
              <li>系统</li>
              <li>系统用户</li>
              <li class="active">用户管理</li>
          </ol>
      </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <ul class="nav nav-pills child_page_menu">
                            <li role="presentation" {$Request.action==='index' ? 'class="active"' : ''}><a href="{$Request.action==='index' ? 'javascript:void(0);' : url('admin/User/index')}">用户管理</a></li>
                            <li role="presentation" {$Request.action==='add' ? 'class="active"' : ''}><a href="{$Request.action==='add' ? 'javascript:void(0);' : url('admin/User/add')}">添加用户</a></li>
                        </ul>
                    </div>
                    <!-- {:url('admin/Menu/add_save')} -->
                    <form id="formSubmit" action="{:url('admin/User/save')}" method="post">
                        <input type="hidden" name="__hash__" value="{$Request.token.__hash__}">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="user_name">用户名</label>
                                <input type="text" class="form-control" id="user_name" name="user_name"
                                       ajaxurl="{:url('admin/User/repeat')}"
                                       datatype="scope_string_3"
                                       nullmsg="用户名不能为空"
                                       errormsg="用户名只允许使用英文字母与数字"
                                       placeholder="用户名">
                                <div class="Validform_checktip">用户名只允许使用英文字母与数字</div>
                            </div>
                            <div class="form-group">
                                <label for="menu_parentid">角色分组</label>
                                <select class="form-control select2" id="user_roleid" name="user_roleid"
                                        <!--datatype="*"
                                        nullmsg="请选择角色分组"
                                        errormsg="请选择角色分组"-->
                                        style="width: 100%;">
                                    <option value="">请选择</option>
                                </select>
                                <!--<div class="Validform_checktip"></div>-->
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
                                       nullmsg="请填写真实姓名"
                                       errormsg="姓名格式不正确。中文字符之间不允许有空格，英文字符之间只能有一个空格"
                                       placeholder="真实姓名">
                                <div class="Validform_checktip"></div>
                            </div>
                            <div class="form-group">
                                <label for="user_email">邮箱</label>
                                <input type="text" class="form-control" id="user_email" name="user_email"
                                       datatype="yes_null|e"
                                       nullmsg="请填邮箱"
                                       errormsg="邮箱格式不正确"
                                       placeholder="邮箱">
                                <div class="Validform_checktip"></div>
                            </div>
                            <div class="form-group">
                                <label for="user_mobile">手机</label>
                                <input type="text" class="form-control" id="user_mobile" name="user_mobile"
                                       datatype="yes_null|check_mobile"
                                       nullmsg="请填手机号码"
                                       errormsg="手机号码格式不正确"
                                       placeholder="手机号码">
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

                        <div class="box-footer">
                            <button type="reset" class="btn btn-info">重置</button>
                            <button type="submit" class="btn btn-info pull-right">保存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
</body>
</html>
<!-- jQuery 2.2.3 -->
<script src="{$Think.PATH_COMMON_STATIC}plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{$Think.PATH_STATIC}bootstrap/js/bootstrap.min.js"></script>
<!-- layer 3.0.3 -->
<script src="{$Think.PATH_COMMON_STATIC}plugins/layer/layer.js"></script>

<!-- Select2 -->
<script src="{$Think.PATH_STATIC}plugins/select2/select2.full.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="{$Think.PATH_STATIC}plugins/icheck-1.0.2/icheck.min.js"></script>
<!-- Validform 5.3.2 -->
<script src="{$Think.PATH_COMMON_STATIC}plugins/Validform/Validform_v5.3.2.js"></script>
<!-- jquery-form 4.2.1 -->
<script src="{$Think.PATH_COMMON_STATIC}plugins/jQueryForm/jquery.form.min.js"></script>

<!-- AdminLTE App -->
<script src="{$Think.PATH_STATIC}dist/js/yc_app.js"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });

        ycApp.initValidator();
    });
</script>
