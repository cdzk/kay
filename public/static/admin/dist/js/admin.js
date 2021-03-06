function BaseApp() {
    this.apiUrl = '/admin/';

    this.initElements();
    this.initEvents();

    // 判断当前页面是否在iFrame中，是则调用关闭顶部用户菜单方法
    if (self != top) this.closeHeadUserMenu();
}

BaseApp.prototype = {
    /**
     * 初始化元素
     */
    initElements: function () {
        this.mainWrapper = $('.content-wrapper');
        this.adminMenuHeaderLi = $('#header-menu > li');
        this.adminMenuLeftUl = $('.sidebar-menu');
    },

    /**
     * 初始化事件
     */
    initEvents: function () {
        var _this = this;

        // 管理后台菜单 顶部菜单操作事件
        this.adminMenuHeaderLi.on('click', function (event) {
            var $this = $(this);
            _this.getAdminMenu($this);
        });
    },

    /**
     * aReq
     * Ajax请求封装
     *
     * @param type 请求类型
     * @param url 请求地址
     * @param {object|string} data 请求时需要传递的参数
     * @param dataType 返回数据类型
     * @param {function} beforeBackcall 请求前的回调方法
     * @param {function} sBackcall 请求成功后的回调方法
     */
    aReq: function (type, url, data, dataType, beforeBackcall, sBackcall) {
        var beforeBackcall  =   beforeBackcall || function () {},
            sBackcall       =   sBackcall || function () {};

        $.ajax({
            type: type,
            url: url,
            data: data,
            dataType: dataType,
            beforeSend: beforeBackcall,
            success: sBackcall
        });
    },

    /**
     * closeHeadUserMenu
     * 在iframe子页面中点击任意位置关闭父页面的顶部用户菜单
     */
    closeHeadUserMenu: function () {
        $('body').click(function () {
            var userMenu = $('.user-menu', window.parent.document);

            if (userMenu.hasClass('open') && userMenu.find('.dropdown-toggle').attr('aria-expanded')=='true') {
                userMenu.removeClass('open');
                userMenu.find('.dropdown-toggle').attr('aria-expanded', 'false');
            }
        });
    },

    /**
     * getSysInfo
     * 获取服务器系统信息
     */
    getSysInfo: function () {
        this.aReq('get', this.apiUrl+'ajax_sys_info', '', 'json', '', function (data) {
            $('#server-time').html(data.data.currentTimes);
            $('#server-cpu').html(data.data.cpu_usage+' <small>%</small>');
            $('#server-ram').html(data.data.mem_usage+' <small>%</small>');
            $('#server-disk').html(data.data.hd_avail);
        });
    },

    /**
     * 设置管理后台 main区域高度
     */
    setMainHeight: function () {
        var $winHeight = $(window).height();
        this.mainWrapper.css({
            'min-height': $winHeight-56
        });
    },

    /**
     * 设置管理后台 iframe 高度
     */
    iframeHeight: function () {
        var $body = $('.content-wrapper').height();
        $('#main').css('height', $body+5);
    },

    /**
     * 控制管理后台顶部菜单高亮，并获取左侧菜单数据
     * @param {dom} currentObj
     */
    getAdminMenu: function (currentObj) {
        var _this = this;

        // 左侧边栏显示控制
        if (!$('body').hasClass('sidebar-collapse')) $('body').addClass('sidebar-collapse');

        // 当前菜单样式控制
        currentObj
            .addClass('active')
            .siblings()
            .removeClass('active');

        var _menuParentId = currentObj.attr('data-id'); // 获取菜单父级id

        // 获取管理后台左侧菜单数据，并加载左侧边栏
        this.aReq('post', this.apiUrl+'ajax_admin_menu/'+_menuParentId, {menu_parentid:_menuParentId}, '', '', function (data) {
            _this.adminMenuLeftUl.html(data);
        });
    },

    /**
     * 可以折叠的树状目录表格插件调用
     *
     * @description
     *  调用jquery.treegrid插件
     *  引用 xxx/css/jquery.treegrid.css
     *      xxx/js/jquery.treegrid.js
     *      xxx/js/jquery.treegrid.bootstrap3.js
     *
     * @example
     *  <!-- 需要调用插件的table，加上class tree -->
     *  <table class="table tree">
     *      <!-- 根目录 class treegrid-x 表示目录id -->
     *      <tr class="treegrid-1">
     *          <td></td>
     *      </tr>
     *      <!-- 子目录 class treegrid-parent-x 表示父级目录id -->
     *      <tr class="treegrid-2 treegrid-parent-1">
     *          <td></td>
     *      </tr>
     *  </table>
     *
     *  @param {int} column 在第几列加载折叠图标
     */
    treeTable: function (column) {
        if (typeof column !== 'number' && typeof column !== 'undefined') {
            console.warn('参数错误');
            return false;
        }
        column = column||1;

        $('.tree').treegrid({
            treeColumn: column-1, // 设置在第几列显示折叠图标
            expanderExpandedClass: 'glyphicon glyphicon-minus', // 收起图标
            expanderCollapsedClass: 'glyphicon glyphicon-plus'  // 展开图标
        });
    },

    /**
     * 表单验证配置初始化
     *
     * @description
     *  引用 xxx/Validform_v5.3.2.js
     *
     */
    initValidator: function () {
        // 判断表单验证提示信息容器是否有内容，并进行样式调整
        function setMsgStyle() {
            var $msgBox = $('.Validform_checktip');
            $msgBox.each(function (i, v) {
                if ($(v).html() !== '') {
                    $(v).css({
                        'margin-top': '5px'
                    });
                }
            });
        }
        // setMsgStyle();

        var waitLoad; // 等待动画调用变量
        $('form').Validform({
            tiptype: function(msg,o,cssctl){
                // setMsgStyle();
                // 验证提示消息处理
                if(!o.obj.is("form")){  // 验证表单元素时o.obj为该表单元素，全部验证通过提交表单时o.obj为该表单对象;
                    var objtip;
                    if (o.obj.attr('type')==='radio') { // 判断表单是否为单选框，如果是则进行单独的验证提示消息处理
                        objtip=o.obj.parents().parents().parents().siblings(".Validform_checktip");
                    } else {
                        objtip=o.obj.siblings(".Validform_checktip");
                    }
                    cssctl(objtip,o.type);
                    objtip.text(msg);
                }
            },
            ajaxPost: true,
            showAllError: true,
            postonce: true,
            datatype:{ // 自定义验证规则
                'yes_null': /^\s*$/,                                    // 允许为空
                'lowercase': /[a-z]+$/,                                 // 只允许小写英文字母
                'first_capital': /^[A-Z][A-Za-z]+$/,                    // 只允许大小写英文字母，且首写字母必须为大写
                'scope_string_1': /[a-zA-Z_]/ig,                        // 只允许大小写英文字母与“_”下划线
                'scope_string_2': /^(?=.*\d.*)(?=.*[a-zA-Z].*).{2,}$/,  // 必须包含英文字母与数字
                'scope_string_3': /[a-zA-Z0-9]+$/,                      // 只允许使用英文字母与数字
                'check_name': /^([\u4e00-\u9fa5]+|([a-z]+\s?)+)$/,      // 姓名格式验证 中文不允许有空格，英文最多只能有一个空格
                'check_mobile': /^1[3-9]\d{9}$/,                        // 手机号码格式验证
            },
            beforeSubmit: function () {
                waitLoad = layer.load(1, {
                    shade: [0.5,'#000']
                });
            },
            callback: function (d) {
                layer.close(waitLoad);
                layer.msg(d['msg']);

                if (d['status']>=1) {
                    if (typeof d['result']['jumpUrl'] !== 'undefined') { // 判断是否有跳转url地址存在，有则执行跳转
                        setTimeout(function () {
                            window.location.href = d['result']['jumpUrl'];
                        }, 1500);
                    }
                }
            }
        });
    },

    /**
     * ajax方式提交表单
     *
     * @description
     *  引用 xxx/jquery.form.min.js
     *
     * @param {dom} formObj 表单对象
     */
    ajaxFormSubmit: function (formObj) {
        var waitLoad; // 等待动画调用变量
        formObj.ajaxForm({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            beforeSubmit:function(){
                waitLoad = layer.load(1, {
                    shade: [0.5,'#000']
                });
            },
            success: function (d) {
                layer.close(waitLoad);
                layer.msg(d['msg']);

                if (d['status']>=1) {
                    if (typeof d['result']['jumpUrl'] !== 'undefined') { // 判断是否有跳转url地址存在，有则执行跳转
                        setTimeout(function () {
                            window.location.href = d['result']['jumpUrl'];
                        }, 1500);
                    }
                }
            },
            error: function () {

            }
        });
        return false;
    },

    /**
     * ajax方式删除数据
     * @param {string} url 请求url地址
     * @param {object|string} data 提交参数
     */
    ajaxDel: function (url, data) {
        var _this = event.toElement, // 获取事件对象
            $this = $(_this); // 转换为jq对象

        var waitLoad; // 等待动画调用变量

        this.aReq('get', url, data, 'json',
            function () {
                waitLoad = layer.load(1, {
                    shade: [0.5,'#000']
                });
            },
            function (d) {
                layer.close(waitLoad);
                layer.msg(d['msg']);

                if (d['status']>=1)
                    // 请求成功后移除事件对象所在tr
                    $this.parent().parent().fadeOut(500, function () {
                        $this.remove();
                    });
        });
    },

    /**
     * zTree树插件
     * @help http://www.treejs.cn/v3/api.php
     *
     * @param option
     */
    zTree: function (option) {
        // 默认配置
        var defaults = {
            // 容器，jquery对象，id、dom、class均可
            container: $('#tree'),

            // 配置参数
            setting: {
                async: {
                    enable: true, // 是否开启异步加载
                    url: '', // 异步请求url
                    type: 'post', // 请求方式 post get
                    autoParam: [] // 加载时需要自动提交的父节点id字段
                },
                view: {
                    showIcon: false // 是否显示图标
                },
                check: {
                    enable: true, // 是否显示选择框控件
                    chkStyle: 'checkbox' // 选择选框 checkbox 或 radio
                },
                data: {
                    key: {
                        name: 'name' // 节点名称字段
                    },
                    simpleData: {
                        enable: true, // 是否使用简单数据模式
                        idKey: 'id', // 节点id字段
                        pIdKey: 'pid', // 节点父id字段
                        rootPId: 0 // 根节点默认值
                    }
                },

                // 回调事件
                callback: {}
            },

            // 节点数据 异步加载时不需要
            zNodes: null
        };

        // 替换默认配置参数
        $.extend({obj: option});
        var opt = $.extend(true, defaults, $.obj);

        // 加载数据
        return $.fn.zTree.init(opt.container, opt.setting, opt.zNodes);

        //console.log(checkedNodeId);
        //return checkedNodeId;
    }
};

var admin = new BaseApp();