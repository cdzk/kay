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
use think\Session;

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
        $this->alias('au');
        $this->join('admin_role ar', 'au.user_roleid=ar.role_id', 'LEFT');
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

    // TODO 用户登录数据处理

    /**
     * login_user
     * 管理用户登录请求数据处理
     *
     * @author zhengkai
     * @date 2017-08-27
     *
     * @return array
     */
    public function login_user()
    {
        $form = input('post.');

        // 验证图形验证码
        $getVerifyCode = Session::get('verify_code', 'common');
        if ($form['verify_code'] !== $getVerifyCode) {
            Session::delete('verify_code', 'common'); // 删除验证码session
            return array('status'=>-1, 'msg'=>'验证码不正确', 'result'=>'');
        }

        // 查询用户是否存在
        $user = $this->where('user_name', $form['user_name'])->find();
        if (!$user) return array('status'=>-1, 'msg'=>'用户名或密码不正确', 'result'=>'');

        // 验证密码
        $verifyPassword = $this->encryptPassword->CheckPassword($form['user_password'], $user['user_password']);
        if (!$verifyPassword) return array('status'=>-1, 'msg'=>'用户名或密码不正确', 'result'=>'');

        // 检查用户状态
        if (!$user['user_status']) return array('status'=>-1, 'msg'=>'该用户已被锁定，请与管理员联系', 'result'=>'');

        // 更新用户登录数据
        $user_update = [
            'user_login_last_time' => time() // 用户最后一次登录时间
        ];
        $this->where('user_id', $user['user_id'])->update($user_update);

        // 保存用户必要信息到session
        $user_data = [
            'user_id' => $user['user_id'], // 用户id
            'user_roleid' => $user['user_roleid'], // 用户角色
        ];

        Session::set('user', serialize($user_data), 'admin');

        return array('status'=>1, 'msg'=>'登录成功', 'result'=>array('jumpUrl'=>url('admin/Index/index')));
    }

    /**
     * get_login_user
     * 获取当前登录的管理用户数据（信息）
     *
     * @author zhengkai
     * @date 2017-08-27
     *
     * @param int $user_id 用户ID
     * @return array|false|\PDOStatement|string|Model
     */
    public function get_login_user($user_id)
    {
        return $this->alias('au')
            ->join('admin_role ar', 'au.user_roleid=ar.role_id', 'LEFT')
            ->where('au.user_id', $user_id)
            ->field('au.user_id, au.user_name, au.user_login_last_ip, au.user_login_last_time, ar.role_name')
            ->find();
    }
}