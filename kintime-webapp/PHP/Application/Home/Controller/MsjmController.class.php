<?php
namespace Home\Controller;
use Think\Controller;
class MsjmController extends Controller { //查看卷码(美食订单详情)
    public function index(){  
         $m = D();
        $arr=json_decode(file_get_contents('php://input'));   
        $id=usersId();//cook下的id
      // $id=27;
       
        $row=$m->query("select * from t_ddan where uid={$id} and ztai=1 ");
          foreach($row as $k=>$v){
               $row[$k]['time']=date("Y-m-d H:i:s",$row[$k]['time']);//时间转换
               $roww=$m->query("select name,headpic,xiaddress,phone from shop where id={$v['sid']} ")[0];//查店名,头像,地址,电话
               $rowww=$m->query("select * from tc,tc_x where tc.id={$v['fid']} and  tc.id=tc_x.tcid")[0]; //查套餐名
               //$tcxq=$m->query("select * from tc_x where tcid={$rowww['id']}");//查套餐详情
               if($v['ztai']==1){//判断状态
                    $row[$k]['ztai']='待消费';
                }elseif($v['ztai']==6){
                    $row[$k]['ztai']='已过期';
                }

// dump($rowww);

          $row[$k]['num'] = $rowww['cainum']; //套餐里菜的数量
          $row[$k]['price'] = $rowww['caiprice']; //套餐里菜的价格
          $row[$k]['cainame'] = $rowww['cainame']; //套餐里菜的名字
          $row[$k]['tcname'] = $rowww['tcname'];//套餐名
          $row[$k]['shopname'] = $roww['name'];//店铺名
          $row[$k]['headpic'] = $roww['headpic'];//头像
          $row[$k]['phone'] = $roww['phone'];//电话
          $row[$k]['address'] = $roww['xiaddress'];//地址
          }
         
        //dump($row);


    echo json_encode($row);




}

    }

   
