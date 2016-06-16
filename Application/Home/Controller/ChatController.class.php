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

    public function mobilechat() {
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
            if($title == '' || $content == '') {
                $this->ajaxReturn(
                    array(
                        'status' => 403,
                        'info' => '标题或内容不能为空'
                    )
                );
            }
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
        $this->ajaxReturn(
            array(
                'status' => 200,
                'info' => 'success'
            )
        );
    }

    public function mobilechatdetail() {
        $id = I('post.id');
        $chat = M('chat');
        $page = I('post.page', 1);
        $page = $page < 1 ? 1: $page;
        $pageSize = 15;
        $offset = $pageSize * ($page-1);
        $lz = $chat->where(array('chat.id' => $id))->join('join users on chat.user_id = users.id')->field('chat.id, chat.title, chat.content, chat.time, users.name')->find();
        $reply = $chat->where(array('chat.father_id' => $id))->join('join users on chat.user_id = users.id')->limit($offset, $pageSize)->field('chat.content, chat.time, users.name')->select();
        $this->ajaxReturn(
            array(
                'status' => 200,
                'info' => 'success',
                'data' => array(
                    'lz' => $lz,
                    'reply' => $reply
                )
            )
        );
    }

//    public function test() {
//        $data = M('teacher')->select();
//        $users = M('users');
//        foreach ($data as $value) {
//            $row = array(
//                'idcard' => $value['idcard'],
//                'name'   => $value['name'],
//                'password' => sha1($value['idcard'])
//            );
//            $users->add($row);
//        }
//        echo 'ok';
//    }

    private function verify($user_id, $token) {
//        $num = M('users')->where(array(
//                    'id' => $user_id,
//                    'token' => $token
//                ))->count();
//        if ($num == 1) {
            return true;
//        }
//        return false;
    }
}