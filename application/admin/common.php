<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-17
 * @Time: 16:13
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： common.php
 */

if (!function_exists('randomAvatar')) {
    /**
     * randomAvatar
     * 随机头像
     *
     * @return string
     */
    function randomAvatar()
    {
        $no = rand(1, 5);
        $no = sprintf('%02s', $no);

        $avatarPath = config('path.static').'images/avatar/'.$no.'.gif';

        return $avatarPath;
    }
}