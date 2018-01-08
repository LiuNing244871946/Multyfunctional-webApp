<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller { //美食下分类的所有商品
    public function _initialize(){
      //15分钟删除订单
     /* $in_ddan = D('ddan');
      $in_ddshop = D('ddshop');
      $in_ddan = D('ddan');
      $in_time = time()-(3600*15);
      $in_row = $in_ddan->where('ztai=1 and time<{$in_time}')->select();
      // echo $in_time;
      foreach ($in_row as $kin => $vin) {
          $in_ddan->where("id={$vin['id']}")->delete(); 
          $in_ddshop->where("ddid={$vin['id']}")->delete(); 
      }*/
      //3天自动签收
      
    }


}