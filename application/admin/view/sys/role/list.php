<!-- Content Header (Page header) -->
<section class="content-header clearfix">
    <h5>系统角色</h5>
    <ol class="breadcrumb">
        <li><i class="fa fa-home"></i> <a href="{:url('admin/Index/index')}">管理首页</a></li>
        <li>系统管理</li>
        <li>用户角色</li>
        <li class="active"><a href="{:url('admin/sys.Role/index')}">角色列表</a></li>
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
                                <td class="text-left">{$vo.role_name}</td>
                                <td class="text-left">{$vo.role_remake}</td>
                                <td class="text-center">{switch name="vo.role_status"}
                                    {case value="1"}<a class="btn btn-success {$vo.role_id===1 ? 'disabled' : ''}"
                                                       href="javascript:void(0);" role="button"
                                                       {$vo.role_id===1 ? '' : 'onclick="setStatus('.$vo.role_id.', 0);"'}>启用</a>{/case}
                                    {case value="0"}<a class="btn btn-default {$vo.role_id===1 ? 'disabled' : ''}"
                                                       href="javascript:void(0);" role="button"
                                                       {$vo.role_id===1 ? '' : 'onclick="setStatus('.$vo.role_id.', 1);"'}>禁用</a>{/case}
                                    {/switch}</td>
                                <td class="text-center">
                                    <a class="btn btn-primary {$vo.role_id===1 ? 'disabled' : ''}"
                                       href="javascript:void(0);"
                                       role="button"
                                       onclick="setAuth({$vo.role_id}, '#setMenuAuth', '菜单权限设置', '#menuTree', '{:url(\'admin/sys.Role/menu_auth\')}', 'menu_id', 'menu_parentid', 'menu_name');">菜单权限</a>
                                    <a class="btn btn-primary {$vo.role_id===1 ? 'disabled' : ''}"
                                       href="javascript:void(0);"
                                       role="button"
                                       onclick="setAuth({$vo.role_id}, '#setAuth', '管理权限设置', '#authTree', '{:url(\'admin/sys.Role/system_auth\')}', 'auth_id', 'auth_parentid', 'auth_name');">系统权限</a>
                                    <a class="btn btn-primary" href="javascript:void(0);" role="button">成员管理</a>
                                    <a class="btn btn-primary {$vo.role_id===1 ? 'disabled' : ''}" href="{$vo.role_id===1 ? '' : url('admin/sys.Role/edit', ['roleId'=>$vo.role_id])}" role="button">编辑</a>
                                    <a class="btn btn-primary {$vo.role_id===1 ? 'disabled' : ''}" href="javascript:void(0);"
                                       {$vo.role_id===1 ? '' : 'onclick="admin.ajaxDel(\\''.url('admin/sys.Role/del').'\\', \\'role_id='.$vo.role_id.'\\');"'}
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

{include file="public/popup_set_auth" /}

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

                'ztree',
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
                });
            }
        );
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
        kay.aReq('post', '{:url(\'admin/sys.Role/status\')}', {role_id:role_id, role_status:role_status}, 'json',
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

    /**
     * 权限设置：菜单权限、管理权限
     * 弹出弹窗并加载树状态菜单数据
     *
     * @param roleId 角色id
     * @param dom 弹窗加载内容的容器
     * @param popupTitle 弹窗标题
     * @param treeDom 树状菜单数据加载容器
     * @param ajaxUrl 异步请求地址
     * @param keyId 树状节点ID字段
     * @param keyParentId 树状节点父ID字段
     * @param keyName 树状节点名称字段
     */
    function setAuth(roleId, dom, popupTitle, treeDom, ajaxUrl, keyId, keyParentId, keyName) {
        var index = layer.open({
            type: 1,
            title: popupTitle,
            // area: ['auto', '420px'],
            area: 'auto',
            offset: '25%',
            resize: false,
            content: $(dom),
            success: function () {
                // popup弹出成功后将当前角色id赋值到隐藏表单
                $('input[name="role_id"]').val(roleId);

                var option = {
                    container: $(treeDom),
                    setting: {
                        check: {
                            enable: true,
                            chkStyle: 'checkbox',
                            chkboxType: {'Y':'p', 'N':'s'}
                        },
                        async: {
                            url: ajaxUrl,
                            type:"post",
                            otherParam: ['role_id',roleId],
                            dataFilter: function (treeId, parentNode, responseData) {
                                // 将从数据库中获取到的角色已有权限赋值到隐藏表单
                                $('input[name="checkedAuth"]').val(responseData.role_tree);

                                // console.log(responseData.tree);

                                // 加载指定数据到tree
                                return responseData.tree;
                            }
                        },
                        data: {
                            key: {
                                name: keyName
                            },
                            simpleData: {
                                idKey: keyId,
                                pIdKey: keyParentId
                            }
                        },
                        callback: {
                            // 点击节点名称选中
                            onClick: function (e, treeId, treeNode, clickFlag) {
                                _zTree.checkNode(treeNode, !treeNode.checked, true);

                                _checkedNodeId(treeId);
                            },
                            // 选中选择框事件
                            onCheck: function (e, treeId, treeNode) {
                                _checkedNodeId(treeId);
                            },

                            // 异步加载前事件
                            onAsyncSuccess: _onAsyncSuccess
                        }
                    }
                };

                // 获取选中节点的id
                function _checkedNodeId(_treeId) {
                    // 获取所有节点
                    var treeObj = $.fn.zTree.getZTreeObj(_treeId);
                    var node = treeObj.getNodes();
                    var nodes = treeObj.transformToArray(node);

                    // 获取选中节点的id
                    var treeID = [];
                    $.each(nodes, function (i, v) {
                        if (v.checked) {
                            treeID.push(v[keyId]);
                        }
                    });

                    // 将选中的节点id赋值给隐藏表单
                    $(dom+' input[name="checkedAuth"]').val(treeID);
                }

                // 异步加载成功后，自动选中已保存在数据库中的节点
                function _onAsyncSuccess(event, treeId, msg) {
                    console.log(msg);
                    // 获取所有节点
                    var treeObj = $.fn.zTree.getZTreeObj(treeId);
                    treeObj.expandAll(true); // 展开所有节点
                    var node = treeObj.getNodes();
                    var nodes = treeObj.transformToArray(node);

                    // 获取数据库中的节点id
                    var dataId = $(dom+' input[name="checkedAuth"]').val();
                    var dataIdArr1 = dataId.split(',');
                    var dataIdArr2 = [];
                    for (i in dataIdArr1) {
                        dataIdArr2.push(parseInt(dataIdArr1[i]));
                    }
                    /*if (dataId.replace(/,/g, '').length < nodes.length) {
                        dataId = dataId.replace(/1,/g, '');
                    }*/

                    // 遍历所有节点
                    for (var i=0, l=nodes.length; i < l; i++) {
                        // 获取节点id
                        var _id = nodes[i][keyId];

                        // 节点id与数据库中保存的id进行匹配，true 则自动选中，
                        // 自动选中时不选中序号为0的节点，解决根节点选中以后所有节点被选中的问题
                        if ($.inArray(_id, dataIdArr2)>=0) {
                            treeObj.checkNode(nodes[i], true, false);
                        }
                    }

                }
                //加载树插件
                var _zTree = admin.zTree(option);

                // 给取消按钮绑定事件
                $('button[name="setAuth-btn-cancel"]').on('click', function () {
                    layer.close(index);
                });

                // 加载表单提交插件
                kay.ajaxFormSubmit($(dom+' form'), function () {
                    layer.close(index);
                });
            }
        });
    }
</script>