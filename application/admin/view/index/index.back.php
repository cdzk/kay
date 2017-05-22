<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{$Think.PATH_STATIC}bootstrap/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="{$Think.PATH_STATIC}dist/css/AdminLTE.min.css">
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
<body class="hold-transition sidebar-mini skin-blue fixed">
<div class="wrapper">
    {include file="public/header" /}
    {include file="public/side_left" /}



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>控制台</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 管理后台</a></li>
        <li class="active">管理首页</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-clock-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">服务器时间</span>
              <span class="info-box-number" id="server-time">--</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-server"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">CPU使用率</span>
              <span class="info-box-number" id="server-cpu">--</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-microchip"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">内存使用情况</span>
              <span class="info-box-number" id="server-ram">--</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-database"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">磁盘使用情况</span>
              <span class="info-box-number" id="server-disk">--</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">
                <!-- TABLE: LATEST ORDERS -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">系统信息</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered no-margin">
                                <tbody>
                                <tr>
                                    <td>软件名称：</td>
                                    <td>{$Think.SOFT_NAME}</td>

                                    <td>软件版本：</td>
                                    <td>{$Think.SOFT_VERSION}</td>

                                    <td>核心版本：</td>
                                    <td>{$Think.THINK_VERSION}</td>

                                    <td>联系电话：</td>
                                    <td>028-85182725</td>
                                </tr>

                                <tr>
                                    <td>服务器操作系统：</td>
                                    <td><?php $os = explode(" ", php_uname()); echo $os[0];?> / <?php if('/'==DIRECTORY_SEPARATOR){echo $os[2];}else{echo $os[1];} ?></td>

                                    <td>脚本解释引擎：</td>
                                    <td><?php echo $_SERVER['SERVER_SOFTWARE'];?></td>

                                    <td>系统语言：</td>
                                    <td><?php echo getenv("HTTP_ACCEPT_LANGUAGE");?></td>

                                    <td>主机名：</td>
                                    <td><?php if('/'==DIRECTORY_SEPARATOR ){echo $os[1];}else{echo $os[2];} ?></td>
                                </tr>

                                <tr>
                                    <td>域名/IP：</td>
                                    <td><?php echo $_SERVER['SERVER_NAME'];?> / <?php echo $_SERVER['SERVER_ADDR'];?></td>

                                    <td>端口：</td>
                                    <td><?php echo $_SERVER['SERVER_PORT'];?></td>

                                    <td>脚本超时：</td>
                                    <td><?php echo get_cfg_var('max_execution_time')?> 秒</td>

                                    <td>上传文件最大限制：</td>
                                    <td><?php echo get_cfg_var('upload_max_filesize')?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    {include file="public/footer" /}

</div>
<!-- ./wrapper -->
</body>
</html>
<!-- jQuery 2.2.3 -->
<script src="{$Think.PATH_STATIC}plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{$Think.PATH_STATIC}bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="{$Think.PATH_STATIC}dist/js/app.js"></script>
<script src="{$Think.PATH_STATIC}dist/js/yc_app.js"></script>
<script>
    // 每隔60秒获取一次服务器系统信息
    setInterval("ycApp.getSysInfo()", 1 * 1000);
</script>