<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{$Think.ADMIN_TITLE}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">

    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{$Think.PATH_STATIC}bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">

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
<body class="hold-transition {$Think.ADMIN_SKIN} fixed sidebar-collapse" >
<div class="wrapper">
    {include file="public/header" /}
    {include file="public/side_left" /}

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <iframe src="{:url('admin/Index/main')}" id="main" name="main" width="100%" height="100%" scrolling="auto" frameborder="0" style="margin: 0;padding: 0;background-color: transparent;margin-bottom:-5px;"></iframe>
    </div>
    <!-- /.content-wrapper -->

    {include file="public/footer" /}
</div>
<!-- ./wrapper -->
</body>
</html>
<!-- jQuery 2.2.3 -->
<script src="{$Think.PATH_COMMON_STATIC}plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{$Think.PATH_STATIC}bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="{$Think.PATH_STATIC}dist/js/app.js"></script>
<script src="{$Think.PATH_STATIC}dist/js/yc_app.js"></script>
<script>
    $(function () {
        syApp.setMainHeight();
        syApp.iframeHeight();
    });

    // 根据窗口大小调整 main区域的高度
    $(window).resize(function() {
        syApp.setMainHeight();
        syApp.iframeHeight();
    });
</script>
