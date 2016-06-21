<?php
namespace Home\Controller;
use Think\Controller;

class ArticleController extends BaseController {

    public function index(){
        $header = $this->header();
        $id = I('get.id');
        $data = M('article')->where(array('id' => $id))->find();
        $this->assign('header', $header);
        $this->assign('data', $data);
        $this->display();
    }

    public function mobilearticle(){
        $id = I('post.id');
        $data = M('article')->where(array('id' => $id))->find();
        $data['content'] = htmlspecialchars_decode($data['content']);
        if ($data['file_name']) {
            $data['file'] = array(
                array(
                    'name' => $data['file_name'],
                    'address' => $data['file_path']
                )
            );
            unset($data['file_name']);
            unset($data['file_path']);
        } else {
            unset($data['file_name']);
            unset($data['file_path']);
            $data['file'] = array();
        }
        $this->ajaxReturn(array(
            'status' => 200,
            'info'   => 'success',
            'data'   => $data
        ));
    }
}