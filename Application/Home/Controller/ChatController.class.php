<?php
namespace Home\Controller;
use Think\Controller;

class ChatController extends Controller {

    public function index(){
        $page = I('post.page', 1);
        $page = $page < 1 ? 1: $page;
        $pageSize = 15;
        $offset = $pageSize * ($page-1);
        $data = M('chat')->where(array('father_id' => 0))->order('time desc')->limit($offset, $pageSize)->select();
        foreach ($data as &$value) {
            $value['content'] = mb_substr($value['content'], 0, 30, 'utf-8');
        }
        $this->ajaxReturn(array(
            'status' => 200,
            'info'   => 'success',
            'data'   => $data
        ));
    }

    public function chat() {
        $user_id = I('post.user_id');
        $token = I('post.token');
        if(!$this->verify($user_id, $token)) {
            $this->ajaxReturn(
                array(
                    'status' => 403,
                    'info'   => '请先登录'
                )
            );
        }
        $father_id = I('post.id');
        $content = I('post.content');
        if ($father_id == 0) {
            $title = I('post.title');
        } else {
            $title = '';
        }
        $data = array(
            'title' => $title,
            'user_id' => $user_id,
            'content' => $content,
            'father_id' => $father_id,
            'time' => time()
        );
        M('chat')->add($data);

    }

    private function verify($user_id, $token) {

        return true;
    }
}