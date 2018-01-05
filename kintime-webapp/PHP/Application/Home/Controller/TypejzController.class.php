<?php
namespace Home\Controller;
use Think\Controller;
class TypejzController extends Controller {  //首页底部加载页
    public function index(){ 
        $m = D('m_shop');
        $s = D('shop');
        $g = D('g_shop');
       
        
        $arr=json_decode(file_get_contents('php://input'));
        $address=$arr->address;  //地址
        $stypeid=$arr->stypeid; 
        $num=$arr->num; //数量
       /* $num=0;
       $address='北京';
       $stypeid=1;*/
  
           if($stypeid==0){
             $row=$s->query("(select id,stypeid,headpic,name,sming,price,ping,xl from shop where address LIKE '%{$address}%' and state=1 limit {$num},6) union (select id,stypeid,headpic,name,sming,price,ping,xl from g_shop where address LIKE '%{$address}%' and state=1 limit {$num},6 )") ; //堂食店铺
            // dump($row);
             //echo count($row,1);
           
                 for ($i=0; $i < count($row); $i++) { 
                   for ($j=$i+1; $j < count($row); $j++) { 
                     
                     if ($row[$i]['ping']<$row[$j]['ping']) {
                      $a = $row[$i];
                       $row[$i]=$row[$j];
                       $row[$j]=$a;
                     }
                   }
                 }
                   
           
           }else{
              switch($stypeid){
               case 1://美食
                  $row=$s->query("select id,stypeid,headpic,name,sming,price,ping,xl from shop where address LIKE '%{$address}%' and state=1 limit {$num},6") ; //堂食店铺
                 break;
               case 11: //外卖
                  $row=$s->query("select id,stypeid,headpic,name,sming,ping,gogo,xl from m_shop where address LIKE '%{$address}%' and state=1 limit {$num},6") ; //外卖店铺
                 break;
              case 13: //购物
                  $row=$s->query("select id,stypeid,headpic,name,sming,price,ping,xl from g_shop where address LIKE '%{$address}%' and state=1 limit {$num},6") ; //购物店铺
                 break;
               }

           }
           //dump($row);
                        echo json_encode($row);
}














}     

  







     

