<?php
namespace Home\Controller;
use Think\Controller;

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

}
