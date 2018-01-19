<?php
namespace Home\Controller;
use Think\Controller;
class MsshopController extends Controller { //美食页面下店铺的一个店铺里面
    public function index(){
          
       
      $s=D('shop');

        $arr=json_decode(file_get_contents('php://input'));
        $id=$arr->id;          //此店铺id

       $id=1;  //测试数据
  if(isset($id)){ //店的信息+店内套餐信息
        $row=$s->query("(select name,xiaddress,ping,headpic,sming,xl from shop where id={$id}) union (select tcname,headpic,oldprice,tcprice,p_num,chinum from tc where sid={$id})"); //此店所有信息
  }
     
           
       
        //dump($row);
         
        echo json_encode($row);
       
    }

 }   
