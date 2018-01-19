<?php
namespace Htai\Controller;
use Think\Controller;
class GwshopController extends CommonController {
    public function index(){
    	$_SESSION['uid_id'];
    	$map = array();
    	if(isset($_GET['search'])){
    		$map['name'] = array('like',"%{$_GET['search']}%");
    	}
		//$map = array();
    	$m = D('g_shop');
        $stype = D('g_type');
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

         /* if($v['wmstate']== 1){
                $row[$k]['wmstate']='可以外卖';
            }elseif($v['wmstate']== 2){
                $row[$k]['wmstate']='不可以外卖';
            }*/

            $st_row = $stype->where('id='.$v['g_typeid'])->select()[0];
            //echo $st_row['name'];
            //dump($st_row);
            $row[$k]['g_typeid'] = $st_row['name'];

        }
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
            $_POST['headpic'] =  "kintime/Uploads/".$file['savename'];
        }
        
       //dump($_POST);
        $m->add($_POST);
        //echo "<script>location.href='".U('index#about')."'</script>";
        echo "<script>alert('添加成功!');location.href='".U('index')."'</script>";
    }
 }

   
    public function edit(){
        $m = D('g_shop');
        if(IS_GET){
            $row = $m->where("id=".$_GET['id'])->select()[0];
            $this->assign('row',$row);
            $this->display();
        }else{
            $m->save($_POST);
            echo "<script>alert('您修改成功了!');location.href='".U('index')."'</script>";
        }    
    }
    public function pj_shop(){



        $this->assign('row',$row);
        $this->display();

    }

public function pic(){
        
      
        $m = D('shop');
        $p =D('g_shoppic');
        $id = isset($_GET['id'])?$_GET['id']:'';

        $row = $p->where("sid=$id")->select();
        //dump($row);
      /* foreach ($row as $k => $v) {
            $roww =$m->where('id='.$v['fid'])->select()[0]; 
        }*/
        $this->assign('row',$row);
        $this->display();
    }



}