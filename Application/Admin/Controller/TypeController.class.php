<?php
namespace Admin\Controller;
use Think\Controller;
class TypeController extends BaseController {

    //增
    public function addPage() {
        $this->display();
    }

    //改
    public function editPage() {
        $data = M('type')->where(array('status'=>1))->select();
        $this->assign('list', $data);
        $this->display();
    }

    public function edit() {
        $input = I('post.');
        M('type')->where(array('id'=>$input['type_id']))->save(array('column'=>$input['type_name']));
        $this->success('成功');
    }

    //删
    public function deletePage() {
        $data = M('type')->where(array('status'=>1))->select();
        $this->assign('list', $data);
        $this->display();
    }

    public function delete() {
        $id = I('post.type_id');
        M('type')->where(array('id'=>$id))->save(array('status'=>0));
        $this->success('成功');
    }

}