<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $type = M('type');
        $articleCategory = $type->where(array('type' => 'article', 'status' => 1))->select();
        $article = M('article');
        foreach ($articleCategory as $value) {
            $articlelist[] = $article->where(array('type_id' => $value['id']))->order('id desc')->limit(6)->select();
        }
        
        $this->assign('articlelist', $articlelist);
        $this->display();
    }
}