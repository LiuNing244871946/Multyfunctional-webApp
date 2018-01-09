<?php
namespace Home\Controller;
use Think\Controller;
class WmgoodsController extends Controller { //外卖商品页面的商品
    public function index(){
       
            $f= D('food');
            $z =D('stype'); 
        $arr=json_decode(file_get_contents('php://input'));
        $fid=$arr->id;  //外卖店里分类的id
       
        $id=1;  //测试数据
       
      if(isset($id)){
            $row = $f->where("typeid = $id")->select();//查询传过来的fid的店里的商品
      }
           
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
