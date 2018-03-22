<!-- Content Header (Page header) -->
<section class="content-header clearfix">
    <h5>系统菜单</h5>
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i> <a href="{:url('admin/Index/index')}">管理首页</a></li>
        <li>系统管理</li>
        <li>系统菜单</li>
        <li class="active"><a href="{:url('admin/sys.Menu/index')}">菜单列表</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <ul class="nav nav-pills child_page_menu">
                        <li role="presentation" {$Request.action==='index' ? 'class="active"' : ''}><a href="{$Request.action==='index' ? 'javascript:void(0);' : url('admin/sys.Menu/index')}">菜单列表</a></li>
                        <li role="presentation" {$Request.action==='add' ? 'class="active"' : ''}><a href="{$Request.action==='add' ? 'javascript:void(0);' : url('admin/sys.Menu/add')}">添加菜单</a></li>
                    </ul>
                </div>

                <form action="{:url('admin/sys.Menu/sort');}">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered table-hover tree">
                                <thead class="table_head">
                                <tr>
                                    <th class="text-center" style="width: 60px;">排序</th>
                                    <th class="text-center" style="width: 60px;">ID</th>
                                    <th class="text-center">菜单名称</th>
                                    <th class="text-center" style="width: 100px;">状态</th>
                                    <th class="text-center" style="width: 200px;">操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                {volist name="menu_list" id="vo"}
                                <tr class="treegrid-{$vo.menu_id} {$vo.level ?= ' treegrid-parent-'.$vo.menu_parentid}">
                                    <td class="text-center"><input class="form-control input_text" id="menu_sort_{$vo.menu_id}" name="menu_sort[{$vo.menu_id}]" type="text" value="{$vo.menu_sort}"
                                                                   onkeyup="this.value=this.value.replace(/\D/g,'')"
                                                                   onafterpaste="this.value=this.value.replace(/\D/g,'')"
                                                                   style="width: 42px;text-align: center;"></td>
                                    <td class="text-center">{$vo.menu_id}</td>

                                    {if condition="$vo['level'] eq 0"}
                                    <td class="text-left" style="font-weight: bold;">{$vo.menu_name}</td>
                                    {else/}
                                    <td>├{:str_repeat('─',$vo.level)} {$vo.menu_name}</td>
                                    {/if}

                                    <td class="text-center">{switch name="vo.menu_status"}
                                        {case value="1"}<a class="btn btn-success" href="javascript:void(0);" role="button" onclick="setStatus({$vo.menu_id}, 0);">显示</a>{/case}
                                        {case value="0"}<a class="btn btn-default" href="javascript:void(0);" role="button" onclick="setStatus({$vo.menu_id}, 1);">隐藏</a>{/case}
                                        {/switch}</td>

                                    <td class="text-center">
                                        <a class="btn btn-primary" href="{:url('admin/sys.Menu/add', ['parentId'=>$vo.menu_id])}" role="button">添加子菜单</a>
                                        <a class="btn btn-primary" href="{:url('admin/sys.Menu/edit', ['menuId'=>$vo.menu_id])}" role="button">编辑</a>
                                        <a class="btn btn-primary" href="javascript:void(0);"
                                           onclick="admin.ajaxDel('{:url(\'admin/sys.Menu/del\')}', 'menu_id={$vo.menu_id}')"
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
                'jquery.form',
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
                        admin.treeTable(3);
                    }, 500);

                    kay.ajaxFormSubmit($('form'));
                });
            }
        );
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
        kay.aReq('post', '{:url(\'admin/sys.Menu/status\')}', {menu_id:menu_id, menu_status:menu_status}, 'json',
            function () {
                waitLoad = layer.load(1, {
                    shade: [0.5,'#000']
                });
            },
            function (d) {
                layer.close(waitLoad);
                layer.msg(d['msg']);

                if (d['code']===200) status();
            });
    }
</script>