<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-17
 * @Time: 15:57
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Index.php
 */
namespace app\admin\controller;

class Index extends Init {
    public function index()
    {
        return $this->fetch('./index');
    }
}