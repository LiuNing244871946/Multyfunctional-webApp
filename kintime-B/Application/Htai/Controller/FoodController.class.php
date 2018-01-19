<?php
namespace Htai\Controller;
use Think\Controller;
class FoodController extends CommonController {
    public function index(){
    	
    	$map = array();
    	if(isset($_GET['search'])){
    		$map['cainame'] = array('like',"%{$_GET['search']}%");
    	}
		//$map = array();
    	$m = D('food');
        $s = D('shop');
        $f =D('ftype');
         $z =D('stype');
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
            if($v['rx']==1){
                 $row[$k]['rx']='是热销';
            }elseif($v['rx']==2){
               $row[$k]['rx']='不是热销'; 
            }
             if($v['wmstate']== 1){
                $row[$k]['wmstate']='可以外卖';
            }elseif($v['wmstate']== 2){
                $row[$k]['wmstate']='不可以外卖';
            }
            //商铺名
            $st_row = $s->where('id='.$v['sid'])->select()[0];
            $row[$k]['sid'] = $st_row['name'];
            //菜品类名
            $roww =$f->where('id='.$v['typeid'])->select()[0];
             $row[$k]['typeid'] = $roww['name'];
          //种类名
              $rowww =$z->where('id='.$v['stypeid'])->select()[0];
             $row[$k]['stypeid'] = $rowww['name'];

        }
        
		
    	$show = $Page->show();
		
        $this->assign('row',$row);
        $this->assign('show',$show);
        $this->display();
    }
     
    public function add(){

        $this->display();
    }
    public function adddo(){  //-----------用来测试!!!
        //dump($_POST);
         $m = D('shop');
   if(!empty($_FILES)){
        $upload = new \Think\Upload();// 实例化上传类    
        $upload->maxSize   =     3145728 ;// 设置附件上传大小    
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
        $upload->savePath  =      './../../static/Img/'; // 设置附件上传目录  
        $upload->autoSub = false;  
        //上传文件 
        $info   =   $upload->upload();
        foreach($info as $file){   
            $_POST['headpic'] = './../../static/Img/'.$file['savename'];  //要是用就修改路径
        }
        
       dump($_POST);
        $m->add($_POST);
        //echo "<script>location.href='".U('index#about')."'</script>";
        echo "<script>alert('添加成功!');location.href='".U('index')."'</script>";
    }
 }

   
     public function edit(){
        $m = D('food');
      
        if(IS_GET){
           //$id = isset($_GET['id'])?$_GET['id']:'';
           // echo $id;
          
            $row = $m->where('id='.$_GET['id'])->select()[0];
            //dump($row);
            $this->assign('row',$row);
            $this->display();
        }else{
            $m->save($_POST);
            echo "<script>alert('修改成功!');location.href='".U('index')."'</script>";
            
 
        }
      
      
 }
 public function show(){
    $m=D('food');
       $s = D('shop');
       $f=D('ftype');
     $map = array();
     $id = isset($_GET['id'])?$_GET['id']:'';
   
        if(isset($_GET['search'])){
            $map['cainame'] = array('like',"%{$_GET['search']}%");
        }

        $count = $m->where($map)->count();
        //$page=new page(3,$count);
        $Page = new \Think\Page($count,I('get.pnum',10));
     $row = $m->where($map)->where("sid=".$id)->limit($Page->firstRow.','.$Page->listRows)->select();
       foreach ($row as $k => $v){
        if($v['state']== 1){
                $row[$k]['state']='上架';
            }elseif($v['state']== 2){
                $row[$k]['state']='下架';
            }

        if($v['rx']==1){
                 $row[$k]['rx']='是热销';
            }elseif($v['rx']==2){
               $row[$k]['rx']='不是热销'; 
            }
             if($v['wmstate']== 1){
                $row[$k]['wmstate']='可以外卖';
            }elseif($v['wmstate']== 2){
                $row[$k]['wmstate']='不可以外卖';
            }
          
            $st_row = $s->where('id='.$v['sid'])->select()[0];
            $row[$k]['sid'] = $st_row['name'];

              //店铺中分类...对应的名字
            $roww =$f->where('id='.$v['typeid'])->select()[0];
             $row[$k]['typeid'] = $roww['name'];
       }

     $show = $Page->show();
    $this->assign('row',$row);
     $this->assign('show',$show);
    $this->display();

 }
 public function pic(){
        
      
        $m = D('food');
        $p =D('foodpic');
        $id = isset($_GET['id'])?$_GET['id']:'';

        $row = $p->where("fid=$id")->select();
        //dump($row);
      /* foreach ($row as $k => $v) {
            $roww =$m->where('id='.$v['fid'])->select()[0]; 
        }*/
        $this->assign('row',$row);
        $this->display();
    }
     
   public function qianggou(){
        
      
        $m = D('qianggou');
        
        $id = isset($_GET['id'])?$_GET['id']:'';

        $row = $m->where("id=$id")->select();
        //dump($row);
        foreach ($row as $k => $v){
          $time=date("Y-m-d H:i:s",$v['dztime']) ;
        }
     
        $this->assign('row',$row); 
        $this->assign('time',$time);
        $this->display();
    }
     public function guige(){
        
      
        $m = D('ggetype');
        
        $id = isset($_GET['id'])?$_GET['id']:'';
      
        $row = $m->where("fid=$id and pid=0")->select();
        //dump($row);
       foreach ($row as $k => $v){
          $gid=$v['id'];
        }
       /* $roww=$m->where("pid=$row['id']")->select();
        dump($roww);*/
        $this->assign('row',$row);
       // $this->assign('time',$time);
        $this->display();
    }

}