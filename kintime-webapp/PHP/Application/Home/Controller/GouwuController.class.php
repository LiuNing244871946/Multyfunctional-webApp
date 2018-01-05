<?php
namespace Home\Controller;
use Think\Controller;
class GouwuController extends Controller { //前台购物页面
    public function index(){
        $m = D('stype');
        $s = D('shop');
        $z =D('stype'); 
        $arr=json_decode(file_get_contents('php://input'));
        $address=$arr->address;  //地址
        $num=$arr->num; //加载数量
        $id=$arr->id;          //购物大类的id("13")

        $id=13;  //测试数据
        $num=0;
        $address='浙'; //测试数据
      if(isset($id)){
            $row = $m->where("pid = $id")->limit(0,8)->select();//查询购物下的分类(就传购物的id=13)
            $roww=$s->query("select id,stypeid,headpic,name,sming,ping,xl from g_shop where address LIKE '%{$address}%' and state=1 limit {$num},6") ; //购物下的店铺
      }
     
           
        $arr['1']=$row;
        $arr['2']=$roww;
         $result = array_reduce($arr, 'array_merge', array());//转换为2维数组
        // dump($result);
        echo json_encode($result);
    }

 }   
