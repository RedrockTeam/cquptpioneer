<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;

class ArticleController extends BaseController {
    public function addPage(){
        $type = I('get.type');
        $typeList = M('type')->where(array('status' => 1, 'type' => 'article'))->select();
        $article = M('article');
        $count = $article->where(array('type_id' => $type))->count();
        $page = new Page($count, 20);
        $data = $article->where(array('type_id' => $type))->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('typelist', $typeList);
        $this->assign('data', $data);
        $this->assign('page', $page->show());
        $this->display();
    }

    public function editPage(){
        $type = I('get.type');
        $typeList = M('type')->where(array('status' => 1, 'type' => 'article'))->select();
        $article = M('article');
        $count = $article->where(array('type_id' => $type))->count();
        $page = new Page($count, 20);
        $data = $article->where(array('type_id' => $type))->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('typelist', $typeList);
        $this->assign('data', $data);
        $this->assign('page', $page->show());
        $this->display();
    }

    public function deletePage(){
        $type = I('get.type');
        $typeList = M('type')->where(array('status' => 1, 'type' => 'article'))->select();
        $article = M('article');
        $count = $article->where(array('type_id' => $type))->count();
        $page = new Page($count, 20);
        $data = $article->where(array('type_id' => $type))->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('typelist', $typeList);
        $this->assign('data', $data);
        $this->assign('page', $page->show());
        $this->display();
    }

    public function delete(){
        $id = I('get.id');
        M('article')->where(array('id'=>$id))->delete();
        $this->success('删除成功');
    }



}