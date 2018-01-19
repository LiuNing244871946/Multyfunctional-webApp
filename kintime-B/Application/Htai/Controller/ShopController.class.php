<?php
namespace Htai\Controller;
use Think\Controller;
class ShopController extends CommonController {
    public function index(){
    	$_SESSION['uid_id'];
    	$map = array();
    	if(isset($_GET['search'])){
    		$map['name'] = array('like',"%{$_GET['search']}%");
    	}
		//$map = array();
    	$m = D('shop');
        $stype = D('stype');
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
            }
*/
            $st_row = $stype->where('id='.$v['stypeid'])->select()[0];
            //echo $st_row['name'];
            //dump($st_row);
            $row[$k]['stypeid'] = $st_row['name'];

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
     
    /*public function add(){

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
*/
   
    public function edit(){
        $m = D('shop');
        
        if(IS_GET){
            $row = $m->where("id=".$_GET['id'])->select()[0];
            $this->assign('row',$row);
            $this->display();
        }else{
          
           $roww=$m->save($_POST);   
        //dump($_POST);

          $f= D('food');          //如果店铺禁用,那么店下的菜随着下架!
          $id=$_POST['id'];
          if($_POST['state']==2){
                $res=$f->where("sid=$id")->setField('state',2);//更新个别字段的值，可以使用setField方法。
           }elseif($_POST['state']==1){
                $res=$f->where("sid=$id")->setField('state',1);
           }
           echo "<script>alert('您修改成功了!');location.href='".U('index')."'</script>";
       }
    }

public function pic(){//查看图片
        
      
        $m = D('shop');
        $p =D('shoppic');
        $id = isset($_GET['id'])?$_GET['id']:'';

        $row = $p->where("sid=$id")->select();
        //dump($row);
      /* foreach ($row as $k => $v) {
            $roww =$m->where('id='.$v['fid'])->select()[0]; 
        }*/
        $this->assign('row',$row);
        $this->display();
    }
public function ftype(){//查看本店下菜品分类
        
      
        $m = D('shop');
        $f =D('ftype');
        $id = isset($_GET['id'])?$_GET['id']:'';

        $row = $f->where("sid=$id")->select();
        //dump($row);
        $this->assign('row',$row);
        $this->display();
    }
    public function tc(){//查看本店套餐
        
      
        $m = D('tc');
        
        $id = isset($_GET['id'])?$_GET['id']:'';

        $row = $m->where("sid=$id")->select();
        //dump($row);
        $this->assign('row',$row);
        $this->display();
    }
     public function tcx(){//查看本店套餐详情
        
      
        $m = D('tc_x');
        
        $id = isset($_GET['id'])?$_GET['id']:'';

        $row = $m->where("tcid=$id")->select();
        //dump($row);
        $this->assign('row',$row);
        $this->display();
    }
    public function wmd(){ //查看外卖店

      
        $f =D('m_shop');
        $id = isset($_GET['id'])?$_GET['id']:'';

        $row = $f->where("sid=$id")->select();
        //dump($row);
        $this->assign('row',$row);
        $this->display();
    }
    public function del(){ //删除店铺

      
        $f =D('shop');
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