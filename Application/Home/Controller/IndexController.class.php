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
            $articlelist[] = $this->article->where(array('type_id' => $value['id']))->order('time desc')->limit(6)->select();
        }
        return $articlelist;
    }

    private function recentArticle() {
        $articles = $this->article->where('type_id = 3 or type_id = 4')->order('id desc')->limit(2)->select();
        foreach ($articles as &$value) {
            $value['content'] = mb_substr(strip_tags(htmlspecialchars_decode($value['content'])), 0, 50, 'utf-8');
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


    //给app的文章列表接口
    public function mobilearticlelist() {
        $type_id = I('post.id');
        $page = I('post.page', 1);
        $page = $page < 1 ? 1: $page;
        $pageSize = 15;
        $offset = $pageSize * ($page-1);
        $data = M('article')->where(array('type_id' => $type_id))->limit($offset, $pageSize)->field('id, title, content, time')->order('time desc')->select();
        foreach ($data as &$value) {
            $value['content'] = mb_substr(str_replace('&nbsp;', '', strip_tags(htmlspecialchars_decode($value['content']))), 0, 50, 'utf-8');
        }
        $this->ajaxReturn(array(
            'status' => 200,
            'info'   => 'success',
            'data'   => $data
        ));
    }

    //轮播图
    public function mobilepic() {
        $data = M('link')->where(array('type_id' => 14))->order('id desc')->limit(3)->field('name as title, link, img as imgurl')->select();;
        foreach ($data as &$value) {
            $value['imgurl'] = trim($value['imgurl']);
            $value['link'] = trim($value['link']);
        }
        $this->ajaxReturn(array(
            'status' => 200,
            'info'   => 'success',
            'data'   => $data
        ));
    }
}