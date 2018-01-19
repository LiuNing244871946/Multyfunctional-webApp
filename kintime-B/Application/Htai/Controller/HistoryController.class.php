<?php
namespace Htai\Controller;
use Think\Controller;
class HistoryController extends CommonController { //历史记录
    public function index(){
    	
        $map = array();
        if(isset($_GET['search'])){
            $map['nr'] = array('like',"%{$_GET['search']}%");
        }
        //$map = array();
        $m = D('history');
        $users= D('users');
        $count = $m->where($map)->count();
        //$page=new page(3,$count);
        $Page = new \Think\Page($count,I('get.pnum',10));
        $row = $m->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

        foreach ($row as $k => $v) {
             //替换用户id为用户名字
            $st_row = $users->where('id='.$v['cook_id'])->select()[0];
            $row[$k]['cook_id'] = $st_row['name'];
        }

        $show = $Page->show();
       
        $this->assign('row',$row);
        $this->assign('show',$show);
        $this->display();
    }
     
   

}