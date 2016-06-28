<?php
namespace Home\Controller;
use Think\Controller;
use Think\Page;

class ArticleListController extends BaseController {

    public function index(){
        $header = $this->header();
        $type_id = I('get.type_id');
        $type = M('type');
        $articleType = $type->where(array('id' => $type_id))->find();
        $count = M('article')->where(array('type_id' => $articleType['id']))->count();
        $page = new Page($count, 15);
        $data = M('article')->where(array('type_id' => $articleType['id']))->limit($page->firstRow.','.$page->listRows)->order('time desc')->select();
        $this->assign('page', $page->show());
        $this->assign('data', $data);
        $this->assign('articleType', $articleType);
        $this->assign('header', $header);
        $this->assign('type_id', $type_id);
        $this->display();
    }
}