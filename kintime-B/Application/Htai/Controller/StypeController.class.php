<?php
namespace Htai\Controller;
use Think\Controller;
class StypeController extends CommonController {
    public function index(){
    	
    //搜索处理
    
        $map = array();
        if(isset($_GET['search'])){
            $map['name'] = array('like',"%{$_GET['search']}%");
        }
        //$map = array();
        $m = D('stype');
        $count = $m->where($map)->count();
        //$page=new page(3,$count);
        $Page= new \Think\Page($count,10);
        $row = $m->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        //$row=$m->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('id desc')->select();
        //$button =$p->getButton(1);
        foreach($row as $k=>$v){
            //$path=$v['path'];
            
            if(strlen($v['path'])>2){
                $row[$k]['aa']=2;
            }else{
                $row[$k]['aa']=1;
            }

        }
        //dump($path);
        
        $show = $Page->show();
        $this->assign('row',$row);
        
        $this->assign('show',$show);
        $this->display();
    }
     
    public function add(){

        $this->display();
    }
    public function adddo(){
       $m =D('stype');
      if($_POST['name']!=""){
             $m =$m->add($_POST);
             //echo $m;
           echo "<script>alert('添加成功!');location.href='".U('index')."'</script>";
       }else{
            echo "<script>alert('添加失败!');location.href='".U('add')."'</script>";
            }
    }
   public function zladd(){  
    if(isset($_GET['id'])){
        $pid=$_GET['id'];
         $m = D('stype');
            $row = $m->where("id = {$_GET['id']}")->select();
            //dump($row);
            $this->assign('pid',$_GET['id']);
            $this->assign('path',$row[0]['path']);
            $this->assign('name',$row[0]['name']);
            $this->display();
       
    }
 }
  public function zladddo(){
        //dump($_POST);
    $m =D('stype');
      if($_POST['name']!=""){
             $m =$m->add($_POST);
             //echo $m;
           echo "<script>alert('添加成功!');location.href='".U('index')."'</script>";
       }else{
            echo "<script>alert('添加失败!');location.href='".U('add')."'</script>";
            }
    }
     public function del(){
        $m = D('stype');
        $id = isset($_GET['id'])?$_GET['id']:'';
        //echo $id;
        $row =$m->where("pid=$id")->select();
          /* $m = D('goods');
        $roww =$m->where("typeid=$id")->select();*/
       //dump($roww);
            if($row){
                echo "<script>alert('请先删除子类！');location.href='".U('index')."'</script>";
            /*}elseif($roww){
                 echo "<script>alert('请先删除商品！');location.href='".U('goods/index')."'</script>";*/
            }else{
                 $m= $m->delete($id);
           echo "<script>alert('您删除成功了！');location.href='".U('index')."'</script>";
          }
    }
     public function edit(){
        /* if(isset($_GET['id'])){
        $pid=$_GET['id'];
         $m = D('type');
            $row = $m->where("id = {$_GET['id']}")->find($id);*/
            //dump($row);
       $id = isset($_GET['id'])?$_GET['id']:'';
        //echo $id;
        $m = D('stype');
        $row = $m->find($id);
        
            $this->assign('pid',$_GET['id']);
            $this->assign('path',$row['path']);
            $this->assign('name',$row['name']);
           // dump($_GET['id']);
            $this->display();
       
       
      
      /*  $row = $m->find($id);
        $this->assign('row',$row);

        $this->display();*/
 }
    public function editdo(){
        $id = isset($_GET['id'])?$_GET['id']:'';
       //echo $id;
        $m =D('stype');
        $res =$m->save($_POST);
       // dump($_POST);
        if($res){
               echo "<script>alert('您修改成功了!');location.href='".U('index')."'</script>";
            }else{
               echo "<script>alert('您修改失败了!');location.href='".U('edit')."'</script>"; 
            }
        }
        

}