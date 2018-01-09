<?php
namespace Home\Controller;
use Think\Controller;
class MseditController extends Controller { //外卖商品页面的商品
    public function index(){
       
            $f= D('tc');
            
        $arr=json_decode(file_get_contents('php://input'));
         $data['id']=$arr->id;  //外卖店商品id
        $data["tcname"]=$arr->cainame; //菜名
        $data["stock"]=$arr->stock;   //库存
        $data["tcprice"]=$arr->price; //价格

        
         $data['id']=1;
         $data["tcname"] = "乐享2-3人餐"; //测试数据
         $data["stock"] =20; //测试数据
         $data["tcprice"] =100; //测试数据
      $row=$f->save($data);
           
      /*//php获取本月起始时间戳和结束时间戳
        $thismonth_start=mktime(0,0,0,date('m'),1,date('Y'));
        $thismonth_end=mktime(23,59,59,date('m'),date('t'),date('Y'));
        $start=date('Y-m-d H:i:s',$thismonth_start); 
        $end=date('Y-m-d H:i:s',$thismonth_end); 
        echo  $end;
    $roww=$f->query("select count('m_xl') as nums,id from food where time between $start and $end group by cainame");*/
       dump($row);
         //$row['roww'] = $roww;
        echo json_encode($row);
    }

 }   
