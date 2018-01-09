<?php
namespace Home\Controller;
use Think\Controller;
class WmleftController extends Controller { //外卖商品页面左侧分类
    public function index(){
        $m = D('ftype');
            $f= D('food');
            $z =D('stype'); 
        $arr=json_decode(file_get_contents('php://input'));
        $id=$arr->id;  //外卖店的id
       
        $id=1;  //测试数据
       
      if(isset($id)){
            $row = $m->where("sid = $id")->select();//查询传过来id的店铺里自家的得分类
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
