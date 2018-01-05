<?php
namespace Home\Controller;
use Think\Controller;
class  MsallController extends Controller { //美食页面总体所有排序
    public function index(){
      $s=D('');
      $z =D('stype');
        $arr=json_decode(file_get_contents('php://input'));
        $id=$arr->id;//分类id-------------------------是否是shop表的stypeid????
        $address=$arr->address;//地区(地址)
        $px=$arr->px;//排序
       
        $yuyue=$arr->yuyue;//是否免预约
        $jiejia=$arr->jiejia;//节假日是否可用
        $chinum=$arr->chinum;//用餐人数
        $ctime=$arr->ctime;//用餐时段
        $sid=$arr->sid; //餐厅服务

        //这里是测试数据!!!!!!
        //$id=????;
       /* $address='北京';
        $px=0;
        $yuyue=2;
        $jiejia=0;
        $chinum=1;
        $ctime=0;
        $sid=0; */



       //在这里判断排序
        if($px==0){  //啥也不点
          $xpx=""; 
        }elseif($px==1){//智能排序
          $xpx=" order by id desc "; 
        }elseif($px==2){ //离我最近-------------没有地图后期修改!!!!!
          $xpx=" order by ... desc "; 
        }elseif($px==3){ //好评优先
           $xpx=" order by ping desc "; 
        }elseif($px==4){ //人气最高
           $xpx=" order by xl desc ";
        }
        
        //"餐厅服务"
        if($sid==0){ //不限
            $ctfu=" and sid=0 ";
        }elseif($sid==1){//外卖送餐
            $ctfu=" and sid!=0 ";
        }
      //判断分类id是否为0
        if($id!=0){
          $id=" stypeid=$id ";
        }else{
          $id="";
        }
      //判断address是否为0
        if($address!='0'){
          $address=" address like '%{$address}%' ";
        }else{
           $address="";
        }
      //节假日 1(可用)2(不可用)
        if($jiejia!=0){
          $jiejia=' and jiejia=$jiejia ';
        }else{
           $jiejia='';
        }
      //是否免预约 yuyue 1(免预约)2(需要预约)
        if($yuyue!=0){
          $yuyue=" and yue=$yuyue ";
        }else{
          $yuyue="";
        }
      //用餐时段ctime  1(早餐)2(午餐)3(下午茶)4(晚餐)5(夜宵)
        if($ctime!=0){
          $ctime=" and ctime like '%{$ctime}%' ";
        }else{
          $ctime="";
        }
      //用餐人数chinum 1(单人餐) 2(双人餐) 3(3-4人) 4(5-10人) 5(10人以上) 
        if($chinum!=0){
          $chinum=" and chinum like '%{$chinum}%' ";
        }else{
          $chinum="";
        }
        $row=$s->query("select * from shop where {$id} {$address} {$yuyue} {$jiejia} {$ctime} {$chinum} {$ctfu} {$xpx}");
        


        //dump($row);


        echo json_encode($row);




 }
}   
