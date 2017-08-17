<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-24
 * @Time: 15:39
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Auth.php
 */

namespace app\admin\model;

use think\Loader;
use think\Model;

class Admin_auth extends Model {
    protected function initialize()
    {
        // 加载验证器
        $this->validate = Loader::validate('AdminAuth');

        parent::initialize();
    }

    /**
     * get_all_auth
     * 获取所有权限数据，并转换为数组
     *
     * @return array
     */
    public function get_all_auth()
    {
        $auth = $this->select();

        $data = array();
        foreach ($auth as $key=>$val)
        {
            $data[$key] = $val->toArray();
        }

        return $data;
    }

    /**
     * get_single_auth
     * 获取指定id的单条权限数据
     *
     * @param int $auth_id 权限id
     * @return array|false|\PDOStatement|string|Model
     */
    public function get_single_auth($auth_id)
    {
        return $this->where('auth_id', $auth_id)->find();
    }

    /**
     * save_auth
     * 保存权限数据到数据库 新增|更新
     *
     * @return $this|array|false|int|\think\response\Json
     */
    public function save_auth()
    {
        $form = input('post.');

        // 验证表单
        if(!$this->validate->check($form)) return array('status'=>-1, 'msg'=>$this->validate->getError(), 'result'=>'');

        $data = array(
            'auth_parentid' => $form['auth_parentid'],
            'auth_name' => $form['auth_name'],
            'auth_module' => $form['auth_module'],
            'auth_controller' => $form['auth_controller'],
            'auth_action' => $form['auth_action']
        );

        // 判断表单数据中是否有“主键ID”的元素存在，如果有则表示更新数据，没有则表示新增数据
        if (!array_key_exists('auth_id', $form)) {
            // 新增数据
            return $this->data($data)->save();
        } else {
            // 更新数据
            $auth_id = (int)$form['auth_id'];
            $isExist = $this->where('auth_id', $auth_id)->count();
            if ($isExist) {
                return $this->where('auth_id', $auth_id)->update($data);
            } else {
                return array('status'=>-1, 'msg'=>'数据错误，请重试', 'result'=>'');
            }
        }
    }

    /**
     * delete_auth
     * 删除权限
     *
     * @return int
     */
    public function delete_auth()
    {
        $auth_id = input('get.auth_id');

        $isExist = $this->where('auth_parentid', $auth_id)->count();

        if ($isExist) {
            return array('status'=>-1, 'msg'=>'抱歉，请先删除子权限', 'result'=>'');
        } else {
            return $this->destroy($auth_id);
        }
    }
}