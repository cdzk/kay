<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-31
 * @Time: 11:24
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Admin_role.php
 */

namespace app\admin\model;

use think\Model;

class Admin_role extends Model
{
    /**
     * get_query_user
     * 根据查询条件获取系统用户角色数据
     *
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_query_user()
    {
        return $this->select();
    }

    /**
     * get_single_role
     * 获取指定id的单条系统用户角色数据
     *
     * @param int $role_id 角色id
     * @return array|false|\PDOStatement|string|Model
     */
    public function get_single_role($role_id)
    {
        return $this->where('role_id', $role_id)->find();
    }

    /**
     * save_role
     * 保存系统用户角色数据到数据库 新增|更新
     *
     * @return $this|array|false|int|\think\response\Json
     */
    public function save_role()
    {
        $form = input('post.');

        $data = array(
            'role_name' => $form['role_name'],
            'role_remake' => $form['role_remake'],
            'role_status' => $form['role_status']
        );

        // 判断表单数据中是否有“主键ID”的元素存在，如果有则表示更新数据，没有则表示新增数据
        if (!array_key_exists('role_id', $form)) { // 新增数据
            return $this->data($data)->save();
        } else { // 更新数据
            $role_id = (int)$form['role_id'];
            $isExist = $this->where('role_id', $role_id)->count();

            if ($isExist) {
                return $this->where('role_id', $role_id)->update($data);
            } else {
                return array('status'=>-1, 'msg'=>'数据错误，请重试', 'result'=>'');
            }
        }
    }

    /**
     * delete_role
     * 删除角色数据
     *
     * @return int
     */
    public function delete_role()
    {
        $role_id = input('get.role_id');

        return $this->destroy($role_id);
    }

    /**
     * status_role
     * 更新角色状态
     *
     * @return $this
     */
    public function status_role()
    {
        $role_id = input('post.role_id');
        $role_status = input('post.role_status');

        return $this->where('role_id', $role_id)->update(array('role_status'=>$role_status));
    }
}