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
}