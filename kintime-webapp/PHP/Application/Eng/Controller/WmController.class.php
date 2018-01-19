<?php
namespace Eng\Controller;
use Think\Controller;
class WmController extends Controller { //前台外卖页面
    public function index(){
        $m = D('eng_stype');
        $s = D('eng_shop');
        
        $arr=json_decode(file_get_contents('php://input'));
        $address=$arr->address;  //地址
        $num=$arr->num; //加载数量
        $id=$arr->id;          //外卖大类的id("11")

        $id=11;  //测试数据
        $num=0;
        $address='杭'; //测试数据
      if(isset($id)){
            $row = $m->where("pid = $id")->limit(0,8)->select();//查询外卖下的分类(就传外卖的id=11)
            $roww=$s->query("select id,stypeid,headpic,name,sming,ping,xl from eng_m_shop where address LIKE '%{$address}%' and state=1 limit {$num},6") ; //外卖下的店铺
      }
     
           
        $arr['1']=$row;
        $arr['2']=$roww;
       
        $result = array_reduce($arr, 'array_merge', array());//转换为2维数组
        // dump($result);
        echo json_encode($result);
    }

 }   
