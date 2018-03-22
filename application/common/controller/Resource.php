<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2018-03-19
 * @Time: 00:14
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Resource.php
 */
namespace app\common\controller;

use think\Controller;

class Resource extends Controller {
    const SUCCESS = 200;                // 请求成功
    const ERROR = 0;                    // 请求失败
    const ERR_DATA_INVALID = -1;        // 数据处理失败
    const ERR_REQUEST_INVALID = 400;    // 无效请求
    const ERR_FORM_INVALID = 450;       // 表单验证错误信息
    const ERR_AUTH_INVALID = 401;       // 未授权

    /**
     * getBack
     * 获取请求返回信息
     *
     * @param int $code 错误代码
     * @param string $msg 错误信息
     * @param null $data 返回数据
     * @return array
     */
    public static function getBack($code=self::SUCCESS, $msg='success', $data=null)
    {
        $result =  [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];

        // return json($result);
        return $result;
    }
}