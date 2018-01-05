<?php
namespace Home\Controller;
use Think\Controller;
class  SkeywordsController extends Controller { //店内搜索商品
    public function index(){
      $s=D('shop');
      $z =D('stype');
        $arr=json_decode(file_get_contents('php://input'));
       	$stypeid=$arr->stypeid;
       	$mid = $_COOKIE['4373433CA7C70528'];//美食店铺IDcookie
       	$wid=  $_COOKIE['C057DF743DCFDA2C'];//外卖店铺IDcookie
       	$keyword=$arr->keyword;
      	/*$id = 12;
       	$stypeid=1; 测试数据
       	$keyword='可乐';*/

       	switch($stypeid){
               case 1://美食类
                  $row=$s->query("select id,tcname,headpic,oldprice,tcprice,ping from tc where tcname like '%{$keyword}%' and sid={$mid}") ; //tc
                 break;
               case 11: //外卖类
                  $row=$s->query("select id,cainame,price,pliao,headpic,m_ping from food where cainame like '%{$keyword}%' and sid={$wid}") ; //food
                 break;
              case 13: //购物类
                  $row=$s->query("") ; //购物店铺(开发中...)
                 break;
               }
    

       //	dump($row);

echo json_encode($row);



    }

 }
  
