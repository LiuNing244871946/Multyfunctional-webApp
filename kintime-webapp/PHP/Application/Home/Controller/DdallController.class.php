<?php
namespace Home\Controller;
use Think\Controller;
class DdallController extends Controller { //当前用户今天所有的订单
    public function index(){  
          
        $m = D();
        $ddshop=D('ddshop');

        $arr=json_decode(file_get_contents('php://input'));
        $id=usersId();//cook下的id
       //$id=27;
       
        
          $b=mktime(0,0,0,date('m'),date('d'),date('Y'));//当前开始时间
         $e=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;// 当前结束时间
        $row=$m->query("select * from ddan where uid={$id} and time Between {$b} and {$e} ");
       // $row[$k]['time']=date("Y-m-d H:i:s",$row[$k]['time']);
       
        foreach($row as $k=>$v){
          // $row[$k]['pipiqi'] = 123;
             $row[$k]['time']=date("Y-m-d H:i:s",$row[$k]['time']);
              if($v['mai']==1){//外卖
                $roww=$m->query("select name,headpic from m_shop where id={$v['sid']} ")[0];
               
              }elseif($v['mai']==2){//堂食
                $roww=$m->query("select name,headpic from shop where id={$v['sid']} ")[0];
              }elseif($v['mai']==3){//购物
                 $roww=$m->query("select name,headpic from g_shop where id={$v['sid']} ")[0];
              }//---------------其他待开发
               // dump($roww);
               $row[$k]['name'] = $roww['name'];
               $row[$k]['headpic'] = $roww['headpic'];
               $rowww=$ddshop->query("select name,ddid,count(*) num from ddshop where ddid={$v['id']} group by ddid")[0];
               $row[$k]['num'] = $rowww['num'];
               $row[$k]['cainame'] = $rowww['name'];
               // dump($rowww);
              $w_roww[]=$m->query("select ztai,id from s_ddan where did={$v['id']} ")[0];
                    foreach($w_roww as $k=>$v){
                        if($v['ztai']== 1){
                            $row[$k]['ztai']='新订单';
                        }elseif($v['ztai']== 2){
                            $row[$k]['ztai']='骑手赶往商家';
                        }elseif($v['ztai']== 3){
                            $row[$k]['ztai']='骑手已经到达';
                        }elseif($v['ztai']== 4){
                            $row[$k]['ztai']='订单已完成';
                        }elseif($v['ztai']== 5){
                            $row[$k]['ztai']='订单已取消';
                        }elseif($v['ztai']== 6){
                            $row[$k]['ztai']='退款/售后';
                        }elseif($v['ztai']== 7){
                            $row[$k]['ztai']='同意退款';
                        }elseif($v['ztai']== 8){
                            $row[$k]['ztai']='不同意退款';
                        }elseif($v['ztai']== 9){
                            $row[$k]['ztai']='商家接单';
                        }
  
                  }
                  $qs_row=$m->query("select qs_user.phone from s_ddan,tang,qs_user where s_ddan.id=tang.did and tang.did=qs_user.id and s_ddan.id={$v['id']}")[0]; 
                   //dump($qs_row);
                  $row[$k]['phone'] = $qs_row['phone'];
            
       }
        
           
           //dump($row);
            

       echo json_encode($row);
     
        
        }
       
    }

   
