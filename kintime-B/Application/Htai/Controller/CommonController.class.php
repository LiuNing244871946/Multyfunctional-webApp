<?php
namespace Htai\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function _initialize(){

        if(!isset($_SESSION['uid_id'])){
        	echo "<script>alert('请先登录');location.href='".U('index/index')."'</script>";
        }
        //权限的判断 应该写在这里
        //1.当前用户所属的工作组
        $m = D('gluser');
        $burow = $m->where('id='.$_SESSION['uid_id'])->find();
        if(empty($burow)){
            echo "<script>alert('请先登录');location.href='".U('index/index')."'</script>";
        }
        $gid = $burow['glid'];
        //$gid 是当前用户所工作组 
        //2.当然工作组 都具备哪些权限
        $d = D('gx');
        $buarr = $d->where('gid='.$gid)->select();
    	$arrp = array();
    	foreach($buarr as $k => $v){
    		$arrp[] = $v['pdes'];
    	}
    	//如何能或得到 当前访问的 控制器名/方法名
    	$zy = CONTROLLER_NAME.'/'.ACTION_NAME;
        if($_SESSION['uid_id']!=1){
        	if(!in_array($zy,$arrp)){
                echo "<script>alert('没有权限');location.href='".U('index/index')."'</script>";
            }
        }
        //右上角 用户个人信息
        
        $rowmm = $m->where('id='.$_SESSION['uid_id'])->select()[0];
        $g = D('group');
        //$mmm = $g->where('id='.$mm['gid'])->select()[0];
        $this->assign('rowmm',$rowmm);
        $this->assign('mmm',$mmm);
    }
}