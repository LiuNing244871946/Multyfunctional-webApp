<?php
namespace Pipi\Controller;
use Think\Controller;
class  QcController extends Controller { //"全城"下拉列表--------!!!!!!!!!未改
    public function index(){
      $s=D('pipi_pipi_shop');
      $z =D('pipi_pipi_stype');
      $arr=json_decode(file_get_contents('php://input'));
      $address=$arr->address;  //地址
      $num=$arr->num;   //加载数字
     /*$num=3;
    $address='北京';*/  //测试数据
   if(isset($address)){
        $row=$s->query("select * from pipi_shop where address LIKE '%{$address}%' and state=1 limit 0,6") ;   
   }
   if(isset($num)){
        $roww=$s->query("select * from pipi_shop where address LIKE '%{$address}%' and state=1 limit $num,6") ; 
           
        }
       
        $arr['1']=$row;
        $arr['2']=$roww;
        echo json_encode($arr);
        //dump($arr);
    }

 }   
