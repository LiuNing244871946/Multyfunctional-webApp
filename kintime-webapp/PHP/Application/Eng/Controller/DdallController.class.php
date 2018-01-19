<?php
namespace Eng\Controller;
use Think\Controller;
class DdallController extends Controller { //当前用户今天所有的订单
    public function index(){  
          
        $m = D();
        $ddshop=D('eng_ddshop');

        $arr=json_decode(file_get_contents('php://input'));
        $id=usersId();//cook下的id
        //$id=27;
       
        
          $b=mktime(0,0,0,date('m'),date('d'),date('Y'));//当前开始时间
         $e=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;// 当前结束时间

       $aa=$m->query("select * from eng_ddan where uid={$id} and time Between {$b} and {$e}");
       $bb=$m->query("select * from eng_t_ddan where uid={$id} and time Between {$b} and {$e}");
       $cc=$m->query("select * from eng_dz_ddan where uid={$id} and time Between {$b} and {$e}");
      
       $arr=array_merge($aa,$bb,$cc);
        
        foreach($arr as $k=>$v){

          // $row[$k]['pipiqi'] = 123;
             $arr[$k]['time']=date("Y-m-d H:i:s",$arr[$k]['time']);//时间转换
              if($v['mai']==1){//外卖
               unset($arr[$k]['yuan']);
                  $roww=$m->query("select name,headpic from eng_m_shop where id={$v['sid']} ")[0];//查店名和头像
                        if($v['ztai']== 1){//判断状态
                            $arr[$k]['ztai']='新订单';
                            $rowww=$m->query("select phone from eng_m_shop where id={$v['sid']} ")[0];
                        }elseif($v['ztai']== 2){
                            $arr[$k]['ztai']='骑手赶往商家';
                            $rowww=$m->query("select phone from eng_m_shop where id={$v['sid']} ")[0];
                        }elseif($v['ztai']== 3){
                            $arr[$k]['ztai']='骑手已经到达';
                            $rowww=$m->query("select phone from eng_m_shop where id={$v['sid']} ")[0];
                        }elseif($v['ztai']== 4){
                            $arr[$k]['ztai']='订单已完成';
                            $rowww=$m->query("select phone from eng_m_shop where id={$v['sid']} ")[0];
                        }elseif($v['ztai']== 5){
                            $arr[$k]['ztai']='订单已取消';
                            $rowww=$m->query("select phone from eng_m_shop where id={$v['sid']} ")[0];
                        }elseif($v['ztai']== 6){
                            $arr[$k]['ztai']='退款/售后';
                            $rowww=$m->query("select phone from eng_m_shop where id={$v['sid']} ")[0];
                        }elseif($v['ztai']== 7){
                            $arr[$k]['ztai']='同意退款';
                            $rowww=$m->query("select phone from eng_m_shop where id={$v['sid']} ")[0];
                        }elseif($v['ztai']== 8){
                            $arr[$k]['ztai']='不同意退款';
                            $rowww=$m->query("select phone from eng_m_shop where id={$v['sid']} ")[0];
                        }elseif($v['ztai']== 9){
                            $arr[$k]['ztai']='商家接单';
                            $rowww=$m->query("select phone from eng_m_shop where id={$v['sid']} ")[0];
                        }elseif($v['ztai']== 10){
                            $arr[$k]['ztai']='骑手接单';
                            $rowww=$m->query("select phone from eng_qs_user where id={$v['qid']} ")[0];
                        }
                  $rowwww=$m->query("select name,ddid,count(*) num from eng_ddshop where ddid={$v['id']} group by ddid")[0];//统计数量(外卖订单里的菜)
              }elseif($v['mai']==2){//堂食
                 $roww=$m->query("select name,headpic from eng_shop where id={$v['sid']} ")[0];//查店名和头像
                 $rowww=$m->query("select phone from eng_shop where id={$v['sid']} ")[0]; //查电话(可与上边合并)
                 $rowwww=$m->query("select tcname name,id,count(*) num from eng_tc where id={$v['fid']} group by id")[0];//统计数量(统计堂食订单里的套餐)
                    if($v['ztai']== 1){//判断状态
                        $arr[$k]['ztai']='未使用'; 
                    }elseif($v['ztai']== 2){
                        $arr[$k]['ztai']='已验证'; 
                    }elseif($v['ztai']== 3){
                        $arr[$k]['ztai']='退款/售后';
                    }elseif($v['ztai']== 4){
                        $arr[$k]['ztai']='同意退款';
                    }elseif($v['ztai']== 5){
                        $arr[$k]['ztai']='不同意退款';
                    }
              }elseif($v['mai']==3){//电子订单
                 $roww=$m->query("select name,headpic from eng_shop where id={$v['sid']} ")[0];//查店名和头像
                 $rowww=$m->query("select phone from eng_shop where id={$v['sid']} ")[0];//查电话
                 $rowwww=$m->query("select name,dzddid,count(*) num from eng_dzddshop where dzddid={$v['id']} group by dzddid")[0];//统计数量(电子订单里的商品)
                     if($v['ztai']== 1){//判断状态
                          $arr[$k]['ztai']='已付款'; 
                      }elseif($v['ztai']== 2){
                          $arr[$k]['ztai']='正常完成'; 
                      }
              }
           $arr[$k]['name'] = $roww['name'];//店名
           $arr[$k]['headpic'] = $roww['headpic'];//头像
           $arr[$k]['phone'] = $rowww['phone'];//电话
           $arr[$k]['num'] = $rowwww['num'];//数量
           $arr[$k]['cainame'] = $rowwww['name'];//菜名*/
           }
         // dump($arr);
          
             

       echo json_encode($arr);
     
        
        }
       
    }

   
