<?php
namespace Htai\Controller;
use Think\Controller;
class MshopController extends CommonController {
    public function index(){
    	$_SESSION['uid_id'];
    	$map = array();
    	if(isset($_GET['search'])){
    		$map['name'] = array('like',"%{$_GET['search']}%");
    	}
		//$map = array();
    	$m = D('m_shop');
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
            //显示归属分类
            $st_row = $stype->where('id='.$v['stypeid'])->select()[0];
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
     
  
   
    public function edit(){
        $m = D('food');
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

public function pic(){//查看图片
        
        $p =D('m_shoppic');
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
  
   public function show(){  //查看此店下的菜单
    $m=D('food');
    $s = D('m_shop');
    $stype = D('stype');
    $f =D('ftype');
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
            $st_row = $stype->where('id='.$v['stypeid'])->select()[0]; //让菜的归属类显示名字
            $row[$k]['stypeid'] = $st_row['name']; 
          
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

 public function editdo(){
        $m = D('food');
        if(IS_GET){
            $row = $m->where("id=".$_GET['id'])->select()[0];
            $this->assign('row',$row);
            $this->display();
        }else{
            $m->save($_POST);
            echo "<script>alert('您修改成功了!');location.href='".U('index')."'</script>";
        }    
    }
    /*public function pj_shop(){



        $this->assign('row',$row);
        $this->display();

    }*/
     public function cc(){//查看代金券
        
      
        $m = D('cc');
      
        $id = isset($_GET['id'])?$_GET['id']:'';

        $row = $m->where("sid=$id")->select();
      $time=time();
      
       foreach ($row as $k => $v) {
        if($time > $v['stop']){
            $row[$k]['stop']='已过期';
         }else{
            $row[$k]['stop']=date("Y-m-d",$row[$k]['stop']);
         }
           
            if($v['name']==1){
                $row[$k]['name']='商家卷';
            }elseif($v['name']==2){
                $row[$k]['name']='通用卷';
            }
        } 
        //dump($row);
        $this->assign('row',$row);
        $this->display();
    }
     public function del(){ //删除店铺

      
        $f =D('m_shop');
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