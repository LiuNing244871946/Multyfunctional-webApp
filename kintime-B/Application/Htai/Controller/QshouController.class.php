<?php
namespace Htai\Controller;
use Think\Controller;
class QshouController extends CommonController {
    public function index(){  //查看骑手信息
 	$_SESSION['uid_id'];
    	 //搜索条件
        if(!empty($_GET['search'])){
            $search = $_GET['search'];
            $map = " name like '%{$search}%' OR phone like '%{$search}%' ";
        }
		
    	$m = D('qs_user');
     
   		$count = $m->where($map)->count();
    	
    	$Page = new \Think\Page($count,I('get.pnum',10));
    	$row = $m->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
       
      foreach ($row as $k => $v) {
            if($v['state']== 1){
                $row[$k]['state']='正常';
            }elseif($v['state']== 2){
                $row[$k]['state']='后台禁用';
            }elseif($v['state']== 3){
                 $row[$k]['state']='前台禁用';
            }
        }

	
	$show = $Page->show();
		
    $this->assign('row',$row);
    $this->assign('show',$show);
    $this->display();
}
     
  public function add(){  //添加和处理骑手账号
if(IS_POST){
       $m =D('qs_user');
       $_POST['pass']=md5('123456');
       $res=$m->add($_POST);
 if($res){
       echo "<script>alert('添加成功!');location.href='".U('index')."'</script>";
   }else{
        echo "<script>alert('添加失败!');location.href='".U('add')."'</script>";
        }
        
}else{
    $namea = array();
    $qs_user = D('qs_user');
    $row = $qs_user->select();
    foreach ($row as $k => $v) {
        $namea[] = $v['name'];
    }
    // dump($namea);
    $name= rand('100000000','999999999');
    while (in_array($name,$namea)) {
        $name= rand('100000000','999999999');   //账号随机数判断
    }
    $this->assign('name',$name);
    $this->display();

        }
        
    }
  
 
    public function edit(){ //修改骑手账号
        $m = D('qs_user');
        
        if(IS_GET){
            $row = $m->where("id=".$_GET['id'])->select()[0];
            $this->assign('row',$row);
            $this->display();
        }else{
          
           $roww=$m->save($_POST);   
        //dump($_POST);

           echo "<script>alert('您修改成功了!');location.href='".U('qshou/index')."'</script>";
       }
    }
 

}