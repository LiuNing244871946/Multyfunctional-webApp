<?php
namespace Pipi\Controller;
use Think\Controller;
class TehuiController extends Controller {  //特惠美食
    public function index(){ 
        $t = D('pipi_tehui');
       
       
        
        $arr=json_decode(file_get_contents('php://input'));
        $type=$arr->type;  //特惠里面type分类 
      //$type=1; //测试数据
       //date_default_timezone_set("UTC+7");函数设置脚本中所有日期/时间函数使用的默认时区
        if($type==1){
      $row=$t->where("state=1")->select();
           foreach($row as $k=>$v){
            $row[$k]['overtime']=date("Y-m-d H:i:s",$row[$k]['overtime']);
           }
           // $row['begintime']=date("Y-m-d H:i:s",$row['begintime']);
        }   
           //dump($row);
                   echo json_encode($row);
  }


}     

  







     

