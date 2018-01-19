<?php
namespace Htai\Controller;
use Think\Controller;
class FtypeController extends CommonController {
    public function index(){
    	
    	$map = array();
    	if(isset($_GET['search'])){
    		$map['name'] = array('like',"%{$_GET['search']}%");
    	}
		//$map = array();
    	$m = D('ftype');
        $f = D('food');
        
       
   		$count = $m->where($map)->count();
    	//$page=new page(3,$count);
    	$Page = new \Think\Page($count,I('get.pnum',10));
    	$row = $m->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

     
    	$show = $Page->show();
		
        $this->assign('row',$row);
        $this->assign('show',$show);
        $this->display();
    }
     

   

}