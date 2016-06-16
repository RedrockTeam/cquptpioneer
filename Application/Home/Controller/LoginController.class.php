<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;

class LoginController extends BaseController {

    public function login() {
        $idcard = I('post.idcard');
        $password = I('post.password');
        if ($idcard == '' || $password == '') {
            $this->ajaxReturn(array(
                'status' => 403,
                'info'   => '用户名/密码不能为空'
            ));
        }
        $password = sha1($password);
        $users = M('users');
        $data = $users->where(array('idcard' => $idcard, 'password' => $password))->find();
        if ($data == '' || $data == null) {
            $this->ajaxReturn(array(
                'status' => 403,
                'info'   => '用户名/密码错误'
            ));
        }
        if($data['password'] == sha1($idcard)) {
            $changed = 0;
        } else {
            $changed = 1;
        }
        $token = md5($data['id'].time());
        $users->where(array('id' => $data['id']))->save(array(
            'token' => $token
        ));
        $this->ajaxReturn($this->ajaxReturn(
            array(
                'status' => 200,
                'info'   => '成功',
                'data'   => array(
                    'user_id' => $data['id'],
                    'name' => $data['name'],
                    'token'   => $token,
                    'changed' => $changed //0未修改密码1已修改密码
                )
            )
        ));
    }

    public function changepassword() {
        $id = I('post.user_id');
        $oldpassword = sha1(I('post.oldpassword'));
        $newpassword = sha1(I('post.newpassword'));
        $token = I('post.token');
        if (!$id || !$oldpassword || !$newpassword || !$token) {
            $this->ajaxReturn(
                array(
                    'status' => 403,
                    'info'   => '参数错误'
                )
            );
        }
        $users= M('users');
        $data = $users->where(array('id' => $id, 'token' => $token))->find();
        if($token != $data['token']) {
            $this->ajaxReturn(
                array(
                    'status' => 403,
                    'info'   => '请先登录'
                )
            );
        }
        if ($data['password'] != $oldpassword) {
            $this->ajaxReturn(
                array(
                    'status' => 403,
                    'info'   => '旧密码错误'
                )
            );
        }
        if ($data['password'] == $newpassword) {
            $this->ajaxReturn(
                array(
                    'status' => 403, 
                    'info'   => '新密码与原密码相同'
                )
            );
        }
        $users->where(array('id' => $id))->save(array('password' => $newpassword));
        $this->ajaxReturn(
            array(
                'status' => 200,
                'info'   => 'success'
            )
        );
    }

}
