<?php
namespace Home\Controller;
use Think\Controller;
class MsddanController extends Controller { //当前用户美食订单
    public function index(){  
          
        $m = D();
        $arr=json_decode(file_get_contents('php://input'));
        $num=$arr->num;//   1待消费 2已消费  3退款/售后 4待付款(开发中...)
        $id=usersId();//cook下的id
       /*$id=27;
       $num=1;*/
       // echo $num;
       if($num==1){ //待消费
          $row=$m->query("select * from t_ddan where uid={$id} and ztai=1 or ztai=6");
            foreach($row as $k=>$v){
                $row[$k]['yxtime']=date("Y-m-d",$v['time']+(3600*24*3));//有效期至(3天)3600*24*3
               // $row[$k]['time']=date("Y-m-d H:i:s",$row[$k]['time']);//时间转换
               $roww=$m->query("select name,headpic from shop where id={$v['sid']} ")[0];//查店名和头像
               $rowww=$m->query("select tcname from tc where id={$v['fid']} ")[0]; //查套餐名
                  if($v['ztai']==1){//判断状态
                    $row[$k]['ztai']='待消费';
                    $row[$k]['ckjm']="查看卷码";
                }elseif($v['ztai']==6){
                    $row[$k]['ztai']='已过期';
                    $row[$k]['ckjm']="再来一单";
              
                }
               //echo(strtotime("+1 days"));
              $row[$k]['name'] = $roww['name'];//店名
              $row[$k]['headpic'] = $roww['headpic'];//头像
              $row[$k]['cainame'] = $rowww['tcname'];//菜名
              
              
             }
       }elseif($num==2){//已消费
            $row=$m->query("select * from t_ddan where uid={$id} and ztai=2");
            foreach($row as $k=>$v){
                //$row[$k]['yxtime']=date("Y-m-d H:i:s",$v['time']+(3600*24*3));//有效期至(3天)3600*24*3
               $row[$k]['y_time']=date("Y-m-d",$row[$k]['y_time']);//时间转换
               $roww=$m->query("select name,headpic from shop where id={$v['sid']} ")[0];//查店名和头像
               $rowww=$m->query("select tcname from tc where id={$v['fid']} ")[0]; //查套餐名
               $rowwww=$m->query("select did from pj where did={$v['id']} "); //查评价
                   //dump($rowwww);
                if($rowwww[$k]['did']==$v['id']){
                  $row[$k]['ztai']='已评价';
                }else{
                  $row[$k]['ztai']='去评价';
                }
              $row[$k]['name'] = $roww['name'];//店名
              $row[$k]['headpic'] = $roww['headpic'];//头像
              $row[$k]['cainame'] = $rowww['tcname'];//菜名
              
             }
       }elseif($num==3){//退款售后
              $row=$m->query("select * from t_ddan where uid={$id} and ztai=3");
            foreach($row as $k=>$v){
               $roww=$m->query("select name,headpic from shop where id={$v['sid']} ")[0];//查店名和头像
               $rowww=$m->query("select tcname from tc where id={$v['fid']} ")[0]; //查套餐名
                     
               
               //echo(strtotime("+1 days"));
              $row[$k]['name'] = $roww['name'];//店名
              $row[$k]['headpic'] = $roww['headpic'];//头像
              $row[$k]['cainame'] = $rowww['tcname'];//菜名
              
             }
       }
        
       //dump($row);
        
       echo json_encode($row);
     
        
        }

 

    }

   
