<?php
namespace Pipi\Controller;
use Think\Controller;
class WmjzController extends Controller {  //首页底部加载页
    public function index(){ 
        $m = D('pipi_stype');
        $s = D('pipi_shop');
 
        
        $arr=json_decode(file_get_contents('php://input'));
        $address=$arr->address;  //地址
       // $keyword=$arr->keyword; //关键词
       $num=$arr->num; //数量
       // $num=3;
       // $address='北京';
       /*if(isset($address)){
            if(isset($keyword)){       //如果存在地址并且存在关键词
                $roww=$s->query("select distinct s.name,s.* from shop as s,food as f where (f.cainame like '%{$keyword}%' or s.name like '%{$keyword}%') and s.address like '%{$address}%' and s.id=f.sid and s.state=1 and f.state=1 limit 0,6 ");
           
            }else{
                 $roww=$s->query("select * from shop where address LIKE '%{$address}%' and state=1 limit 0,6") ;
        }
    }*/
    	if(isset($address) && isset($num)){
        $row=$s->query("select * from pipi_shop where address LIKE '%{$address}%' and state=1 and wmstate=1 limit $num,6") ;
      }
         echo json_encode($row);

      //dump($row);
    }
     

       
}
     

