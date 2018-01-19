<?php
namespace Htai\Controller;
use Think\Controller;
class TehuiController extends CommonController { //特惠
    public function index(){
    	$_SESSION['uid_id'];
        $map = array();
        if(isset($_GET['search'])){
            $map['sid'] = array('like',"%{$_GET['search']}%");
        }
        //$map = array();
        $m = D('tehui');
       $shop=D('shop');
        $count = $m->where($map)->count();
        //$page=new page(3,$count);
        $Page = new \Think\Page($count,I('get.pnum',10));
        $row = $m->order('id desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

        foreach ($row as $k => $v) {
            if($v['state']== 1){
                $row[$k]['state']='上架';
            }elseif($v['state']== 2){
                $row[$k]['state']='下架';
            }
            if($v['type']==1){
                 $row[$k]['type']='首页特惠';
            }elseif($v['type']== 2){
                $row[$k]['type']='其他页特惠';//-----------------------!!!没有写完继续写!!!!!!!!
            }
             $row[$k]['overtime']=date("Y-m-d H:i:s",$row[$k]['overtime']);
             //替换sid为店铺名字
            $st_row = $shop->where('id='.$v['sid'])->select()[0];
            $row[$k]['sid'] = $st_row['name'];
        }
        $show = $Page->show();
       
        $this->assign('row',$row);
        $this->assign('show',$show);
        $this->display();
    }
     
    public function add(){
        $s=D('shop');
     $res =$s->select();
     // dump($res); 
     $this->assign('res',$res); 
        $this->display();
    }
    public function adddo(){
        //dump($_POST);
         $m = D('tehui');
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
        $_POST['overtime']=strtotime($_POST['overtime']);
        $m->add($_POST);
        //echo "<script>location.href='".U('index#about')."'</script>";
        echo "<script>alert('添加成功!');location.href='".U('index')."'</script>";
    }
 }

   
    public function edit(){
        $m = D('tehui');
        
        if(IS_GET){
            $row = $m->where("id=".$_GET['id'])->select()[0];
            //dump($row);
          
                 $row['overtime']=date("Y-m-d H:i:s",$row['overtime']);
            
            $this->assign('row',$row);
            $this->display();
        }else{
           $_POST['overtime']=strtotime($_POST['overtime']);
           $roww=$m->save($_POST);   
        //dump($_POST);

       
           echo "<script>alert('您修改成功了!');location.href='".U('index')."'</script>";
       }
    }

      public function del(){ //删除特惠店铺

      
        $f =D('tehui');
        $id = isset($_GET['id'])?$_GET['id']:'';

        $row = $f->where("id=$id")->delete();
        //dump($row);
       if($row){
             echo "<script>alert('删除成功!');location.href='".U('index')."'</script>";
       }else{
            echo "<script>alert('删除失败!');location.href='".U('index')."'</script>";
       }
        $this->display();
    }
}