<?php
namespace Home\Controller;
use Think\Controller;
class MedeController extends Controller {

    //  商家登录
    public function dlu(){
        $name = "843335960";
        $pass = "123456";
        $pass = md5($pass);
        $upass = D('upass');
        $row = $upass->where("name = '{$name}' and pass = '{$pass}'")->find();
        if($row){
            echo  $row['type'];
        }else{
            echo  0;
        }
    }


    //  验证短信 
    public function maa(){
        $ma = rand(000000,999999);
        if(strlen($ma)!=6){
            $ma = str_pad($ma,6,"0",STR_PAD_LEFT);
        }


        echo $ma;
    }


     
    public function ip(){
        // $ip = $_SERVER["REMOTE_ADDR"];
        $ip = $_SERVER["REMOTE_HOST"];
        echo $ip;
    }
}
