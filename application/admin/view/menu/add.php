<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>添加菜单</title>
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
      <h5>菜单管理</h5>
      <ol class="breadcrumb">
        <li><i class="fa fa-home"></i> 管理中心</li>
        <li>系统</li>
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
                    <!-- {:url('admin/Menu/add_save')} -->
                    <form id="formSubmit" action="{:url('admin/Menu/save')}" method="post">
                        <input type="hidden" name="__hash__" value="{$Request.token.__hash__}">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="menu_parentid">上级菜单</label>
                                <select class="form-control select2" id="menu_parentid" name="menu_parentid" style="width: 100%;">
                                    <option {$parent ?: 'selected="selected"'} value="0">顶部菜单</option>
                                    {volist name="menu_list" id="vo"}
                                        {if condition="$vo['level'] eq 0"}
                                            <option {$parent==$vo.menu_id ? 'selected="selected"' : ''} value="{$vo.menu_id}">{$vo.menu_name}</option>
                                        {else/}
                                            <option {$parent==$vo.menu_id ? 'selected="selected"' : ''} value="{$vo.menu_id}">├{:str_repeat('─',$vo.level)} {$vo.menu_name}</option>
                                        {/if}
                                    {/volist}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="menu_name">菜单名称</label>
                                <input type="text" class="form-control" id="menu_name" name="menu_name"
                                       datatype="*"
                                       nullmsg="菜单名称不能为空"
                                       placeholder="菜单名称">
                                <div class="Validform_checktip"></div>
                            </div>
                            <!--<div class="form-group">
                                <label for="menu_type">菜单类型</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="minimal" id="menu_type_1" name="menu_type" value="1"
                                               datatype="*"
                                               nullmsg="请选择菜单类型"
                                               errormsg="请选择菜单类型"
                                               sucmsg=""
                                        >
                                        导航菜单
                                    </label>
                                    <label>
                                        <input type="radio" class="minimal" id="menu_type_2" name="menu_type" value="2">
                                        功能菜单
                                    </label>
                                    <label>
                                        <input type="radio" class="minimal" id="menu_type_3" name="menu_type" value="3">
                                        操作菜单
                                    </label>
                                </div>
                                <div class="Validform_checktip"></div>
                            </div>-->
                            <div class="form-group">
                                <label for="menu_module">模块</label>
                                <input type="text" class="form-control" id="menu_module" name="menu_module"
                                       datatype="yes_null|lowercase"
                                       nullmsg="请填写模块名"
                                       errormsg="模块名只允许为小写英文字母"
                                       placeholder="模块名">
                                <div class="Validform_checktip">模块名只允许为小写英文字母</div>
                            </div>
                            <div class="form-group">
                                <label for="menu_controller">控制器</label>
                                <input type="text" class="form-control" id="menu_controller" name="menu_controller"
                                       datatype="yes_null|first_capital"
                                       nullmsg="请填写控制器名"
                                       errormsg="控制器名只允许为英文字母，且首字母必须为大写"
                                       placeholder="控制器名">
                                <div class="Validform_checktip">控制器名只允许为英文字母，且首字母必须为大写</div>
                            </div>
                            <div class="form-group">
                                <label for="menu_action">方法</label>
                                <input type="text" class="form-control" id="menu_action" name="menu_action"
                                       datatype="yes_null|scope_string_1"
                                       nullmsg="请填写方法名"
                                       errormsg="方法名只允许为英文字母与下划线"
                                       placeholder="方法名">
                                <div class="Validform_checktip">方法名只允许为英文字母与下划线</div>
                            </div>
                            <div class="form-group">
                                <label for="menu_status">显示</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="minimal" id="menu_status_1" name="menu_status" value="1" checked>
                                        是
                                    </label>
                                    <label>
                                        <input type="radio" class="minimal" id="menu_status_2" name="menu_status" value="0">
                                        否
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

        syApp.initValidator();
    });
</script>
