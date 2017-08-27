<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-08-26
 * @Time: 03:34
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： config.php
 */

return [
    // 缓存配置
    'cache'  => [
        'type'   => 'File',
        'path'   => CACHE_PATH,
        'prefix' => 'common_',
        'expire' => 0,
    ],

    // session 配置
    'session'                => [
        'prefix'         => 'common',
        'type'           => '',
        'auto_start'     => true,
    ],
];