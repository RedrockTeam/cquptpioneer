<?php
namespace Admin\Controller;
use Think\Controller;
class AuthController extends BaseController {

    public function index() {
        $admin = M('admin');
        $adminlist = $admin->where('id != 1')
                           ->field('id, username')
                           ->select();
        $admin_type = M('admin_type');
        foreach ($adminlist as &$value) {
            $nodelist = $admin_type->where(array('admin_id'=>$value['id']))->order('node_id asc')->field('node_id')->select();
            foreach ($nodelist as $v){
                $value['node'][$v['node_id']] = $v['node_id'];
            }
        }
        $typeList = M('type')->where(array('type' => 'article'))->select();
        $this->assign('list', $adminlist);
        $this->assign('typelist', $typeList);
        $this->display();
    }


    public function addUser(){
        $this->display();
    }

    public function add(){
        $this->auth(15);
        $input = I('post.');
        if($input['password'] != $input['repeat']) {
            $this->error('两次输入密码不一致');
        }
        $admin = M('admin');
        $num = $admin->where(array('username' => $input['username']))->count();
        if($num != 0) {
            $this->error('用户已存在');
        }
        $admin->add(array(
            'username' => $input['username'],
            'password' => hash('sha256', $input['password'])
        ));
        $this->success('添加成功, 请前往权限授予分配权限');
    }

    public function updateAuth(){
        $this->auth(15);
        $input = I('post.');
        $admin_type = M('admin_type');
        $admin_type->where(array(
            'admin_id' => $input['uid']
        ))->delete();
        foreach ($input['node_id'] as $id) {
            $admin_type->add(
                array(
                    'admin_id' => $input['uid'],
                    'node_id'  => $id
                )
            );
        }
        $this->ajaxReturn(array('status' => 200));
    }
}