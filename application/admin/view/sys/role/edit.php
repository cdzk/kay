<!-- Content Header (Page header) -->
<section class="content-header clearfix">
    <h5>用户角色</h5>
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i> <a href="{:url('admin/Index/index')}">管理后台</a></li>
        <li>系统管理</li>
        <li><a href="{:url('admin/sys.Role/index')}">用户角色</a></li>
        <li class="active">编辑角色</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <ul class="nav nav-pills child_page_menu">
                        <li role="presentation" {$Request.action==='index' ? 'class="active"' : ''}><a href="{$Request.action==='index' ? 'javascript:void(0);' : url('admin/sys.Role/index')}">角色列表</a></li>
                        <li role="presentation" {$Request.action==='add' ? 'class="active"' : ''}><a href="{$Request.action==='add' ? 'javascript:void(0);' : url('admin/sys.Role/add')}">添加角色</a></li>
                        {if condition="$Request.action eq 'edit'"}
                        <li role="presentation" {$Request.action==='edit' ? 'class="active"' : ''}><a href="javascript:void(0);">编辑角色</a></li>
                        {/if}
                    </ul>
                </div>
                <!-- {:url('admin/Menu/add_save')} -->
                <form id="formSubmit" action="{:url('admin/sys.Role/edit', ['roleId'=>$role.role_id])}" method="post">
                    <input type="hidden" name="__hash__" value="{$Request.token.__hash__}">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="role_name">角色名称</label>
                            <input type="text" class="form-control" id="role_name" name="role_name"
                                   datatype="*"
                                   nullmsg="角色名称不能为空"
                                   errormsg="角色名称不能为空"
                                   placeholder="角色名称"
                                   value="{$role.role_name}">
                            <div class="Validform_checktip"></div>
                        </div>
                        <div class="form-group">
                            <label for="role_remark">角色描述</label>
                            <textarea class="form-control" id="role_remark" name="role_remark" rows="5"
                                      datatype="yes_null|*1-80"
                                      nullmsg="角色描述不能为空"
                                      errormsg="角色描述最多允许输入80个字符"
                                      placeholder="角色描述">{$role.role_remark}</textarea>
                            <div class="Validform_checktip">角色描述最多允许输入80个字符</div>
                        </div>
                        <div class="form-group">
                            <label for="role_status">状态</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" class="minimal" id="role_status_1" name="role_status" value="1" {$role.role_status ?= 'checked'}>
                                    启用
                                </label>
                                <label>
                                    <input type="radio" class="minimal" id="role_status_2" name="role_status" value="0" {$role.role_status ?: 'checked'}>
                                    禁用
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
        adminScript.push('icheck');

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