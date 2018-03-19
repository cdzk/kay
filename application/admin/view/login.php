<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>管理系统</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">

    <link rel="stylesheet" href="{$Think.config.path.static}bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{$Think.config.path.static}adminLTE/css/AdminLTE.css">
    <link rel="stylesheet" href="{$Think.config.path.static}adminLTE/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="{$Think.config.path.static}adminLTE/css/admin.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        body {
            height: auto;
        }
        input.form-control {padding-left: 2.6em;}
        input.form-control:focus {
            border: solid 1px #999;
            background-color: #fff5cd;
        }
        .login-box-body .form-control-feedback{color: #999;}
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <!--<div class="login-logo">管理系统</div>-->
    <!-- /.login-logo -->

    <div class="login-box-body">
        <p class="login-box-msg">管理员登录</p>

        <form id="formSubmit" action="{:url('admin/Login/action')}" method="post">
            <input type="hidden" name="__hash__" value="{$Request.token.__hash__}">
            <div class="form-group has-feedback">
                <span class="fa fa-user form-control-feedback" style="left: 0;"></span>
                <input type="text" class="form-control" id="user_name" name="user_name"
                       datatype="*"
                       nullmsg="请输入用户名"
                       placeholder="用户名">
                <div class="Validform_checktip"></div>
            </div>
            <div class="form-group has-feedback">
                <span class="fa fa-lock form-control-feedback" style="left: 0;"></span>
                <input type="password" class="form-control" id="user_password" name="user_password"
                       datatype="*"
                       nullmsg="请输入密码"
                       placeholder="密码">
                <div class="Validform_checktip"></div>
            </div>
            <div class="form-group has-feedback">
                <span class="fa fa-shield form-control-feedback" style="left: 0;"></span>
                <input type="text" class="form-control" id="verify_code" name="verify_code"
                       datatype="*"
                       nullmsg="请输入验证码"
                       placeholder="验证码"
                       style="display: inline-block;padding-left: 2em;width: 196px;vertical-align: middle;">
                <img id="verifyCodeImg" src="{:url('admin/Publics/verify_code', ['width'=>120, 'height'=>34, 'r'=>time()])}"
                     title="点击刷新"
                     style="border: none;cursor: pointer;">
                <div class="Validform_checktip"></div>
            </div>

            <div class="row" style="border-top: solid 1px #eee;">
                <div class="text-center" style="padding-top:20px;">
                    <button type="submit" class="btn btn-flat bg-olive">登&emsp;&emsp;录</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
    <div class="text-center" style="padding: 8px 0;">{$Think.config.system.copy}</div>
</div>
<!-- /.login-box -->
</body>
</html>
<!-- requireJs 2.3.5 -->
<script src="{$Think.config.path.static}js/require.js"></script>
<script>
    require(['{$Think.config.path.static}js/require.config.js'], function () {
        require(
            [
                'jquery',
                'bootstrap',
                'layer',
                'validform',
                'admin'
            ],
            function ($) {
                layer.config({
                    path: '/static/common/plugins/layer/'
                });
                $(function () {
                    admin.initValidator(function () {
                        admin.verifyCode($('#verifyCodeImg'));
                    });
                });
            }
        );
    });
</script>