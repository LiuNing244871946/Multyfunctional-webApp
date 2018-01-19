<?php
namespace Eng\Controller;
use Think\Controller;
class MoreController extends Controller {  //更多商家(美食/堂食)
    public function index(){ 
        $s = D('eng_shop');

        $arr=json_decode(file_get_contents('php://input'));
       $stypeid=$arr->stypeid;
        $mid = $_COOKIE['4373433CA7C70528'];//美食店铺IDcookie
        $wid=  $_COOKIE['C057DF743DCFDA2C'];//外卖店铺IDcookie
        
        /*$mid = 12;
        $stypeid=1; */
      

        switch($stypeid){
               case 1://美食类
                  $row=$s->query("select id,stypeid,headpic,name,sming,price,ping,xl from eng_shop limit 0,6 ") ; 
                   foreach ($row as $k => $v) {
                     if($v['id'] == $mid){
                       unset($row[$k]);
                     }
                  }
                 break;
               case 11: //外卖类
                  $row=$s->query("select id,stypeid,headpic,name,sming,ping,gogo,xl from eng_m_shop limit 0,6 ") ; 
                   foreach ($row as $k => $v) {
                     if($v['id'] == $wid){
                       unset($row[$k]);
                     }
                  }
                 break;
              case 13: //购物类
                  $row=$s->query("") ; //购物店铺(开发中...)
                 break;
               }
    

       // dump($row);

echo json_encode($row);


      }

}     

  







     

