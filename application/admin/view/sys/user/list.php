<!-- Content Header (Page header) -->
<section class="content-header clearfix">
    <h5>系统用户</h5>
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i> <a href="{:url('admin/Index/index')}">管理首页</a></li>
        <li>系统管理</li>
        <li>系统用户</li>
        <li class="active"><a href="{:url('admin/sys.Role/index')}">用户列表</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <ul class="nav nav-pills child_page_menu">
                        <li role="presentation" {$Request.action==='index' ? 'class="active"' : ''}><a href="{$Request.action==='index' ? 'javascript:void(0);' : url('admin/sys.User/index')}">用户列表</a></li>
                        <li role="presentation" {$Request.action==='add' ? 'class="active"' : ''}><a href="{$Request.action==='add' ? 'javascript:void(0);' : url('admin/sys.User/add')}">添加用户</a></li>
                    </ul>
                </div>

                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead class="table_head">
                            <tr>
                                <th class="text-center" style="width: 60px;">ID</th>
                                <th class="text-center">用户名</th>
                                <th class="text-center">角色分组</th>
                                <th class="text-center">真实姓名</th>
                                <th class="text-center">邮箱</th>
                                <th class="text-center">手机号码</th>
                                <th class="text-center" style="width: 100px;">状态</th>
                                <th class="text-center">添加时间</th>
                                <!--<th class="text-center">最近登录</th>-->
                                <th class="text-center" style="width: 200px;">操作</th>
                            </tr>
                            </thead>

                            <tbody>
                            {volist name="user_list" id="vo"}
                            <tr>
                                <td class="text-center">{$vo.user_id}</td>
                                <td class="text-left">{$vo.user_name}</td>
                                <td class="text-left">{$vo.role_name}</td>
                                <td class="text-left">{$vo.user_realname}</td>
                                <td class="text-left">{$vo.user_email}</td>
                                <td class="text-center">{$vo.user_mobile}</td>
                                <td class="text-center">{switch name="vo.user_status"}
                                    {case value="1"}<a class="btn btn-success" href="javascript:void(0);" role="button" onclick="setStatus({$vo.user_id}, 0);">正常</a>{/case}
                                    {case value="0"}<a class="btn btn-default" href="javascript:void(0);" role="button" onclick="setStatus({$vo.user_id}, 1);">锁定</a>{/case}
                                    {/switch}</td>
                                <td class="text-center">{:date('Y-m-d H:i:s', $vo.user_addtime)}</td>
                                <!--<td class="text-left">
                                    <p>I&emsp;P：{$vo.user_login_last_ip ? $vo.user_login_last_ip : '--'}</p>
                                    <p>地点：{$vo.user_login_last_area ? $vo.user_login_last_area : '--'}</p>
                                    <p>时间：{$vo.user_login_last_area ? date('Y-m-d H:i:s', $vo.user_login_last_time) : '--'}</p>
                                </td>-->
                                <td class="text-center">
                                    <a class="btn btn-primary" href="{:url('admin/sys.User/edit', ['userId'=>$vo.user_id])}" role="button">编辑</a>
                                    <a class="btn btn-primary" href="javascript:void(0);"
                                       onclick="admin.ajaxDel('{:url(\'admin/sys.User/del\')}', 'user_id={$vo.user_id}')"
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
                });
            }
        );
    });

    /**
     * 设置用户状态
     * @param user_id 用户id
     * @param user_status 状态码
     */
    function setStatus(user_id, user_status) {
        var _this = event.toElement,
            $this = $(_this),
            str='';
        var status = function () {
            switch (user_status) {
                case 0:
                    str = '<a class="btn btn-default" href="javascript:void(0);" role="button" onclick="setStatus('+ user_id +', 1);">锁定</a>';
                    break;
                case 1:
                    str = '<a class="btn btn-success" href="javascript:void(0);" role="button" onclick="setStatus('+ user_id +', 0);">正常</a>';
                    break;
            }
            $this.parent().html(str);
        };

        var waitLoad; // 等待动画调用变量
        kay.aReq('post', '{:url(\'admin/sys.User/status\')}', {user_id:user_id, user_status:user_status}, 'json',
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