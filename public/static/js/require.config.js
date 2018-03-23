require.config({
    urlArgs: 'r=' + (new Date()).getTime(),
    baseUrl: '/static/js/',
    paths: {
        // 核心-------------------------------
        'jquery': 'plugins/jQuery/jquery-2.2.3.min',
        'bootstrap': '../bootstrap/js/bootstrap.min',
        'layer': 'plugins/layer/layer',

        // 扩展-------------------------------
        'validform': 'plugins/Validform/Validform_v5.3.2',
        'jquery.form': 'plugins/jQueryForm/jquery.form.min',
        'slimscroll': 'plugins/slimScroll/jquery.slimscroll.min',
        'treegrid': 'plugins/jquery-treegrid/js/jquery.treegrid',
        'treegrid.bootstrap3': 'plugins/jquery-treegrid/js/jquery.treegrid.bootstrap3',
        'select2': 'plugins/select2/select2.full.min',
        'icheck': 'plugins/icheck-1.0.2/icheck.min',
        'ztree': 'plugins/zTree/js/jquery.ztree.all.min',

        // 基础-------------------------------
        'adminLTE': '../adminLTE/js/app',
        'kay': 'kay',
        'admin': 'admin'
    },
    map: {
        '*': {
            css: 'require-css.min'
        }
    },
    shim: {
        // 核心-------------------------------
        'jquery': {
            exports: 'jquery-2.2.3.min'
        },
        'bootstrap': {
            deps: ['jquery']
        },
        'layer': {
            deps: ['jquery']
        },

        // 扩展-------------------------------
        'validform': {
            deps: ['jquery']
        },
        'jquery.form': {
            deps: ['jquery']
        },
        'slimscroll': {
            deps: ['jquery']
        },
        'treegrid': {
            deps: [
                'jquery',
                'css!plugins/jquery-treegrid/css/jquery.treegrid.css'
            ]
        },
        'treegrid.bootstrap3': {
            deps: ['jquery', 'bootstrap']
        },
        'select2': {
            deps: [
                'jquery',
                'css!plugins/select2/select2.min.css',
                'css!/static/adminLTE/css/AdminLTE.css'
            ]
        },
        'icheck': {
            deps: [
                'jquery',
                'css!plugins/icheck-1.0.2/skins/all.css'
            ]
        },
        'ztree': {
            deps: [
                'jquery',
                'css!plugins/zTree/css/zTreeStyle/zTreeStyle.css'
            ]
        },

        // 基础-------------------------------
        'adminLTE': {
            deps: ['jquery', 'bootstrap']
        },
        'kay': {
            deps: ['jquery']
        },
        'admin': {
            deps: ['jquery']
        }
    }
});

var adminScript = ['jquery', 'bootstrap', 'layer', 'slimscroll', 'adminLTE', 'kay', 'admin', 'validform'];
var layerPath = function () {
    layer.config({
        path: '/static/common/plugins/layer/'
    });
}