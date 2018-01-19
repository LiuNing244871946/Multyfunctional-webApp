<?php
namespace Pipi\Controller;
use Think\Controller;
class BwcController extends Controller {  //首页霸王餐
    public function index(){ 
        $b = D('pipi_bwc');
       
       
        
        $arr=json_decode(file_get_contents('php://input'));
       /* $address=$arr->address;  //地址
        $stypeid=$arr->stypeid; 
        $num=$arr->num; //数量*/
       //date_default_timezone_set("UTC+7");函数设置脚本中所有日期/时间函数使用的默认时区
      $row=$b->where("state=1")->find();
           
            $row['begintime']=date("Y-m-d H:i:s",$row['begintime']);
           
           // dump($row);
                   echo json_encode($row);
  }


}     

  







     

