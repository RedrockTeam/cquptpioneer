<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
    //todo 权限验证
    public function _initialize(){
        if (!session('username')){
            $this->error('请先登录', U('Login/index'));
        }
    }
}