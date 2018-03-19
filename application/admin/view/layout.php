<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>管理后台</title>
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
</head>
<body class="hold-transition {$Think.config.system.admin_skin} fixed" >
<div class="wrapper">
    {include file="public/header" /}
    {include file="public/side_left" /}

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {__CONTENT__}
    </div>
    <!-- /.content-wrapper -->

    {include file="public/footer" /}
</div>
<!-- ./wrapper -->
</body>
</html>
