<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>菜单管理</title>
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
<body class="hold-transition {$Think.ADMIN_SKIN}">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin: 0;">
    <!-- Content Header (Page header) -->
    <section class="content-header clearfix">
      <h5>菜单管理</h5>
      <ol class="breadcrumb">
        <li><i class="fa fa-home"></i> 管理中心</a></li>
        <li>系统</a></li>
        <li class="active">菜单管理</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <ul class="nav nav-pills child_page_menu">
                            <li role="presentation" {$Request.action==='index' ? 'class="active"' : ''}><a href="{$Request.action==='index' ? 'javascript:void(0);' : url('admin/Menu/index')}">菜单管理</a></li>
                            <li role="presentation" {$Request.action==='add' ? 'class="active"' : ''}><a href="{$Request.action==='add' ? 'javascript:void(0);' : url('admin/Menu/add')}">添加菜单</a></li>
                        </ul>
                    </div>

                    <form action="{:url('admin/Menu/sort');}">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-condensed table-bordered table-hover">
                                    <thead class="table_head">
                                    <tr>
                                        <th class="text-center" style="width: 60px;">排序</th>
                                        <th class="text-center" style="width: 60px;">菜单ID</th>
                                        <th class="text-center">菜单名称</th>
                                        <th class="text-center" style="width: 100px;">状态</th>
                                        <th class="text-center" style="width: 200px;">操作</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    {volist name="menu_list" id="vo"}
                                    <tr>
                                        <td class="text-center"><input class="form-control input_text" id="menu_sort_{$vo.menu_id}" name="menu_sort[{$vo.menu_id}]" type="text" value="{$vo.menu_sort}"
                                                                       onkeyup="this.value=this.value.replace(/\D/g,'')"
                                                                       onafterpaste="this.value=this.value.replace(/\D/g,'')"
                                                                       style="width: 42px;text-align: center;"></td>
                                        <td class="text-center">{$vo.menu_id}</td>

                                        {if condition="$vo['level'] eq 0"}
                                        <td style="font-weight: bold;">{$vo.menu_name}</td>
                                        {else/}
                                        <td>├{:str_repeat('─',$vo.level)} {$vo.menu_name}</td>
                                        {/if}

                                        <td class="text-center">{switch name="vo.menu_status"}
                                            {case value="1"}<a class="btn btn-success" href="javascript:void(0);" role="button" onclick="setStatus({$vo.menu_id}, 0);">显示</a>{/case}
                                            {case value="0"}<a class="btn btn-default" href="javascript:void(0);" role="button" onclick="setStatus({$vo.menu_id}, 1);">隐藏</a>{/case}
                                            {/switch}</td>

                                        <td class="text-center">
                                            <a class="btn btn-primary" href="{:url('admin/Menu/add', ['parent_id'=>$vo.menu_id])}" role="button">添加子菜单</a>
                                            <a class="btn btn-primary" href="{:url('admin/Menu/edit', ['menu_id'=>$vo.menu_id])}" role="button">修改</a>
                                            <a class="btn btn-primary" href="javascript:void(0);"
                                               onclick="ycApp.ajaxDel('{:url('admin/Menu/del')}', 'menu_id={$vo.menu_id}')"
                                               role="button">删除</a>
                                        </td>
                                    </tr>
                                    {/volist}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-info">排序</button>
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

<!-- jQuery Form 4.2.1 -->
<script src="{$Think.PATH_COMMON_STATIC}plugins/jQueryForm/jquery.form.min.js"></script>

<!-- AdminLTE App -->
<script src="{$Think.PATH_STATIC}dist/js/yc_app.js"></script>
<script>
    $(function () {
        ycApp.ajaxFormSubmit($('form'));
    });

    /**
     * 设置菜单状态
     * @param menu_id 菜单id
     * @param menu_status 状态码
     */
    function setStatus(menu_id, menu_status) {
        var _this = event.toElement,
            $this = $(_this),
            str='';
        var status = function () {
            switch (menu_status) {
                case 0:
                    str = '<a class="btn btn-default" href="javascript:void(0);" role="button" onclick="setStatus('+ menu_id +', 1);">隐藏</a>';
                    break;
                case 1:
                    str = '<a class="btn btn-success" href="javascript:void(0);" role="button" onclick="setStatus('+ menu_id +', 0);">显示</a>';
                    break;
            }
            $this.parent().html(str);
        };

        var waitLoad; // 等待动画调用变量
        ycApp.aReq('post', '{:url('admin/Menu/status')}', {menu_id:menu_id, menu_status:menu_status}, 'json',
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