function KayApp() {
    this.initElements();
    this.initEvents();
}

KayApp.prototype = {
    /**
     * 初始化元素
     */
    initElements: function () {

    },

    /**
     * 初始化事件
     */
    initEvents: function () {
        var self = this;
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

                if (d['code']===200) {
                    if (typeof d['data']['jumpUrl'] !== 'undefined') { // 判断是否有跳转url地址存在，有则执行跳转
                        setTimeout(function () {
                            window.location.href = d['data']['jumpUrl'];
                        }, 1000);
                    }
                }
            },
            error: function () {

            }
        });
        return false;
    },
};

var kay = new KayApp();