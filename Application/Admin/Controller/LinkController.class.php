<?php
namespace Admin\Controller;
use Think\Controller;
class LinkController extends BaseController {

    //add
    public function addPage(){
        $typeList = M('type')->where(array('use' => 'muilt_link', 'status' => 1))->select();
        $this->assign('typelist', $typeList);
        $this->display();
    }

    public function add(){
        $input = I('post.');
        if($input['name'] == '') {
            $this->error('名称不能为空');
        }
        $data = array(
            'type_id' => $input['type_id'],
            'name'    => $input['name']
        );
        M('link')->add($data);
        $this->success('成功');
    }

    //edit
    public function editPage() {
        $data = M('link')->join('join type on link.type_id = type.id')
                        ->field('link.name, link.link, link.img, link.id as link_id, type.column')
                        ->select();
        $this->assign('data', $data);
        $this->display();
    }

    public function edit(){
        $input = I('post.');
        M('link')->where(array('id' => $input['id']))
                ->save(array(
                    'img' => $input['img'],
                    'link' => trim($input['link'])
            ));
        $this->ajaxReturn(array('status' => 200, 'info' => '成功'));
    }
    
    public function deletePage() {
        $data = M('link')->join('join type on link.type_id = type.id')
            ->where(array('type.use'=>'muilt_link'))
            ->field('link.name, link.link, link.img, link.id as link_id, type.column')
            ->select();
        $this->assign('data', $data);
        $this->display();
    }

    public function delete() {
        $id = I('post.id');
        M('link')->where(array('id' => $id))->delete();
        $this->ajaxReturn(array('status' => 200, 'info' => '成功'));
    }
}