<?php
namespace Eng\Controller;
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

      //3天改套餐状态 未使用变成 已过期
      $t_ddan=D('eng_t_ddan');
      $san = time()-(3600*24*3);
      $san_row = $t_ddan->where("ztai=1 and time<{$san}")->select();
      foreach ($san_row as $kk => $value) {
        $data['id']=$value['id'];
        $data['ztai']=6;
        $t_ddan->save($data);
      }






    }




}