<?php
namespace Htai\Controller;
use Think\Controller;
class BawangController extends CommonController { //霸王餐
    public function index(){
    	$_SESSION['uid_id'];
        $map = array();
        if(isset($_GET['search'])){
            $map['tcname'] = array('like',"%{$_GET['search']}%");
        }
        //$map = array();
        $m = D('bwc');
       
        $count = $m->where($map)->count();
        //$page=new page(3,$count);
        $Page = new \Think\Page($count,I('get.pnum',10));
        $row = $m->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

        foreach ($row as $k => $v) {
            if($v['state']== 1){
                $row[$k]['state']='正常';
            }elseif($v['state']== 2){
                $row[$k]['state']='禁用';
            }
            $row[$k]['begintime']=date("Y-m-d H:i:s",$row[$k]['begintime']);

        }
        $show = $Page->show();
       
        $this->assign('row',$row);
        $this->assign('show',$show);
        $this->display();
    }
     
    public function add(){

        $this->display();
    }
    public function adddo(){
        //dump($_POST);
         $m = D('bwc');
   if(!empty($_FILES)){
        $upload = new \Think\Upload();// 实例化上传类    
        $upload->maxSize   =     3145728 ;// 设置附件上传大小    
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
        $upload->savePath  =      './../../static/Img/'; // 设置附件上传目录  
        $upload->autoSub = false;  
        //上传文件 
        $info   =   $upload->upload();
        foreach($info as $file){   
            $_POST['headpic'] =  "./../../static/Img/".$file['savename'];
        }
        
       //dump($_POST);
        $_POST['begintime']=strtotime($_POST['begintime']);
        $m->add($_POST);
        //echo "<script>location.href='".U('index#about')."'</script>";
        echo "<script>alert('添加成功!');location.href='".U('index')."'</script>";
    }
 }

   
    public function edit(){
        $m = D('bwc');
        
        if(IS_GET){
            $row = $m->where("id=".$_GET['id'])->select()[0];
             $row['begintime']=date("Y-m-d H:i:s",$row['begintime']);
            $this->assign('row',$row);
            $this->display();
        }else{
           $row[$k]['begintime']=date("Y-m-d H:i:s",$row[$k]['begintime']);
           $roww=$m->save($_POST);   
        //dump($_POST);

           echo "<script>alert('您修改成功了!');location.href='".U('index')."'</script>";
       }
    }


}