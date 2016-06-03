<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {

    private $type;
    private $article;
    private $link;

    public function index(){
        $this->type = M('type');
        $this->article = M('article');
        $this->link = M('link');
        $header = $this->header();
        $articlelist = $this->articlelist();
        $recent = $this->recentArticle();
        $networkshow = $this->networkshow();
        $picshow = $this->picshow();
        $other = $this->others();
        $this->assign('articlelist', $articlelist);
        $this->assign('recent', $recent);
        $this->assign('networkshow', $networkshow);
        $this->assign('picshow', $picshow);
        $this->assign('header', $header);
        $this->assign('other', $other);
        $this->display();
    }

    private function articlelist() {
        $articleCategory = $this->type->where(array('type' => 'article', 'status' => 1))->select();
        foreach ($articleCategory as $value) {
            $articlelist[] = $this->article->where(array('type_id' => $value['id']))->order('id desc')->limit(6)->select();
        }
        return $articlelist;
    }

    private function recentAgprticle() {
        $articles = $this->article->where('type_id = 3 or type_id = 4')->order('id desc')->limit(2)->select();
        foreach ($articles as &$value) {
            $value['content'] = htmlspecialchars(mb_substr(strip_tags(htmlspecialchars_decode($value['content'])), 0, 50));
        }
        return $articles;
    }

    private function networkshow(){
        return $this->link->where(array('type_id' => 6))->order('id desc')->limit(5)->select();
    }

    private function picshow(){
        return $this->link->where(array('type_id' => 14))->order('id desc')->limit(3)->select();
    }

    private function others(){
        $data['xianjin'] = $this->link->where(array('type_id' => 9))->order('id desc')->limit(3)->select();
        $data['jingdian'] = $this->link->where(array('type_id' => 10))->order('id desc')->limit(3)->select();
        return $data;
    }
}