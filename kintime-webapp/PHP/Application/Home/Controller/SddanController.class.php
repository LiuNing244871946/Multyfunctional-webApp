<?php
namespace Home\Controller;
use Think\Controller;
class SddanController extends Controller { //插入到堂食商家订单表
    public function index(){   
          
        $m = D('ddan');
        $m1 = D('eng_ddan');
        $m2 = D('pipi_ddan');
        $s =D('t_ddan');
        $s1 =D('eng_t_ddan');
        $s2 =D('pipi_t_ddan');
        $c = D('cc');
       $arr=json_decode(file_get_contents('php://input'));
        $id=$arr->id;  //付款成功穿过来一个用户订单id
        $ztai=$arr->ztai; //付款传过来一个"状态"(付款成功)
        $ma=$arr->ma; //传过来"二维码"

        $id=4; //测试数据
        $ztai=1; //测试数据
        $row=$m->where("id=$id")->select();
        //dump($row);
        foreach($row as $k=>$v){
          $data['uid']=$v['uid'];   //用户id
          $data['time']=$v['time']; //订单创建时间
          $data['yuan']=$v['you'];  //总价
          $data['did']=$v['id'];  //用户订单id
          $data['sjid']=$v['sid'];  //商家id

          $id=$v['id'];
         
        }
        $datb['ztai']=2;
        $data['ztai']=1; //变成1(已付款,未使用)
     if(isset($ztai)){
    //在这里写二维码跳转
    //在这里写二维码跳转
    //在这里写二维码跳转
           $roww = $s->add($data); //如果付款成功就把用户订单信息插入到商家订单表中
           $roww1 = $s1->add($data); //如果付款成功就把用户订单信息插入到商家订单表中
           $roww2 = $s2->add($data); //如果付款成功就把用户订单信息插入到商家订单表中
           $rows = $m->where($id)->save($datb);  //通过id改变用户订单表的状态为"待使用"
           $rows1 = $m1->where($id)->save($datb);  //通过id改变用户订单表的状态为"待使用"
           $rows2 = $m2->where($id)->save($datb);  //通过id改变用户订单表的状态为"待使用"
        }
       // dump($roww);
      /*
       foreach($row as $k=>$v){
        if((strtotime(date("Y-m-d H:i:s"))>= strtotime($v['stop'])) && $v['yong']==1 && $data['yuan']>=$v['tj']){
          $data['you']=$data['yuan']-$v['djin']; //优惠价
        }
       }*/
      echo json_encode($roww);

    }

 }   
