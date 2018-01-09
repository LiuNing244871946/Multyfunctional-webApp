<?php
namespace Home\Controller;
use Think\Controller;
class TjiController extends Controller {
	  // 经营数据
    public function sji(){
    	$fid = $_POST['fid'];
        // $_POST['type'] = 1;
        $tji = D('tji');
        $time = date("Ymd",time());
        switch ($_POST['type']) {
            case 1:
                $row = $tji->where("fid = {$fid} AND time = {$time}")->find();
                break;
            case 2:
                $row = $tji->field("SUM(yingye) yingye,SUM(fangwen) fangwen,SUM(youxiao) youxiao,SUM(wuxiao) wuxiao")->where("fid = {$fid} AND {$time}-time<7")->find();
                break;
            case 3:
                $row = $tji->field("SUM(yingye) yingye,SUM(fangwen) fangwen,SUM(youxiao) youxiao,SUM(wuxiao) wuxiao")->where("fid = {$fid}")->find();
                break;
        }
        // dump($row);
        echo json_encode($row);
    }
  
    // 外卖订单
    public function new_mai(){
        $id;// = $_POST['id'] = 1;
        $type;// = $_POST['type'] = 1;

        $Model = D();
        //$s_ddan = D('s_ddan');
        $ddshop = D('ddshop');
        $row = $Model->query("select d.*,s.linkman,s.address,s.phone from s_ddan d,shdz s where d.sid = s.id and d.sjid = {$id} and d.ztai = {$type} order by time desc");
        foreach ($row as $k => $v) {
            $row[$k]['time_m'] = date("m/d",$v['time']);
            $row[$k]['time_n'] = date("H:i",$v['time']);
            $row[$k]['count'] = $ddshop->where("ddid=".$v['did'])->count();
        }
        // dump($row);
        echo json_encode($row);
    }

    // 查看商品
    public function show_food(){
        $id = $_POST['id'];  //用户订单id
        $ddan = D('ddan');
        $Model = D();
        $row = $Model->query("select d.*,f.cainame,f.price from ddshop d,food f where d.sid = f.id and d.ddid = {$id}");
        $row['bz'] = $ddan->where("id=".$id)->find()['zhu'];
        // dump($row);
        echo json_encode($row);
    }

    // 外卖店家接单
    public function jie_mai(){
        $id = $_POST['id'] = 1;  //这个订单id
        $s_ddan = D("s_ddan");
        $date['id'] = $id;
        $date['ztai'] = 9;
        
        $tt = date("Y-m-d");
        $start = (strtotime($tt));
        $stop = (strtotime($tt)+(3600*24));
        $count = $s_ddan->where("sjid = {$id} and hao!=0 and time>{$start} and time<{$stop}")->count()+1;
        $date['hao'] = $count;

        $row = $s_ddan->save($date);
        if($row) echo 1;
        else echo 2;
    }

    //取消订单
    public function qu_mai(){
        $id = $_POST['id'];  //这个订单id
        $s_ddan = D("s_ddan");
        $date['id'] = $id;
        $date['ztai'] = 5;
        $row = $s_ddan->save($date);
        if($row) echo 1;
        else echo 2;
    }

    // 外卖店铺评价信息
    public function pjia(){
        $id = $_POST['id'] = 1;  //店铺id
        $_POST['type'] = 2;
        $num = $_POST['num'] = 0;
        // $_POST['mai'] = 1;

        $q_model = D();
        
        $q_pjpic = D('pjpic');
        
        /*if($_POST['mai']==1){
          $mai = "AND d.mai = 1";
        }else{
          $mai = "AND d.mai = 2";
        }*/
        if($_POST['type']==1){
          $xin = "ORDER BY p.dj desc";
        }
        if($_POST['type']==2){
          $xin = "ORDER BY p.ptime desc";
        }
        if($_POST['type']==3){
          $tu = "AND p.pics = 2";
        } 
        $pl = $q_model->query("select p.*,u.username from pj p,users u,ddan d where p.did = d.id and d.sid = {$id} and p.uid = u.id and d.ztai = 4 AND d.mai = 1 {$tu} {$xin} limit {$num},6");
        
        
        foreach ($pl as $k => $v) {
          $pl[$k]['ptime'] = date("Y-m-d H:i",$v['ptime']);
          
          //dump($name_row);
            if($v['pics']==2){ //有图片
              $q_pics = $q_pjpic->where("pjid=".$v['id'])->select();
              $pl[$k]['pic']=$q_pics;
            }
        }
        
        dump($pl);
        // echo json_encode($pl);
    }


    //  外卖同意退款
    public function tui(){
        $id = 1;
        $s_ddan = D('s_ddan');
        $data['id'] = $id;
        $data['ztai'] = 7;
        $row = $s_ddan->save($data);
        if($row) echo 1;
        else echo 2;
        // $row = $s_ddan
    }


    //  外卖不同意退款
    public function btui(){
        $id = 1;
        $s_ddan = D('s_ddan');
        $data['id'] = $id;
        $data['ztai'] = 8;
        $data['why'] = $why;
        $row = $s_ddan->save($data);
        if($row) echo 1;
        else echo 2;
        // $row = $s_ddan
    }


    


    //  堂食同意退款
    public function t_tui(){
        $id = 1;
        $s_ddan = D('t_ddan');
        $data['id'] = $id;
        $data['ztai'] = 4;
        $row = $s_ddan->save($data);
        if($row) echo 1;
        else echo 2;
        // $row = $s_ddan
    }


    //  堂食不同意退款
    public function t_btui(){
        $id = 1;
        $s_ddan = D('t_ddan');
        $data['id'] = $id;
        $data['ztai'] = 5;
        $data['why'] = $why;
        $row = $s_ddan->save($data);
        if($row) echo 1;
        else echo 2;
        // $row = $s_ddan
    }


    // 扫描二维码  使用二维码
    public function sao(){
        $_SESSION['sid'] = 11; //店铺id
        $_GET['ma'] = 94104003;  //8位二维码号


        $ma = $_GET['ma'];
        $sid = $_SESSION['sid'];

        $q_mama = D('mama');
        $q_ddan = D('ddan');
        $t_ddan = D('t_ddan');
        $row = $q_mama->where("ma = {$ma}")->find();
        $arow = $q_ddan->where("id={$row['ddid']}")->find();

        if($sid == $arow['sid']){
            $data['id'] = $arow['id'];
            $data['ztai'] = 3;
            $aa = $q_ddan->save($data);
            $dd['ztai'] = 2;
            $gg = $t_ddan->where("did={$arow['id']}")->save($dd);

            if($aa && $gg) echo 1;
            else echo 2;
        }else{
            echo  3;
        }
    }


    
}
