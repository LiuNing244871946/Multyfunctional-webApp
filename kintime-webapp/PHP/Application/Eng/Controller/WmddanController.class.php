<?php
namespace Eng\Controller;
use Think\Controller;
class WmddanController extends Controller { //当前用户外卖订单
    public function index(){  
          
        $m = D();
        $arr=json_decode(file_get_contents('php://input'));
        $num=$arr->num;//   1进行中 2已完成 3退款售后 4待付款(开发中...)
        $id=usersId();//cook下的id
      /* $id=27;
       $num=3;*/
       // echo $num;
       if($num==1){ //进行中
          $row=$m->query("select * from eng_ddan where uid={$id} and ztai=2 or ztai=3");
            foreach($row as $k=>$v){
                
                $row[$k]['time']=date("Y-m-d H:i:s",$row[$k]['time']);//时间转换
               $roww=$m->query("select name,headpic from eng_m_shop where id={$v['sid']} ")[0];//查店名和头像
               $rowww=$m->query("select name,ddid,count(*) num from eng_ddshop where ddid={$v['id']} group by ddid")[0];//统计数量(外卖订单里的菜)
                  if($v['ztai']==2){//判断状态
                    $row[$k]['ztai']='骑手赶往商家';
                }elseif($v['ztai']==3){
                    $row[$k]['ztai']='骑手已到达';
                }
               
              $row[$k]['name'] = $roww['name'];//店名
              $row[$k]['headpic'] = $roww['headpic'];//头像
              $row[$k]['num'] = $rowww['num'];//数量
              $row[$k]['cainame'] = $rowww['name'];//菜名*/
            
             }
       }elseif($num==2){//已完成
            $row=$m->query("select * from eng_ddan where uid={$id} and ztai=4");
              foreach($row as $k=>$v){
                
                   $row[$k]['time']=date("Y-m-d H:i:s",$row[$k]['time']);//时间转换
                   $roww=$m->query("select name,headpic from eng_m_shop where id={$v['sid']} ")[0];//查店名和头像
                   $rowww=$m->query("select name,ddid,count(*) num from eng_ddshop where ddid={$v['id']} group by ddid")[0];//统计数量(外卖订单里的菜)
                      if($v['ztai']==4){//判断状态
                        $row[$k]['ztai']='已完成';
                    }
                   
                  $row[$k]['name'] = $roww['name'];//店名
                  $row[$k]['headpic'] = $roww['headpic'];//头像
                  $row[$k]['num'] = $rowww['num'];//数量
                  $row[$k]['cainame'] = $rowww['name'];//菜名*/
            
             }
       }elseif($num==3){//退款售后
             $row=$m->query("select * from eng_ddan where uid={$id} and ztai=6");
              foreach($row as $k=>$v){
                
                   $row[$k]['time']=date("Y-m-d H:i:s",$row[$k]['time']);//时间转换
                   $roww=$m->query("select name,headpic from eng_m_shop where id={$v['sid']} ")[0];//查店名和头像
                   $rowww=$m->query("select name,ddid,count(*) num from eng_ddshop where ddid={$v['id']} group by ddid")[0];//统计数量(外卖订单里的菜)
                      if($v['ztai']==6){//判断状态
                        $row[$k]['ztai']='退款/售后';
                    }
                   
                  $row[$k]['name'] = $roww['name'];//店名
                  $row[$k]['headpic'] = $roww['headpic'];//头像
                  $row[$k]['num'] = $rowww['num'];//数量
                  $row[$k]['cainame'] = $rowww['name'];//菜名*/
            
             }
       
       }
        
       //dump($row);
        
       echo json_encode($row);
     
        
        }
       
    }

   
