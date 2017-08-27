<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>首页</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">

    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{$Think.PATH_ADMIN_STATIC}bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{$Think.PATH_ADMIN_STATIC}dist/css/AdminLTE.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{$Think.PATH_ADMIN_STATIC}dist/css/skins/_all-skins.min.css">

    <!-- yc style -->
    <link rel="stylesheet" href="{$Think.PATH_ADMIN_STATIC}dist/css/admin.css">

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
            <div class="col-md-6">
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
                                    <td>服务器操作系统：</td>
                                    <td><?php $os = explode(" ", php_uname()); echo $os[0];?> / <?php if('/'==DIRECTORY_SEPARATOR){echo $os[2];}else{echo $os[1];} ?></td>
                                </tr>

                                <tr>
                                    <td>脚本解释引擎：</td>
                                    <td><?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
                                </tr>

                                <tr>
                                    <td>系统语言：</td>
                                    <td><?php echo getenv("HTTP_ACCEPT_LANGUAGE");?></td>
                                </tr>

                                <tr>
                                    <td>主机名：</td>
                                    <td><?php if('/'==DIRECTORY_SEPARATOR ){echo $os[1];}else{echo $os[2];} ?></td>
                                </tr>

                                <tr>
                                    <td>域名/IP：</td>
                                    <td><?php echo $_SERVER['SERVER_NAME'];?> / <?php echo $_SERVER['SERVER_ADDR'];?></td>
                                </tr>

                                <tr>
                                    <td>端口：</td>
                                    <td><?php echo $_SERVER['SERVER_PORT'];?></td>
                                </tr>

                                <tr>
                                    <td>脚本超时：</td>
                                    <td><?php echo get_cfg_var('max_execution_time')?> 秒</td>
                                </tr>

                                <tr>
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


            <div class="col-md-6">
                <!-- TABLE: LATEST ORDERS -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">软件信息</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered no-margin">
                                <tbody>
                                <tr>
                                    <td>软件名称：</td>
                                    <td>{$Think.SOFT_NAME}</td>
                                </tr>

                                <tr>
                                    <td>软件版本：</td>
                                    <td>{$Think.SOFT_VERSION}</td>
                                </tr>

                                <tr>
                                    <td>核心版本：</td>
                                    <td>{$Think.THINK_VERSION}</td>
                                </tr>

                                <tr>
                                    <td>开发商：</td>
                                    <td>思议创想</td>
                                </tr>

                                <tr>
                                    <td>官方网站：</td>
                                    <td>www.siyi360.com</td>
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

</div>
<!-- ./wrapper -->
</body>
</html>
<!-- jQuery 2.2.3 -->
<script src="{$Think.PATH_COMMON_STATIC}plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{$Think.PATH_ADMIN_STATIC}bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="{$Think.PATH_ADMIN_STATIC}dist/js/admin.js"></script>
<script>
    // 每隔60秒获取一次服务器系统信息
    // setInterval("admin.getSysInfo()", 1 * 1000);
    $(function () {
        admin.getSysInfo();
    });
</script>
