<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    private $type;
    private $article;

    public function index(){
        $this->type = M('type');
        $this->article = M('article');

        $articlelist = $this->articlelist();
        $this->assign('articlelist', $articlelist);
        $this->display();
    }

    private function articlelist() {
        $articleCategory = $this->type->where(array('type' => 'article', 'status' => 1))->select();
        foreach ($articleCategory as $value) {
            $articlelist[] = $this->article->where(array('type_id' => $value['id']))->order('id desc')->limit(6)->select();
        }
        return $articlelist;
    }
}