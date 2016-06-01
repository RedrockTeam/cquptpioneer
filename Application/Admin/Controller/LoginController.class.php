<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {

    //登录界面
    public function index(){
        if(session('username')) {
            $this->success('已登录', U('Index/index'));
        } else{
            $this->display();
        }
    }

    //登录
    public function login(){
        $input = I('post.');
        if (!$input['username'] || !$input['password']) {
            $this->error('用户名/密码不能为空');
        }
        $num = M('admin')->where(array(
            'username' => $input['username'],
            'password' => hash('sha256', $input['password'])
        ))->count();
        if($num != 1){
            $this->error('用户名或密码错误');
        }
        session('username', $input['username']);
        $this->success('成功', U('Index/index'));
    }

    
}