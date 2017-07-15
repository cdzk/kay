<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>权限管理</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">

    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{$Think.PATH_STATIC}bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="//cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- jquery-treegrid style -->
    <link rel="stylesheet" href="{$Think.PATH_STATIC}plugins/jquery-treegrid/css/jquery.treegrid.css">

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
          <h5>权限管理</h5>
          <ol class="breadcrumb">
              <li><i class="fa fa-home"></i> 管理中心</li>
              <li>系统</li>
              <li class="active">权限管理</li>
          </ol>
      </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <ul class="nav nav-pills child_page_menu">
                            <li role="presentation" {$Request.action==='index' ? 'class="active"' : ''}><a href="{$Request.action==='index' ? 'javascript:void(0);' : url('admin/Auth/index')}">权限管理</a></li>
                            <li role="presentation" {$Request.action==='add' ? 'class="active"' : ''}><a href="{$Request.action==='add' ? 'javascript:void(0);' : url('admin/Auth/add')}">添加权限</a></li>
                        </ul>
                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered table-hover tree">
                                <thead class="table_head">
                                <tr>
                                    <th class="text-center" style="width: 60px;">ID</th>
                                    <th class="text-center">权限名称</th>
                                    <th class="text-center">模块</th>
                                    <th class="text-center">控制器</th>
                                    <th class="text-center">方法</th>
                                    <th class="text-center" style="width: 200px;">操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                {volist name="auth_list" id="vo"}
                                <tr class="treegrid-{$vo.auth_id} {$vo.level ?= ' treegrid-parent-'.$vo.auth_parentid}">
                                    <td class="text-center">{$vo.auth_id}</td>

                                    {if condition="$vo['level'] eq 0"}
                                        <td style="font-weight: bold;">{$vo.auth_name}</td>
                                    {else/}
                                        <td>├{:str_repeat('─',$vo.level)} {$vo.auth_name}</td>
                                    {/if}

                                    <td class="text-center">{$vo.auth_module}</td>
                                    <td class="text-center">{$vo.auth_controller}</td>
                                    <td class="text-center">{$vo.auth_action}</td>
                                    <td class="text-center">
                                        <a class="btn btn-primary" href="{:url('admin/Auth/add', ['parent_id'=>$vo.auth_id])}" role="button">添加子权限</a>
                                        <a class="btn btn-primary" href="{:url('admin/Auth/edit', ['auth_id'=>$vo.auth_id])}" role="button">修改</a>
                                        <a class="btn btn-primary" href="javascript:void(0);"
                                           onclick="syApp.ajaxDel('{:url('admin/Auth/del')}', 'auth_id={$vo.auth_id}')"
                                           role="button">删除</a>
                                    </td>
                                </tr>
                                {/volist}
                                </tbody>
                            </table>
                        </div>
                    </div>
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

<!-- jquery-treegrid 0.3.0 -->
<script src="{$Think.PATH_STATIC}plugins/jquery-treegrid/js/jquery.treegrid.js"></script>
<script src="{$Think.PATH_STATIC}plugins/jquery-treegrid/js/jquery.treegrid.bootstrap3.js"></script>

<!-- AdminLTE App -->
<script src="{$Think.PATH_STATIC}dist/js/yc_app.js"></script>
<script>
    $(function () {
        syApp.treeTable(2);
    });
</script>