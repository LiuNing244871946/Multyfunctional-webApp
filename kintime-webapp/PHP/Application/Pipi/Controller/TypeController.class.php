<?php
namespace Pipi\Controller;
use Think\Controller;
class TypeController extends Controller {  //首页传过来一个地址
    public function index(){ 
        $m = D('pipi_m_shop');
        $s = D('pipi_shop');
        $g = D('pipi_g_shop');
 
        
        $arr=json_decode(file_get_contents('php://input'));
        $address=$arr->address;
        $keyword=$arr->keyword;
   $address='杭';
       if(isset($address)){
           /* if(isset($keyword)){       //如果存在地址并且存在关键词
                $roww=$s->query("select distinct s.name,s.* from shop as s,food as f where (f.cainame like '%{$keyword}%' or s.name like '%{$keyword}%') and s.address like '%{$address}%' and s.id=f.sid and s.state=1 and f.state=1 limit 0,6 ");
           
            }else{
                 $roww=$s->query("select * from shop where address LIKE '%{$address}%' and state=1 limit 0,6") ;
        }*/
        $row=$s->query("select * from pipi_shop where address LIKE '%{$address}%' and state=1 ") ; //堂食店铺
        $roww=$m->query("select * from pipi_m_shop where address LIKE '%{$address}%' and state=1 ") ; //外卖店铺
        $rowww=$g->query("select * from pipi_g_shop where address LIKE '%{$address}%' and state=1 ") ; //购物店铺

    }
    $arr=array($row,$roww,$rowww);
   // dump($arr);
   shuffle($arr);  //将数组打乱
   $result = array_reduce($arr, function ($result, $value) {
                  return array_merge($result, array_values($value));
                }, array());

 // $res= array_slice($result,0,1,5,6,12,14,15,16);
   foreach($result as $k=>$v){
      unset($result[$k]['phone']);
      unset($result[$k]['address']);
      unset($result[$k]['uid']);
      unset($result[$k]['hi_b']);
      unset($result[$k]['hi_o']);
      unset($result[$k]['state']);
      unset($result[$k]['jun']);
      unset($result[$k]['song']);
      unset($result[$k]['gogo']);
      unset($result[$k]['fwu']);
      unset($result[$k]['kwei']);
      unset($result[$k]['hjing']);
      unset($result[$k]['p_num']);
      unset($result[$k]['hao']);
      unset($result[$k]['sid']);
      unset($result[$k]['oldprice']);
      unset($result[$k]['begintime_h']);
      unset($result[$k]['begintime_i']);
      unset($result[$k]['overtime_h']);
      unset($result[$k]['overtime_i']);
     
   }
         dump($result);
          echo json_encode($result);
   

      
    }
     

       
    }
     

