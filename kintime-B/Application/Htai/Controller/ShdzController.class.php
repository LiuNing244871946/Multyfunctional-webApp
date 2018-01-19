<?php
namespace Htai\Controller;
use Think\Controller;
class ShdzController extends CommonController {
    public function index(){
    	
    $map = array();
    	if(isset($_GET['search'])){
    		$map['linkman'] = array('like',"%{$_GET['search']}%");
    	}
		//$map = array();
    	$m = D('shdz');
        $stype = D('shdz');
   		$count = $m->where($map)->count();
    	//$page=new page(3,$count);
    	$Page = new \Think\Page($count,I('get.pnum',10));
    	$row = $m->order('id asc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

       /* foreach ($row as $k => $v) {
            if($v['state']== 1){
                $row[$k]['state']='正常';
            }elseif($v['state']== 2){
                $row[$k]['state']='禁用';
            }

            $st_row = $stype->where('id='.$v['stypeid'])->select()[0];
            //echo $st_row['name'];
            //dump($st_row);
            $row[$k]['stypeid'] = $st_row['name'];

        }*/
		//$row=$m->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('id desc')->select();
		//$button =$p->getButton(1);
    	$show = $Page->show();
		//$this->assign('button',$button);// 分页显示输出
        
        	//dump($row);
        $this->assign('row',$row);
        $this->assign('show',$show);
        $this->display();
    }
     
    public function add(){

        $this->display();
    }
    public function adddo(){
        //dump($_POST);
         $m = D('shop');
   if(!empty($_FILES)){
        $upload = new \Think\Upload();// 实例化上传类    
        $upload->maxSize   =     3145728 ;// 设置附件上传大小    
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
        $upload->savePath  =      './'; // 设置附件上传目录  
        $upload->autoSub = false;  
        //上传文件 
        $info   =   $upload->upload();
        foreach($info as $file){   
            $_POST['headpic'] = $file['savename'];
        }
        
       dump($_POST);
        $m->add($_POST);
        //echo "<script>location.href='".U('index#about')."'</script>";
        echo "<script>alert('添加成功!');location.href='".U('index')."'</script>";
    }
 }

   
     public function edit(){
        /* if(isset($_GET['id'])){
        $pid=$_GET['id'];
         $m = D('type');
            $row = $m->where("id = {$_GET['id']}")->find($id);*/
            //dump($row);
        $id = isset($_GET['id'])?$_GET['id']:'';
       // echo $id;
        $m = D('shop');
        $row = $m->find($id);
        //dump($row);
            /*$this->assign('pid',$_GET['id']);
            $this->assign('path',$row['path']);
            $this->assign('name',$row['name']);*/
           // dump($_GET['id']);

           
            $this->assign('row',$row);
            $this->display();
       
      
      /*  $row = $m->find($id);
        $this->assign('row',$row);

        $this->display();*/
 }
    public function editdo(){
          $m = D('shop');
       $old_pic=$_POST['old_pic'];
            if(!empty($_FILES)){

                $upload = new \Think\Upload();// 实例化上传类    
                $upload->maxSize   =     3145728 ;// 设置附件上传大小    
                $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
                $upload->savePath  =      './'; // 设置附件上传目录  
                $upload->autoSub = false;  

                // 上传文件     
                $info   =   $upload->upload();   
                if($info) {// 上传错误提示错误信息        
                    unlink("./Uploads/".$old_pic); 
                    $pic_name = $info['pic']['savename'];
                    $_POST['headpic']=$pic_name;
                }
                unset($_POST['old_pic']);
                $m->save($_POST);
               echo "<script>alert('您修改成功了!');location.href='".U('index')."'</script>";
            }

        }
        

}