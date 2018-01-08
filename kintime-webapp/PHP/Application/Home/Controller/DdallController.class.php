<?php
namespace Home\Controller;
use Think\Controller;
class DdallController extends Controller { //当前用户今天所有的订单
    public function index(){  
          
        $m = D('ddan');
       

        $arr=json_decode(file_get_contents('php://input'));
        $id=usersId();//cook下的id
        //$id=27;
       
        
          $b=mktime(0,0,0,date('m'),date('d'),date('Y'));//当前开始时间
         $e=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;// 当前结束时间
        $row=$m->query("select * from ddan where uid={$id} and time Between {$b} and {$e} ");

        
      //dump($row);
 
        echo json_encode($row);
       
    }

 }   
