<?php
namespace Htai\Controller;
use Think\Controller;
class LunboController extends CommonController { //轮播图管理
    public function index(){
    	
        $map = array();
        if(isset($_GET['search'])){
            $map['sid'] = array('like',"%{$_GET['search']}%");
        }
        //$map = array();
        $m = D('lunbo');
       $shop=D('shop');
        $count = $m->where($map)->count();
        //$page=new page(3,$count);
        $Page = new \Think\Page($count,I('get.pnum',10));
        $row = $m->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

        $show = $Page->show();
       
        $this->assign('row',$row);
        $this->assign('show',$show);
        $this->display();
    }
     
    public function add(){
        //dump($_POST);
        if(IS_GET){
            $this->display();
        }else{
                 $m = D('lunbo');
            if(!empty($_FILES)){
                $upload = new \Think\Upload();// 实例化上传类    
                $upload->maxSize   =     3145728 ;// 设置附件上传大小    
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
                $upload->savePath  =      './../../static/Img/'; // 设置附件上传目录  
                $upload->autoSub = false;  
                //上传文件 
                $info   =   $upload->upload();
                foreach($info as $file){   
                    $_POST['pic'] =  "./../../static/Img/".$file['savename'];
                }
                
               //dump($_POST);
               
                $m->add($_POST);
                //echo "<script>location.href='".U('index#about')."'</script>";
                echo "<script>alert('添加成功!');location.href='".U('index')."'</script>";
            }

        }    
 }

   
    public function edit(){
        $m = D('lunbo');
        
        if(IS_GET){
            $row = $m->where("id=".$_GET['id'])->select()[0];
            //dump($row)
            $this->assign('row',$row);
            $this->display();
        }else{
            $res=$m->where("id=".$_POST['id'])->select()[0];
            
          unset($res['pic']); //删除原图片
          if(!empty($_FILES)){
                $upload = new \Think\Upload();// 实例化上传类    
                $upload->maxSize   =     3145728 ;// 设置附件上传大小    
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
                $upload->savePath  =      './../../static/Img/'; // 设置附件上传目录  
                $upload->autoSub = false;  
                //上传文件 
                $info   =   $upload->upload();
                foreach($info as $file){   
                    $_POST['pic'] =  "./../../static/Img/".$file['savename'];
                }
           $roww=$m->save($_POST);   
        //dump($_POST);

       
           echo "<script>alert('您修改成功了!');location.href='".U('index')."'</script>";
        }

      }

    }
    public function del(){
        $m=D('lunbo');
        $row=$m->where("id=".$_GET['id'])->delete();
        echo "<script>alert('删除成功!');location.href='".U('index')."'</script>";
    }



}





