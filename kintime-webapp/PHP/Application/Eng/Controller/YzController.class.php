<?php
namespace Eng\Controller;
use Think\Controller;
class YzController extends Controller { //去验证
    public function index(){   
          
        $m = D('eng_ddan');
        $m1 = D('ddan');
        $m2 = D('pipi_ddan');
        $s =D('eng_t_ddan');
   
       $arr=json_decode(file_get_contents('php://input'));
        $id=$arr->id;  //扫码成功发过来一个用户的订单id
        $ztai=$arr->ztai; //扫码成功发过来一个状态(提示)

        $id=4; //测试数据
        $ztai=1; //测试数据
       
       //$data['id']=$id;
       $state=3; //如果验证扫码成功就改变用户订单状态为3(待使用)
       $statea=2; //如果验证扫码成功就改变堂食商家订单状态为2(已使用)

       /* $datb['did']=$data['id'];
        $datb['ztai']=2; //如果验证扫码成功就改变堂食商家订单状态为2(已使用)*/
     if(isset($ztai)){
          /* $rowm = $m->save($data);  //通过id改变用户订单表的状态为"待使用"
           $rows = $s->save($datb);*/
           $row=$m->query("update eng_ddan,eng_t_ddan set eng_ddan.ztai = '$state', eng_t_ddan.ztai = '$statea' where eng_ddan.id = '$id' and eng_t_ddan.did = '$id'"); //同时修改表中的数据
           $row1=$m1->query("update eng_ddan,eng_t_ddan set eng_ddan.ztai = '$state', eng_t_ddan.ztai = '$statea' where eng_ddan.id = '$id' and eng_t_ddan.did = '$id'"); //同时修改表中的数据
           $row2=$m2->query("update eng_ddan,eng_t_ddan set eng_ddan.ztai = '$state', eng_t_ddan.ztai = '$statea' where eng_ddan.id = '$id' and eng_t_ddan.did = '$id'"); //同时修改表中的数据
        }
        //dump($row);
     
       json_encode($row);

    }

 }   
