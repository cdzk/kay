<?php
/**
 * Created by PhpStorm.
 *
 * @Date: 2017-05-25
 * @Time: 14:47
 * @Author: cdkay
 * @Email: network@iyuanma.net
 *
 * @File： Admin_user.php
 */

namespace app\admin\model;

use library\PasswordHash;
use think\Loader;
use think\Model;

class Admin_user extends Model {

    private $encryptPassword;
    public function initialize()
    {
        // 加载验证器
        $this->validate = Loader::validate('AdminUser');

        // 实例化phpass类
        $this->encryptPassword = new PasswordHash(8, false);

        parent::initialize();
    }

    /**
     * get_query_user
     * 根据查询条件获取系统用户数据
     *
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_query_user()
    {
        $this->alias('a');
        $this->join('admin_role b', 'a.user_roleid=b.role_id', 'LEFT');
        return $this->select();
    }

    /**
     * get_single_user
     * 获取指定id的单条系统用户数据
     *
     * @param int $user_id 用户id
     * @return array|false|\PDOStatement|string|Model
     */
    public function get_single_user($user_id)
    {
        return $this->where('user_id', $user_id)->find();
    }

    /**
     * repeat_user
     * 系统用户(用户名)是否重复查询
     *
     * @return int|string
     */
    public function repeat_user()
    {
        $form = input('post.');

        return $this->where('user_name', $form['param'])->count();
    }

    /**
     * save_user
     * 保存系统用户数据到数据库 新增|更新
     *
     * @return $this|array|false|int|\think\response\Json
     */
    public function save_user()
    {
        $form = input('post.');

        $data = array(
            'user_roleid' => $form['user_roleid'],
            'user_realname' => $form['user_realname'],
            'user_email' => $form['user_email'],
            'user_mobile' => $form['user_mobile'],
            'user_status' => $form['user_status'],
            'user_addtime' => time()
        );

        // 判断表单数据中是否有“主键ID”的元素存在，如果有则表示更新数据，没有则表示新增数据
        if (!array_key_exists('user_id', $form)) { // 新增数据
            $data['user_name'] = $form['user_name'];
            $data['user_password'] = $this->encryptPassword->HashPassword($form['user_password']);

            // 新增数据验证表单
            if(!$this->validate->scene('add')->check($form)) return array('status'=>-1, 'msg'=>$this->validate->getError(), 'result'=>'');

            return $this->data($data)->save();
        } else { // 更新数据
            // 有密码表单数据时才提交密码字段
            if (!empty($form['user_password'])) $data['user_password'] = $this->encryptPassword->HashPassword($form['user_password']);

            // 更新数据验证表单
            if(!$this->validate->scene('edit')->check($form)) return array('status'=>-1, 'msg'=>$this->validate->getError(), 'result'=>'');

            $user_id = (int)$form['user_id'];
            $isExist = $this->where('user_id', $user_id)->count();
            if ($isExist) {
                return $this->where('user_id', $user_id)->update($data);
            } else {
                return array('status'=>-1, 'msg'=>'数据错误，请重试', 'result'=>'');
            }
        }
    }

    /**
     * delete_user
     * 删除用户数据
     *
     * @return int
     */
    public function delete_user()
    {
        $user_id = input('get.user_id');

        return $this->destroy($user_id);
    }

    /**
     * status_user
     * 更新用户状态
     *
     * @return $this
     */
    public function status_user()
    {
        $user_id = input('post.user_id');
        $user_status = input('post.user_status');

        return $this->where('user_id', $user_id)->update(array('user_status'=>$user_status));
    }
}