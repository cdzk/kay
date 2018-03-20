<!-- Content Header (Page header) -->
<section class="content-header clearfix">
    <h5>系统权限</h5>
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i> <a href="{:url('admin/Index/index')}">管理首页</a></li>
        <li>系统管理</li>
        <li>系统权限</li>
        <li class="active"><a href="{:url('admin/sys.Auth/index')}">权限列表</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <ul class="nav nav-pills child_page_menu">
                        <li role="presentation" {$Request.action==='index' ? 'class="active"' : ''}><a href="{$Request.action==='index' ? 'javascript:void(0);' : url('admin/sys.Auth/index')}">权限列表</a></li>
                        <li role="presentation" {$Request.action==='add' ? 'class="active"' : ''}><a href="{$Request.action==='add' ? 'javascript:void(0);' : url('admin/sys.Auth/add')}">添加权限</a></li>
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
                                    <a class="btn btn-primary" href="{:url('admin/sys.Auth/add', ['parentId'=>$vo.auth_id])}" role="button">添加子权限</a>
                                    <a class="btn btn-primary" href="{:url('admin/sys.Auth/edit', ['authId'=>$vo.auth_id])}" role="button">编辑</a>
                                    <a class="btn btn-primary" href="javascript:void(0);"
                                       onclick="admin.ajaxDel('{:url(\'admin/sys.Auth/del\')}', 'auth_id={$vo.auth_id}')"
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

<!-- requireJs 2.3.5 -->
<script src="{$Think.config.path.static}js/require.js"></script>
<script>
    require(['{$Think.config.path.static}js/require.config.js'], function () {
        require(
            [
                'jquery',
                'bootstrap',
                'layer',
                'slimscroll',
                'adminLTE',
                'kay',
                'admin',

                'treegrid',
                'treegrid.bootstrap3',
            ],
            function ($) {
                layer.config({
                    path: '/static/common/plugins/layer/'
                });

                $(function () {
                    // 根据窗口大小调整 main区域的高度
                    admin.setMainHeight();
                    $(window).resize(function() {
                        admin.setMainHeight();
                    });

                    // 左侧菜单滚动条
                    var $h = $(window).height()-($('.main-footer').height()+parseInt($('.content-wrapper').css('paddingTop'))+30);
                    $(".sidebar-menu").slimScroll({
                        height: $h+'px'
                    });

                    setTimeout(function () {
                        admin.treeTable(2);
                    }, 500);
                });
            }
        );
    });
</script>