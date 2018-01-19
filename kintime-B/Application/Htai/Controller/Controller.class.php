<?php
namespace Htai\Controller;
use Think\Controller;
class UpassController extends CommonController {
    public function upassshow(){  //查看商家账号
    	$_SESSION['uid_id'];
    	 //搜索条件
        if(!empty($_GET['search'])){
            $search = $_GET['search'];
            $map = " username like '%{$search}%' OR phone like '%{$search}%' ";
        }
		//$map = array();
    	$m = D('upass');
        $s = D('shop');
   		$count = $m->where($map)->count();
    	//$page=new page(3,$count);
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
            //$m=md5($v['pass']); 

           /* //让sid换成店铺名字
            $st_row = $s->where('id='.$v['sid'])->select()[0];
            $row[$k]['sid'] = $st_row['name'];*/

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
     
  public function add(){  //添加和处理商家账号
if(IS_POST){
       $m =D('upass');
       $_POST['pass']=md5('123456');
       $res=$m->add($_POST);
 if($res){
       echo "<script>alert('添加成功!');location.href='".U('upassshow')."'</script>";
   }else{
        echo "<script>alert('添加失败!');location.href='".U('add')."'</script>";
        }
        
}else{
    $namea = array();
    $upass = D('upass');
    $row = $upass->select();
    foreach ($row as $k => $v) {
        $namea[] = $v['name'];
    }
    // dump($namea);
    $name= rand('100000000','999999999');
    while (in_array($name,$namea)) {
        $name= rand('100000000','999999999');
    }
    $this->assign('name',$name);
    $this->display();

        }
        
    }
  
 public function shopadd(){  //添加"店铺"页面里的ajax
     if(IS_POST){
                // dump($_POST);
            if(!empty($_POST['pro'])){
                $s=D('stype');
                $id=$_POST['pro'];
                // echo $id;
                $row =$s->where("pid=$id")->select();
                echo json_encode($row);
            }else{
                //dump($_POST);
            if($_POST['type']==1){ //如果type为1就插入到"堂食店铺表"
                $shop=D('shop');
                $upass=D('upass');
                unset($_POST['type']);
                $res=$shop->add($_POST);
                $data['id'] = $_POST['uid'];
                $data['sid'] = $res;
                $upass->save($data);
            if($res){
                 echo "<script>alert('添加成功!');location.href='".U('shop/index')."'</script>";
             }else{
                 echo "<script>alert('添加失败!');location.href='".U('shopadd')."'</script>";
            }
            }elseif($_POST['type']==2){ //如果type为2就插入到"外卖店铺表"
                $m_shop=D('m_shop');
                $upass=D('upass');
                unset($_POST['type']);
                $res=$m_shop->add($_POST);
                $data['id'] = $_POST['uid'];
                $data['sid'] = $res;
                $upass->save($data);
            if($res){
                 echo "<script>alert('添加成功!');location.href='".U('mshop/index')."'</script>";
             }else{
                 echo "<script>alert('添加失败!');location.href='".U('shopadd')."'</script>";
            }
            }elseif($_POST['type']==3){ //如果type为1就插入到"购物店铺表"

            }

    }
        
}else{
    $upass=D('upass');
    $id=$_GET['id'];
   $type=$_GET['type'];

    $stype=D('stype');
    if($_GET['type']==1){ //堂食类店铺
        $res =$stype->where("id=1")->select();
    }elseif($_GET['type']==2){ //外卖类店铺
        $res =$stype->where("id=11")->select();
    }elseif($_GET['type']==3){ //购物类店铺
        $res =$stype->where("id=13")->select();
    }
    //dump($res);
    $this->assign('res',$res);
    $this->assign('id',$id);
    $this->assign('type',$type);
    $this->display();
        
    }
}
    public function edit(){ //修改堂食店铺账号
        $m = D('upass');
        
        if(IS_GET){
            $row = $m->where("id=".$_GET['id'])->select()[0];
            $this->assign('row',$row);
            $this->display();
        }else{
          
           $roww=$m->save($_POST);   
        //dump($_POST);

          $s= D('shop');
          $m =D('m_shop');
          $f =D('food');        //如果账号禁用,那么店铺随着禁用!
          $id=$_POST['id'];                     //更新个别字段的值，可以使用setField方法。
          if($_POST['state']==2){
                $res=$s->where("uid=$id")->setField('state',2); //禁用堂食店
                $res=$m->where("uid=$id")->setField('state',2); //禁用外卖店
                $res=$f->where("uid=$id")->setField('state',2); //禁用该账户下菜
           }elseif($_POST['state']==1){
                $res=$s->where("uid=$id")->setField('state',1); //正常使用堂食店
                $res=$m->where("uid=$id")->setField('state',1); //正常使用外卖店
                $res=$f->where("uid=$id")->setField('state',1); //正常使用该账户下菜
           }
           echo "<script>alert('您修改成功了!');location.href='".U('upass/upassshow')."'</script>";
       }
    }
   public function wmedit(){ //修改外卖店铺账号
        $m = D('upass');
        
        if(IS_GET){
            $row = $m->where("id=".$_GET['id'])->select()[0];
            $this->assign('row',$row);
            $this->display();
        }else{
          
           $roww=$m->save($_POST);   
        //dump($_POST);

          $s= D('m_shop');
        
          $f =D('food');        //如果账号禁用,那么店铺随着禁用!
          $id=$_POST['id'];                     //更新个别字段的值，可以使用setField方法。
          if($_POST['state']==2){
                $res=$s->where("uid=$id")->setField('state',2); //禁用堂食店
                
                $res=$f->where("uid=$id")->setField('state',2); //禁用该账户下菜
           }elseif($_POST['state']==1){
                $res=$s->where("uid=$id")->setField('state',1); //正常使用堂食店
             
                $res=$f->where("uid=$id")->setField('state',1); //正常使用该账户下菜
           }
           echo "<script>alert('您修改成功了!');location.href='".U('upass/upassshow')."'</script>";
       }
    }
public function shop(){//查看堂食店铺
        $m = D('shop');
         $stype = D('stype');
        $id = isset($_GET['id'])?$_GET['id']:'';

        $row = $m->where("uid=$id")->select();
        foreach ($row as $k => $v) {
            if($v['state']== 1){
                $row[$k]['state']='正常';
            }elseif($v['state']== 2){
                $row[$k]['state']='禁用';
            }

            $st_row = $stype->where('id='.$v['stypeid'])->select()[0];
            $row[$k]['stypeid'] = $st_row['name'];

        }
        $this->assign('row',$row);
        $this->display();
    }
    public function m_shop(){//查看外卖店铺
        $m = D('m_shop');
         $stype = D('stype');
        $id = isset($_GET['id'])?$_GET['id']:'';

        $row = $m->where("uid=$id")->select();
        foreach ($row as $k => $v) {
            if($v['state']== 1){
                $row[$k]['state']='正常';
            }elseif($v['state']== 2){
                $row[$k]['state']='禁用';
            }

            $st_row = $stype->where('id='.$v['stypeid'])->select()[0];
            $row[$k]['stypeid'] = $st_row['name'];

        }
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
    public function pic(){//查看堂食店的图片
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
     public function wmpic(){//查看外卖店的图片
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
}