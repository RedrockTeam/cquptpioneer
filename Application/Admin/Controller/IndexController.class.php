<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index(){
        $this->display();
    }

    public function typeList(){
        $this->display();
    }
    //修改密码页面
    public function resetPassword() {
        $this->display();
    }
    //修改密码
    public function reset() {
        $input = I('post.');
        if ($input['password'] && $input['repeat'] && $input['password'] == $input['repeat']) {
            M('admin')->where(array('username' => session('username')))->save(array('password'=>hash('sha256', $input['password'])));
            $this->success('成功');
        } else {
            $this->error('两次密码不一样');
        }
    }

}