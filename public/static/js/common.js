function GlobalApp() {
    this.initElements();
    this.initEvents();
}

GlobalApp.prototype = {
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
    }
};

var global = new GlobalApp();