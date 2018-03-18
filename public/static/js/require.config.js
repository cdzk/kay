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

        // 基础-------------------------------
        'adminLTE': '../adminLTE/js/app',
        'common': 'common',
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

        // 基础-------------------------------
        'adminLTE': {
            deps: ['jquery']
        },
        'common': {
            deps: ['jquery']
        },
        'admin': {
            deps: ['jquery']
        }
    }
});