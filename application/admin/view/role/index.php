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

    <!-- zTree -->
    <link rel="stylesheet" href="{$Think.PATH_STATIC}plugins/zTree/css/zTreeStyle/zTreeStyle.css">

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
                                           onclick="setAuth({$vo.role_id}, '#setMenuAuth', '菜单权限设置', '#menuTree', '{:url(\'admin/Role/auth_menu\')}', 'menu_id', 'menu_parentid', 'menu_name');">菜单权限</a>
                                        <a class="btn btn-primary {$vo.role_id===1 ? 'disabled' : ''}"
                                           href="javascript:void(0);"
                                           role="button"
                                           onclick="setAuth({$vo.role_id}, '#setAuth', '管理权限设置', '#authTree', '{:url(\'admin/Role/auth\')}', 'auth_id', 'auth_parentid', 'auth_name');">管理权限</a>
                                        <a class="btn btn-primary" href="javascript:void(0);" role="button">成员管理</a>
                                        <a class="btn btn-primary {$vo.role_id===1 ? 'disabled' : ''}" href="{$vo.role_id===1 ? '' : url('admin/Role/edit', ['role_id'=>$vo.role_id])}" role="button">修改</a>
                                        <a class="btn btn-primary {$vo.role_id===1 ? 'disabled' : ''}" href="javascript:void(0);"
                                           {$vo.role_id===1 ? '' : 'onclick="syApp.ajaxDel(\\''.url('admin/Role/del').'\\', \\'role_id='.$vo.role_id.'\\');"'}
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

{include file="public/popup_set_auth" /}
</body>
</html>
<!-- jQuery 2.2.3 -->
<script src="{$Think.PATH_COMMON_STATIC}plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{$Think.PATH_STATIC}bootstrap/js/bootstrap.min.js"></script>
<!-- layer 3.0.3 -->
<script src="{$Think.PATH_COMMON_STATIC}plugins/layer/layer.js"></script>

<!-- zTree -->
<script src="{$Think.PATH_STATIC}plugins/zTree/js/jquery.ztree.all.min.js"></script>
<!-- jquery-form 4.2.1 -->
<script src="{$Think.PATH_COMMON_STATIC}plugins/jQueryForm/jquery.form.min.js"></script>

<!-- AdminLTE App -->
<script src="{$Think.PATH_STATIC}dist/js/yc_app.js"></script>
<script>
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
        syApp.aReq('post', '{:url(\'admin/Role/status\')}', {role_id:role_id, role_status:role_status}, 'json',
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
                        async: {
                            url: ajaxUrl,
                            type:"post",
                            otherParam: ['id',roleId],
                            dataFilter: function (treeId, parentNode, responseData) {
                                // 将从数据库中获取到的角色已有权限赋值到隐藏表单
                                $('input[name="checkedAuth"]').val(responseData.role_tree);

                                console.log(responseData.tree);

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
                    var node = treeObj.getNodes();
                    var nodes = treeObj.transformToArray(node);

                    // 获取数据库中的节点id
                    var dataId = $(dom+' input[name="checkedAuth"]').val();
                    /*if (dataId.replace(/,/g, '').length < nodes.length) {
                        dataId = dataId.replace(/1,/g, '');
                    }*/

                    // 遍历所有节点
                    for (var i=0, l=nodes.length; i < l; i++) {
                        // 获取节点id
                        var _id = nodes[i][keyId];

                        // 节点id与数据库中保存的id进行匹配，true 则自动选中，
                        // 自动选中时不选中序号为0的节点，解决根节点选中以后所有节点被选中的问题
                        if(dataId.match(_id) && i>0) {
                            treeObj.checkNode(nodes[i], true, true);
                        }
                    }

                }

                //加载树插件
                var _zTree = syApp.zTree(option);

                // 给取消按钮绑定事件
                $('button[name="setAuth-btn-cancel"]').on('click', function () {
                    layer.close(index);
                });

                // 加载表单提交插件
                syApp.ajaxFormSubmit($(dom+' form'));
            }
        });
    }
</script>