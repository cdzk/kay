<!-- Content Header (Page header) -->
<section class="content-header clearfix">
    <h5>系统权限</h5>
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i> <a href="{:url('admin/Index/index')}">管理首页</a></li>
        <li>系统管理</li>
        <li class="active"><a href="{:url('admin/sys.Auth/index')}">系统权限</a></li>
        <li class="active">编辑权限</li>
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
                        {if condition="$Request.action eq 'edit'"}
                        <li role="presentation" {$Request.action==='edit' ? 'class="active"' : ''}><a href="javascript:void(0);">编辑权限</a></li>
                        {/if}
                    </ul>
                </div>
                <!-- {:url('admin/Menu/add_save')} -->
                <form id="formSubmit" action="{:url('admin/sys.Auth/edit', ['authId'=>$auth.auth_id])}" method="post">
                    <input type="hidden" name="__hash__" value="{$Request.token.__hash__}">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="menu_parentid">上级菜单</label>
                            <select class="form-control select2" id="auth_parentid" name="auth_parentid" style="width: 100%;">
                                <option {$auth.auth_parentid==0 ? 'selected="selected"' : ''} value="0">顶部菜单</option>
                                {volist name="auth_list" id="vo"}
                                {if condition="$vo['level'] eq 0"}
                                <option {$auth.auth_parentid==$vo.auth_id ? 'selected="selected"' : ''} value="{$vo.auth_id}">{$vo.auth_name}</option>
                                {else/}
                                <option {$auth.auth_parentid==$vo.auth_id ? 'selected="selected"' : ''} value="{$vo.auth_id}">├{:str_repeat('─',$vo.level)} {$vo.auth_name}</option>
                                {/if}
                                {/volist}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="auth_name">权限名称</label>
                            <input type="text" class="form-control" id="auth_name" name="auth_name"
                                   datatype="*"
                                   nullmsg="权限名称不能为空"
                                   placeholder="权限名称"
                                   value="{$auth.auth_name}">
                            <div class="Validform_checktip"></div>
                        </div>
                        <div class="form-group">
                            <label for="auth_module">模块</label>
                            <input type="text" class="form-control" id="auth_module" name="auth_module"
                                   datatype="lowercase"
                                   nullmsg="模块名不能为空"
                                   errormsg="模块名只允许为小写英文字母"
                                   placeholder="模块名"
                                   value="{$auth.auth_module}">
                            <div class="Validform_checktip">只允许为小写英文字母</div>
                        </div>
                        <div class="form-group">
                            <label for="auth_controller">控制器</label>
                            <input type="text" class="form-control" id="auth_controller" name="auth_controller"
                                   datatype="scope_string_4"
                                   nullmsg="控制器名不能为空"
                                   errormsg="控制器名只允许输入英文字母与“.”"
                                   placeholder="控制器名"
                                   value="{$auth.auth_controller}">
                            <div class="Validform_checktip">只允许为英文字母、“.”，格式：“控制器目录.控制器名”或“控制器名”</div>
                        </div>
                        <div class="form-group">
                            <label for="auth_action">方法</label>
                            <input type="text" class="form-control" id="auth_action" name="auth_action"
                                   datatype="scope_string_1"
                                   nullmsg="方法名不能为空"
                                   errormsg="方法名只允许为英文字母与下划线"
                                   placeholder="方法名"
                                   value="{$auth.auth_action}">
                            <div class="Validform_checktip">只允许为英文字母与下划线</div>
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
        require(
            [
                'jquery',
                'bootstrap',
                'layer',
                'slimscroll',
                'adminLTE',
                'admin',

                'select2',
                'validform',
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

                    $(".select2").select2();

                    admin.initValidator();
                });
            }
        );
    });
</script>