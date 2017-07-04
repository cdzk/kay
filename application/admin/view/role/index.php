<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>系统用户 > 角色管理</title>
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
          <h5>角色管理</h5>
          <ol class="breadcrumb">
              <li><i class="fa fa-home"></i> 管理中心</li>
              <li>系统</li>
              <li>系统用户</li>
              <li class="active">角色管理</li>
          </ol>
      </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <ul class="nav nav-pills child_page_menu">
                            <li role="presentation" {$Request.action==='index' ? 'class="active"' : ''}><a href="{$Request.action==='index' ? 'javascript:void(0);' : url('admin/Role/index')}">角色管理</a></li>
                            <li role="presentation" {$Request.action==='add' ? 'class="active"' : ''}><a href="{$Request.action==='add' ? 'javascript:void(0);' : url('admin/Role/add')}">添加角色</a></li>
                        </ul>
                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered table-hover">
                                <thead class="table_head">
                                <tr>
                                    <th class="text-center" style="width: 60px;">ID</th>
                                    <th class="text-center">角色名称</th>
                                    <th class="text-center">描述</th>
                                    <th class="text-center" style="width: 100px;">状态</th>
                                    <th class="text-center" style="width: 320px;">操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                {volist name="role_list" id="vo"}
                                <tr>
                                    <td class="text-center">{$vo.role_id}</td>
                                    <td class="text-center">{$vo.role_name}</td>
                                    <td class="text-left">{$vo.role_remake}</td>
                                    <td class="text-center">{switch name="vo.role_status"}
                                        {case value="1"}<a class="btn btn-success" href="javascript:void(0);" role="button" onclick="setStatus({$vo.role_id}, 0);">启用</a>{/case}
                                        {case value="0"}<a class="btn btn-default" href="javascript:void(0);" role="button" onclick="setStatus({$vo.role_id}, 1);">禁用</a>{/case}
                                        {/switch}</td>
                                    <td class="text-center">
                                        <a class="btn btn-primary {$vo.role_id===1 ? 'disabled' : ''}" href="javascript:void(0);" role="button">菜单权限</a>
                                        <a class="btn btn-primary {$vo.role_id===1 ? 'disabled' : ''}" href="javascript:void(0);" role="button">管理权限</a>
                                        <a class="btn btn-primary" href="javascript:void(0);" role="button">成员管理</a>
                                        <a class="btn btn-primary {$vo.role_id===1 ? 'disabled' : ''}" href="{$vo.role_id===1 ? '' : url('admin/Role/edit', ['role_id'=>$vo.role_id])}" role="button">修改</a>
                                        <a class="btn btn-primary {$vo.role_id===1 ? 'disabled' : ''}" href="javascript:void(0);"
                                           {$vo.role_id===1 ? '' : 'onclick="ycApp.ajaxDel(\\''.url('admin/Role/del').'\\', \\'role_id='.$vo.role_id.'\\');"'}
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
        ycApp.treeTable(2);
    });

    /**
     * 设置角色状态
     * @param role_id 用户id
     * @param role_status 状态码
     */
    function setStatus(role_id, role_status) {
        var _this = event.toElement,
            $this = $(_this),
            str='';
        var status = function () {
            switch (role_status) {
                case 0:
                    str = '<a class="btn btn-default" href="javascript:void(0);" role="button" onclick="setStatus('+ role_id +', 1);">禁用</a>';
                    break;
                case 1:
                    str = '<a class="btn btn-success" href="javascript:void(0);" role="button" onclick="setStatus('+ role_id +', 0);">启用</a>';
                    break;
            }
            $this.parent().html(str);
        };

        var waitLoad; // 等待动画调用变量
        ycApp.aReq('post', '{:url('admin/Role/status')}', {role_id:role_id, role_status:role_status}, 'json',
            function () {
                waitLoad = layer.load(1, {
                    shade: [0.5,'#000']
                });
            },
            function (d) {
                layer.close(waitLoad);
                layer.msg(d['msg']);
                if (d['status']) status();
            });
    }
</script>