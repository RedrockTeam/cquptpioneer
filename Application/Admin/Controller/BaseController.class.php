<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {

    public function _initialize(){
        if (!session('username') || !session('uid')){
            session(null);
            $this->error('请先登录', U('Login/index'));
        }
    }

    protected function auth($type){
        $uid = session('uid');
        $num = M('admin_type')->where(array(
                    'admin_id' => $uid,
                    'node_id'  => $type
                ))->count();
        if($num < 1){
            $this->error('暂无此模块权限, 请联系管理员');
        }
    }
}