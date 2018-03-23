<!-- Content Header (Page header) -->
<section class="content-header clearfix">
    <h5>系统菜单</h5>
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i> <a href="{:url('admin/Index/index')}">管理后台</a></li>
        <li>系统管理</li>
        <li><a href="{:url('admin/sys.Menu/index')}">系统菜单</a></li>
        <li class="active">编辑菜单</li>
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
                        {if condition="$Request.action eq 'edit'"}
                        <li role="presentation" {$Request.action==='edit' ? 'class="active"' : ''}><a href="javascript:void(0);">编辑菜单</a></li>
                        {/if}
                    </ul>
                </div>
                <!-- {:url('admin/Menu/add_save')} -->
                <form id="formSubmit" action="{:url('admin/sys.Menu/edit', ['menuId'=>$menu.menu_id])}" method="post">
                    <input type="hidden" name="__hash__" value="{$Request.token.__hash__}">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="menu_parentid">上级菜单</label>
                            <select class="form-control select2" id="menu_parentid" name="menu_parentid" style="width: 100%;">
                                <option {$menu.menu_parentid==0 ? 'selected="selected"' : ''} value="0">顶部菜单</option>
                                {volist name="menu_list" id="vo"}
                                {if condition="$vo['level'] eq 0"}
                                <option {$menu.menu_parentid==$vo.menu_id ? 'selected="selected"' : ''} value="{$vo.menu_id}">{$vo.menu_name}</option>
                                {else/}
                                <option {$menu.menu_parentid==$vo.menu_id ? 'selected="selected"' : ''} value="{$vo.menu_id}">├{:str_repeat('─',$vo.level)} {$vo.menu_name}</option>
                                {/if}
                                {/volist}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="menu_name">菜单名称</label>
                            <input type="text" class="form-control" id="menu_name" name="menu_name"
                                   datatype="*"
                                   nullmsg="菜单名称不能为空"
                                   placeholder="菜单名称"
                                   value="{$menu.menu_name}">
                            <div class="Validform_checktip"></div>
                        </div>
                        <div class="form-group">
                            <label for="menu_module">模块</label>
                            <input type="text" class="form-control" id="menu_module" name="menu_module"
                                   datatype="yes_null|lowercase"
                                   nullmsg="请填写模块名"
                                   errormsg="模块名只允许填写小写英文字母"
                                   placeholder="模块名"
                                   value="{$menu.menu_module}">
                            <div class="Validform_checktip">模块名只允许为小写英文字母</div>
                        </div>
                        <div class="form-group">
                            <label for="menu_controller">控制器</label>
                            <input type="text" class="form-control" id="menu_controller" name="menu_controller"
                                   datatype="yes_null|scope_string_4"
                                   nullmsg="请填写控制器名"
                                   errormsg="控制器名只允许输入英文字母与“.”"
                                   placeholder="控制器名"
                                   value="{$menu.menu_controller}">
                            <div class="Validform_checktip">只允许为英文字母、“.”，格式：“控制器目录.控制器名”或“控制器名”</div>
                        </div>
                        <div class="form-group">
                            <label for="menu_action">方法</label>
                            <input type="text" class="form-control" id="menu_action" name="menu_action"
                                   datatype="yes_null|scope_string_1"
                                   nullmsg="请填写方法名"
                                   errormsg="方法名只允许为英文字母与下划线"
                                   placeholder="方法名"
                                   value="{$menu.menu_action}">
                            <div class="Validform_checktip">方法名只允许为英文字母与下划线</div>
                        </div>
                        <div class="form-group">
                            <label for="menu_status">显示</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" class="minimal" id="menu_status_1" name="menu_status" value="1" {$menu.menu_status ?= 'checked'}>
                                    是
                                </label>
                                <label>
                                    <input type="radio" class="minimal" id="menu_status_2" name="menu_status" value="0" {$menu.menu_status ?: 'checked'}>
                                    否
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer text-center">
                        <button type="submit" class="btn btn-info" style="width: 80px;height: 28px">保&emsp;存</button>
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
        adminScript.push('select2', 'icheck');
        require(adminScript, function ($) {
            layerPath();

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

                $(".select2").select2();

                //iCheck for checkbox and radio inputs
                $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass: 'iradio_minimal-blue'
                });

                admin.initValidator();
            });
        });
    });
</script>