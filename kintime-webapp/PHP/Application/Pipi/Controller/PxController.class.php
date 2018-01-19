<?php
namespace Pipi\Controller;
use Think\Controller;
class PxController extends Controller { //所有排序
    public function index(){
         
        $s = D('pipi_shop');
       $arr=json_decode(file_get_contents('php://input'));
        $address=$arr->address;  //地址
        $zn=$arr->zn;     //智能排序
        $znnum=$arr->znnum;   //智能排序下加载
        $hp=$arr->hp;     //好评优先
        $hpnum=$arr->hpnum;   //好评优先下加载
        $rq=$arr->rq;     //人气最高
        $rqnum=$arr->rqnum;   //人气最高下加载
        
     if(isset($zn)){//排序下的智能排序
         $row_s=$s->where("state=1")->limit(0,6)->select();
        shuffle($row_s);
          echo json_encode($row_s);
          if(isset($znnum){
              $row_a=$s->where("state=1")->limit($znnum,6)->select();
              echo json_encode($row_a);
          }
         }
       if(isset($hp)){//智能排序下的好评优先   
            $row_h=$s->query("select * from pipi_shop order by ping desc and state=1 limit 0,6");
               echo json_encode($row_h);
            if(isset($hpnum)){
               $row_b=$s->query("select * from pipi_shop order by ping desc  and state=1 limit $hpnum,6");
               echo json_encode($row_b);
            }
        }
       if(isset($rq)){//智能排序下的人气最高   
           $row_x=$s->query("select * from pipi_shop order by xiaoliang desc  and state=1 limit 0,6");
           echo json_encode($row_x);
           if(isset($hpnum)){
            $row_c=$s->query("select * from pipi_shop order by xiaoliang desc and state=1 limit $hpnum,6");
            echo json_encode($row_c);
           }
        }

     /* $row_s=$s->limit(0,6)->select();
      $row_h=$s->query("select * from shop order by ping desc limit 0,6");
      $row_x=$s->query("select * from shop order by xiaoliang desc limit 0,6");
      $row=$row_s['$row_h','$row_x'];
      dump($row);*/
         //$row['roww'] = $roww;
       //echo json_encode($row);
        /*echo json_encode($row);
        echo json_encode($roww);
        echo json_encode($row_s);
        echo json_encode($row_h);
       echo json_encode($row_x);*/
    }

 }   
