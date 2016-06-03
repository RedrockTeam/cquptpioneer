<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {

    public function header(){
        return M('type')->where(array('position' => 'nav', 'status'=>1))->order('`order` asc')->select();
    }
}