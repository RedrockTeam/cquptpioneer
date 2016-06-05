<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
use Think\Upload;

class ArticleController extends BaseController {

    public function addPage(){
        $typeList = M('type')->where(array('status' => 1, 'type' => 'article'))->select();
        $this->assign('typelist', $typeList);
        $this->display();
    }

    //添加文章
    public function add(){
        $input = I('post.');
        $this->auth($input['type']);
        $article = M('article');
        if($_FILES['file']['name']){
            $upload = new Upload();
            $this->mimes = array('zip', 'ZIP', 'RAR', 'rar');
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('zip', 'ZIP', 'RAR', 'rar');// 设置附件上传类型
            $upload->rootPath  =     'Public/uploads/'; // 设置附件上传根目录
            // 上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else {// 上传成功
                    foreach ($info as $file) {
                        $path = 'http://' . $_SERVER['HTTP_HOST'] . __ROOT__ . '/' . $upload->rootPath . $file['savepath'] . $file['savename'];
                    }
                    $name = $_FILES['file']['name'];
                }
        }
        $data = array(
            'title' => $input['title'],
            'type_id' => $input['type'],
            'author' => $input['author'],
            'from'  => $input['from'],
            'file_name'  => (isset($name)||$name) ? $name : '',
            'file_path'  => (isset($path)||$path) ? $path : '',
            'content' => $input['content'],
            'time'   => $input['time'] != '' ? date('Y-m-d H:i:s', strtotime($input['time'])) : date('Y-m-d H:i:s', time())
         );
        $article->add($data);
        $this->success('成功');
    }

    //可编辑文章列表
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

    //文章编辑页面
    public function editArticle(){
        $id = I('get.id');
        $article = M('article');
        $data = $article->where(array('id' => $id))->find();
        if($data == null || $data == '') {
            $this->error('没有这篇文章');
        }
        $typeList = M('type')->where(array('status' => 1, 'type' => 'article'))->select();
        $this->assign('typelist', $typeList);
        $this->assign('data', $data);
        $this->display();
    }

    public function edit(){
        $input = I('post.');
        $this->auth($input['type']);
        $article = M('article');
        if($_FILES['file']['name']){
            $upload = new Upload();
            $this->mimes = array('zip', 'ZIP', 'RAR', 'rar');
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('zip', 'ZIP', 'RAR', 'rar');// 设置附件上传类型
            $upload->rootPath  =     'Public/uploads/'; // 设置附件上传根目录
            // 上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else {// 上传成功
                foreach ($info as $file) {
                    $path = 'http://' . $_SERVER['HTTP_HOST'] . __ROOT__ . '/' . $upload->rootPath . $file['savepath'] . $file['savename'];
                }
                $name = $_FILES['file']['name'];
            }
        }
        $data = array(
            'title' => $input['title'],
            'type_id' => $input['type'],
            'author' => $input['author'],
            'from'  => $input['from'],
            'content' => $input['content'],
            'time'   => $input['time'] != '' ? date('Y-m-d H:i:s', strtotime($input['time'])) : date('Y-m-d H:i:s', time())
        );
        if (isset($name) || $name) {
            $data['file_name'] = $name;
        }
        if (isset($path) || $path) {
            $data['file_path'] = $path;
        }
        $article->where(array('id' => $input['id']))->save($data);
        $this->success('成功');
    }

    public function delUpload() {
        $id = I('post.id');
        $article = M('article');
        $article->where(array('id' => $id))->save(array(
            'file_name' => '',
            'file_path' => ''
        ));
        $this->ajaxReturn(array(
            'status' => 200,
            'info'   => '成功'
        ));
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
        $type_id = M('article')->where(array('id'=>$id))->getField('type_id');
        $this->auth($type_id);
        M('article')->where(array('id'=>$id))->delete();
        $this->success('删除成功');
    }

    public function picUpload() {
        $upload = new Upload();
        $this->mimes = array('jpg', 'jpeg', 'JPG', 'JPEG', 'PNG', 'png');
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'jpeg', 'JPG', 'JPEG', 'PNG', 'png');// 设置附件上传类型
        $upload->rootPath  =     'Public/uploads/'; // 设置附件上传根目录
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->ajaxReturn(array(
                'status' => 403,
                'info'   => $upload->getError(),
            ));
        }else{// 上传成功
            foreach($info as $file){
                $path = 'http://'.$_SERVER['HTTP_HOST'].__ROOT__.'/'.$upload->rootPath.$file['savepath'].$file['savename'];
            }
            $this->ajaxReturn(array(
                'status' => 200,
                'info'   => '成功',
                'data'   => $path
            ));
        }
    }

}